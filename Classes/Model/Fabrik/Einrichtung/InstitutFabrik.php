<?php

namespace Model\Fabrik\Einrichtung;

use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Fabrik\DatenbankEintragFabrik;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Institut;
use Model\Wertepaar;

class InstitutFabrik extends DatenbankEintragFabrik {
    /**
     * @var InstitutFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return InstitutFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return Institut
     */
    public function erzeugeLeeresEintragObjekt() {
        return new Institut();
    }

    /**
     * @param Institut $institut
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    protected function setAttribute($institut, $eintragdaten) {
        $institut->setId($eintragdaten[TabellenName::INSTITUT . Keyword::ID]);
        $institut->setName($eintragdaten[TabellenName::INSTITUT . Keyword::NAME]);
        $institut->setBeschreibung($eintragdaten[TabellenSpalten::INSTITUT_BESCHREIBUNG]);
        $institut->setInstitutArt(new Wertepaar(
            $eintragdaten[TabellenName::INSTITUT_ART . Keyword::REF],
            $eintragdaten[TabellenName::INSTITUT_ART . Keyword::NAME]
        ));
        return $institut;
    }
}

