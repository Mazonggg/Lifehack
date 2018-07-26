<?php

namespace Model\Fabrik\Stadtplan;

use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Kartenelement;
use Model\Stadtplan\Umwelt;

class UmweltFabrik extends KartenelementFabrik {
    /**
     * @var UmweltFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return UmweltFabrik
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
        return TabellenName::UMWELT;
    }

    /**
     * @return Umwelt
     */
    protected function erzeugeLeeresEintragObjekt() {
        return new Umwelt();
    }

    /**
     * @param Umwelt $umwelt
     * @param array $eintragdaten
     * @return Kartenelement
     */
    protected function setAttribute($umwelt, $eintragdaten) {
        $umwelt->setBegehbar($eintragdaten[TabellenSpalten::UMWELT_BEGEHBAR]);
        $umwelt->setBezeichnung($eintragdaten[TabellenSpalten::UMWELT_BEZEICHUNG]);
        return parent::setAttribute($umwelt, $eintragdaten);
    }


}

