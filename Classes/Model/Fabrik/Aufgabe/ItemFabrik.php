<?php

namespace Model\Fabrik\Aufgabe;

use Model\Prozess\Item;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Fabrik\DatenbankEintragFabrik;
use Model\IDatenbankEintrag;
use Model\SimpleWertepaarFabrik;

class ItemFabrik extends DatenbankEintragFabrik {
    /**
     * @var ItemFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return ItemFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return Item
     */
    public function erzeugeLeeresEintragObjekt() {
        return new Item();
    }

    /**
     * @param Item $item
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    protected function setAttribute($item, $eintragdaten) {
        $item->setId($eintragdaten[TabellenName::ITEM . Keyword::ID]);
        $item->setItemArt(SimpleWertepaarFabrik::erzeugeWertepaar(
            $eintragdaten[TabellenName::ITEM_ART . Keyword::REF],
            $eintragdaten[TabellenName::ITEM_ART . Keyword::NAME]));
        $item->setName($eintragdaten[TabellenName::ITEM . Keyword::NAME]);
        $item->setGewicht($eintragdaten[TabellenSpalten::ITEM_GEWICHT]);
        $item->setKonfiguration($eintragdaten[TabellenSpalten::ITEM_KONFIGURATION]);
        return $item;
    }
}

