<?php

namespace Konfigurator\Fabrik\Aufgabe;

use Datenbank\DatenbankEintrag;
use Konfigurator\Fabrik\DatenbankEintragFabrik;
use Model\Aufgabe\Item;
use Model\Enum\Keyword;
use Model\Enum\TabellenSpalten;
use Model\Enum\TabellenName;

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
     * @param $eintragdaten
     * @return DatenbankEintrag
     */
    protected function baueEintragObjekt($eintragdaten) {
        return new Item(
            $eintragdaten[TabellenName::ITEM . Keyword::ID],
            $eintragdaten[TabellenName::ITEM_ART . Keyword::NAME],
            $eintragdaten[TabellenName::ITEM . Keyword::NAME],
            $eintragdaten[TabellenSpalten::ITEM_GEWICHT],
            $eintragdaten[TabellenSpalten::ITEM_KONFIGURATION]
        );
    }
}

