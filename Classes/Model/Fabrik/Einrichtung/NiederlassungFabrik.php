<?php

namespace Model\Fabrik\Einrichtung;

use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Fabrik\Stadtplan\GebaeudeFabrik;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Niederlassung;
use Model\Stadtplan\IKartenelement;
use Model\Wertepaar;

class NiederlassungFabrik extends GebaeudeFabrik {
    /**
     * @var NiederlassungFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return NiederlassungFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getKartenelementTyp() {
        return TabellenName::NIEDERLASSUNG;
    }

    /**
     * @return IDatenbankEintrag
     */
    public function erzeugeLeeresEintragObjekt() {
        return new Niederlassung();
    }

    /**
     * @param Niederlassung $niederlassung
     * @param array $eintragdaten
     * @return IKartenelement
     */
    protected function setAttribute($niederlassung, $eintragdaten) {
        $niederlassung->setInstitut(new Wertepaar(
            $eintragdaten[TabellenName::NIEDERLASSUNG . '_' . TabellenName::INSTITUT . Keyword::REF],
            $eintragdaten[TabellenName::INSTITUT . Keyword::NAME]
        ));
        return parent::setAttribute($niederlassung, $eintragdaten);
    }
}

