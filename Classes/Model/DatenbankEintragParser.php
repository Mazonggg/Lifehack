<?php

namespace Model;


use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Fabrik\IDatenbankEintragFabrik;
use Model\Fabrik\Stadtplan\KartenelementFabrik;
use Singleton\SingletonPattern;

class DatenbankEintragParser extends SingletonPattern {
    /**
     * @var DatenbankEintragParser|null
     */
    protected static $_instance = null;

    /**
     * @return DatenbankEintragParser
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param array $elementdatens
     * @param IDatenbankEintragFabrik $fabrik
     * @return IDatenbankEintrag[]
     */
    public function arrayZuDatenbankEintraegen($elementdatens, $fabrik) {
        /**
         * @var IDatenbankEintrag[] $eintraege
         */
        $eintraege = [];
        foreach ($elementdatens as $elementdaten) {
            $eintrag = $this->arrayZuDatenbankEintrag($elementdaten, $fabrik);
            if ($eintrag !== null) {
                array_push($eintraege, $eintrag);
            }
        }
        return $eintraege;
    }

    /**
     * @param array $elementdaten
     * @param IDatenbankEintragFabrik $fabrik
     * @return IDatenbankEintrag|null
     */
    public function arrayZuDatenbankEintrag($elementdaten, $fabrik) {
        $eintrag = null;
        if (!($fabrik instanceof KartenelementFabrik) || $this->istRichtigeElementArt($elementdaten, $fabrik)) {
            $eintrag = $fabrik->erzeugeEintragObjekt($elementdaten);
        }
        return $eintrag;
    }


    /**
     * @param array $elementdaten
     * @param KartenelementFabrik $fabrik
     * @return bool
     */
    private function istRichtigeElementArt($elementdaten, $fabrik) {
        return $elementdaten[TabellenName::KARTENELEMENT_ART . Keyword::NAME] == $fabrik->getKartenelementTyp();
    }
}

