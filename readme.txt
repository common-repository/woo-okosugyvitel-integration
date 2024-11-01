=== WooCommerce & OkosUgyvitel Integration ===
Contributors: okosugyvitel
Tags: okosugyvitel.hu, woocommerce, szamlazo, magyar
Requires at least: 4.4
Tested up to: 5.0
Stable tag: 1.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Okos Ügyvitel és WooCommerce összekötése.

== Description ==

A bővítmény lehetővé teszti mennyiségi egység használatát a WooCommerce termékek számára, valamint a rendelési folyamat során az megrendelők megadhatják az adószámukat.

Fontos hangsújozni, hogy a bővítmény önmagában nem elegendő, csupán a WooCommerce bővítmény lehetőségeit bővíti ki, így a WooCommerce bővítmény telepítése/megléte előfeltétele a használatának.
Az okosugyvitel.hu a WooCommerce REST API-n keresztül képes elérni a rendeléseket és feltölteni a készlet információkat. Hogy ez működhessen a WooCommerce `Haladó` beállításainál a `REST API`-nál egy kulcsot kell létrehozni. Ezt követően az okosugyvitel.hu-t kell felkeresni. A szükséges beállítások elvégzéséhez keresse fel az [okosugyvitel.hu](https://okosugyvitel.hu) ügyfélszolgálatát.
Működő kapcsolat esetné az okosugyvitel.hu az ügyviteli rendszerben beállított rendeléseket letölti és a rendelések státuszát teljesítettre állítja. Ezt követően az ügyviteli rendszerben történt készlet változásokat feltölti a webáruházba.

== Installation ==

1. Töltsd fel a bővítmény fájlokat a `/wp-content/plugins/woo-okosugyvitel-integration` könyvtárba, vagy telepítsd a WordPress bővítmények képernyőn keresztül.
1. Aktíváld a bővítményt a 'Bővítmények' képernyőn keresztül.

== Frequently Asked Questions ==

= Követelmény a bővítmény használata? =

Nem követelmény, de alapértelmezetten a WooCommerce rendelési folyamata nem tartalmazza a vevő adószám megadási lehetőségét és a mennyiségi egység kezelését. Ezekre az információkra szükség van a megrendelések további kezeléséhez és hogy számla készülhessen belőle.
Nincs akadája, hogy más módon valósítsa meg a szükséges adatok megadását, ebben az esetben kérem vegye fel a kapcsolatot az okosugyvitel.hu ügyfélszolgálatával.

= Milyen adatokat tud fogadni az okosugyvitel.hu? =

A vevői megrendelések kerülnek áttöltésre valamint a termék készlet és ár adatok töltődnek át a webáruházba

= Milyen státuszú megrendelések kerülnek letöltésre? =

Mivel a folyamatok webáruházanként eltérőek lehetnek, lehetőség van egyedileg meghatározni a letöltendő rendelések státuszait. Az okosugyvitel.hu ügyfélszolgálata segítséget tud nyujtani.

== Changelog ==

= 20190131 =
Első publikált verzió