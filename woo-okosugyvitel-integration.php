<?php
/**
 * Plugin Name: Woo Okosugyvitel Integration
 * Description: Wordpress (WooCommerce) webáruház integráció az Okos-Ügyvitel rendszerével
 * Version: 1.0
 * Author: OkosUgyvitel.hu
 * Author URI: https://okosugyvitel.hu
 * Text Domain: woo-okosugyvitel-integration
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit;

class WOO_OkosUgyvitel_Integration
{
  const TEXTDOMAIN = 'woo-okosugyvitel-integration';

  const METADATA_TAXNUMBER = 'wc_ou_taxnumber';
  const METADATA_UNIT = 'wc_ou_unit';

  protected static $instance = null;

  protected static $out;

  public static function instance()
  {
    if (self::$instance === null)
    {
      self::$instance = new static();
    }
    return self::$instance;
  }

  /**
   * WC_OkosUgyvitel_Integration constructor.
   */
  public function __construct()
  {
    add_action('plugins_loaded', array($this, 'init'));
  }

  /**
   * Init actions and filters.
   */
  public function init()
  {
    load_plugin_textdomain(self::TEXTDOMAIN, FALSE, plugin_basename(dirname(__FILE__)) . '/languages');

    add_action('woocommerce_product_options_general_product_data', array(__CLASS__, 'product_options_advanced'));
    add_action('woocommerce_admin_process_product_object', array(__CLASS__, 'product_object_save'));

    add_filter('woocommerce_checkout_fields', array($this, 'checkout_tax_number_field'));
    add_action('woocommerce_checkout_update_order_meta', array($this, 'checkout_update_order_meta'));

    add_action('woocommerce_admin_order_data_after_billing_address', array($this, 'order_data_after_billing_address'));
  }

  /**
   * Expands product form with unit of quantity input field.
   */
  public static function product_options_advanced()
  {
    global $post;
    woocommerce_wp_text_input(array(
      'id' => 'wc_ou_unit',
      'label' => __('Unit of quantity', self::TEXTDOMAIN) . self::$out,
      'placeholder' => __('piece', self::TEXTDOMAIN),
      'desc_tip' => true,
      'value' => esc_attr($post->wc_ou_unit),
      'description' => __('Unit of quantity', self::TEXTDOMAIN)
    ));
  }

  /**
   * Save unit of quantity into product meta_data from product form.
   * @param $product
   */
  public static function product_object_save($product)
  {
    $unit = !empty($_REQUEST[self::METADATA_UNIT]) ? sanitize_text_field($_REQUEST[self::METADATA_UNIT]) : '';
    $product->update_meta_data(self::METADATA_UNIT, $unit);
  }

  /**
   * Expands checkout form with customers tax number input field.
   * @param $fields
   * @return mixed
   */
  public static function checkout_tax_number_field($fields)
  {
    $fields['billing'][self::METADATA_TAXNUMBER] = array(
      'label' => __('Tax number', self::TEXTDOMAIN),
      'required' => false,
      'class' => array('form-row-wide'),
      'clear' => true,
      'priority' => 99
    );
    return $fields;
  }

  /**
   * Save customers tax number and product items units of quantity into meta_data
   * @param $orderid
   */
  public static function checkout_update_order_meta($orderid)
  {
    if (!empty($_POST[self::METADATA_TAXNUMBER]))
    {
      update_post_meta($orderid, self::METADATA_TAXNUMBER, sanitize_text_field($_POST[self::METADATA_TAXNUMBER]));
    }

    $order = new WC_Order($orderid);
    foreach($order->get_items() as $item)
    {
      $unit = get_post_meta($item->get_product_id(), self::METADATA_UNIT);
      if (!empty($unit))
      {
        $item->add_meta_data(self::METADATA_UNIT, $unit);
        $item->save();
      }
    }
  }

  /**
   * Display customers tax number on (admin) order detailed report
   * @param $order
   */
  public static function order_data_after_billing_address($order)
  {
    $taxnumber = get_post_meta($order->get_id(), self::METADATA_TAXNUMBER, true);
    if (!empty($taxnumber))
    {
      echo '<p><strong>' . __('Tax number', self::TEXTDOMAIN) . '</strong>: '. $taxnumber . '</p>';
    }
  }

}

// Global for backwards compatibility
$GLOBALS['woo_okosugyvitel_integration'] = WOO_OkosUgyvitel_Integration::instance();