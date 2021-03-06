<?php

namespace Model\Fabrik\Stadtplan;

use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\IDatenbankEintrag;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Gebaeude;
use Model\Stadtplan\IKartenelement;

class GebaeudeFabrik extends KartenelementFabrik {
    /**
     * @var GebaeudeFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return GebaeudeFabrik
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
        return TabellenName::GEBAEUDE;
    }

    /**
     * @return IDatenbankEintrag
     */
    public function erzeugeLeeresEintragObjekt() {
        return new Gebaeude();
    }

    /**
     * @param Gebaeude $gebaeude
     * @param array $eintragdaten
     * @return IKartenelement
     */
    protected function setAttribute($gebaeude, $eintragdaten) {
        $gebaeude->setInterieurAussehen(
            SimpleWertepaarFabrik::erzeugeWertepaar(
                $eintragdaten[TabellenName::INTERIEUR_AUSSEHEN . Keyword::REF],
                $eintragdaten[TabellenName::INTERIEUR_AUSSEHEN . Keyword::URL]
            ));
        return parent::setAttribute($gebaeude, $eintragdaten);
    }


}

