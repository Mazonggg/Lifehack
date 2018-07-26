<?php

namespace Model\Fabrik\Stadtplan;

use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\IKartenelement;
use Model\Stadtplan\Wohnhaus;

class WohnhausFabrik extends GebaeudeFabrik {
    /**
     * @var WohnhausFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return WohnhausFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return string
     */
    public function getKartenelementTyp() {
        return TabellenName::WOHNHAUS;
    }

    /**
     * @return Wohnhaus
     */
    protected function erzeugeLeeresEintragObjekt() {
        return new Wohnhaus();
    }

    /**
     * @param Wohnhaus $wohnhaus
     * @param array $eintragdaten
     * @return IKartenelement
     */
    protected function setAttribute($wohnhaus, $eintragdaten) {
        $wohnhaus->setWohneinheiten($eintragdaten[TabellenSpalten::WOHNHAUS_WOHNEINHEITEN]);
        return parent::setAttribute($wohnhaus, $eintragdaten);
    }
}

