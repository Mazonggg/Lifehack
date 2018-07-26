<?php

namespace Model;


use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Fabrik\IDatenbankEintragFabrik;
use Model\Fabrik\Stadtplan\KartenelementFabrik;
use Pattern\SingletonPattern;

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
    public function arrayZuObjekten($elementdatens, $fabrik) {
        /**
         * @var IDatenbankEintrag[] $eintraege
         */
        $eintraege = [];
        foreach ($elementdatens as $elementdaten) {
            if (!($fabrik instanceof KartenelementFabrik) || $this->istRichtigeElementArt($elementdaten, $fabrik)) {
                array_push($eintraege, $fabrik->erzeugeEintragObjekt($elementdaten));
            }
        }
        return $eintraege;
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

