<?php

namespace Model\Fabrik\Aufgabe;


use Model\Prozess\Aufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Fabrik\DatenbankEintragFabrik;
use Model\IDatenbankEintrag;

class AufgabeFabrik extends DatenbankEintragFabrik {
    /**
     * @var AufgabeFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return AufgabeFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->teilaufgabeFabrik = TeilaufgabeFabrik::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var TeilaufgabeFabrik
     */
    private $teilaufgabeFabrik;

    /**
     * @return Aufgabe
     */
    protected function erzeugeLeeresEintragObjekt() {
        return new Aufgabe();
    }

    /**
     * @param Aufgabe $aufgabe
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    protected function setAttribute($aufgabe, $eintragdaten) {
        $teilaufgaben = [];
        if ($eintragdaten[TabellenName::TEILAUFGABE]) {
            foreach ($eintragdaten[TabellenName::TEILAUFGABE] as $teilaufgabeDaten) {
                array_push($teilaufgaben, $this->teilaufgabeFabrik->erzeugeEintragObjekt($teilaufgabeDaten));
            }
        }
        $aufgabe->setId($eintragdaten[TabellenName::AUFGABE . Keyword::ID]);
        $aufgabe->setBezeichnung($eintragdaten[TabellenSpalten::AUFGABE_BEZEICHNUNG]);
        $aufgabe->setGesetzesgrundlage($eintragdaten[TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE]);
        $aufgabe->setTeilaufgaben($teilaufgaben);
        return $aufgabe;
    }
}

