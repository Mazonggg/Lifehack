<?php

namespace Model\Prozess;

use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;

class Aufgabe extends DatenbankEintrag {

    /**
     * @var string
     */
    private $bezeichnung = '';
    /**
     * @var string
     */
    private $gesetzesgrundlage = '';

    /**
     * @var Teilaufgabe[]
     */
    private $teilaufgaben = [];

    /**
     * @return string
     */
    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    /**
     * @param string $bezeichnung
     */
    public function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
    }

    /**
     * @return string
     */
    public function getGesetzesgrundlage() {
        return $this->gesetzesgrundlage;
    }

    /**
     * @param string $gesetzesgrundlage
     */
    public function setGesetzesgrundlage($gesetzesgrundlage) {
        $this->gesetzesgrundlage = $gesetzesgrundlage;
    }

    /**
     * @return Teilaufgabe[]
     */
    public function getTeilaufgaben() {
        return $this->teilaufgaben;
    }

    /**
     * @param Teilaufgabe[] $teilaufgaben
     */
    public function setTeilaufgaben($teilaufgaben) {
        $this->teilaufgaben = $teilaufgaben;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::AUFGABE;
    }
}

