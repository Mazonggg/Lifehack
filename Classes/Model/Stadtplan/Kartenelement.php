<?php

namespace Model\Stadtplan;

use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

abstract class Kartenelement extends DatenbankEintrag implements IKartenelement {

    /**
     * @var Abmessung[]
     */
    protected $abmesungen = [];

    /**
     * @var Wertepaar
     */
    protected $kartenelementAussehen;

    /**
     * @var Wertepaar
     */
    protected $kartenelementArt;

    /**
     * Kartenelement constructor.
     */
    public function __construct() {
        $this->kartenelementAussehen = new Wertepaar('', '');
    }

    /**
     * @return Abmessung[]
     */
    public function getAbmessungen() {
        return $this->abmesungen;
    }

    /**
     * @return Wertepaar
     */
    public function getKartenelementAussehen() {
        return $this->kartenelementAussehen;
    }

    /**
     * @return Wertepaar
     */
    public function getKartenelementArt() {
        return $this->kartenelementArt;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::KARTENELEMENT;
    }

    /**
     * @param Abmessung[] $abmesungen
     */
    public function setAbmesungen($abmesungen) {
        $this->abmesungen = $abmesungen;
    }

    /**
     * @param Wertepaar $kartenelementAussehen
     */
    public function setKartenelementAussehen($kartenelementAussehen) {
        $this->kartenelementAussehen = $kartenelementAussehen;
    }

    /**
     * @param Wertepaar $kartenelementArt
     */
    public function setKartenelementArt($kartenelementArt) {
        $this->kartenelementArt = $kartenelementArt;
    }
}

