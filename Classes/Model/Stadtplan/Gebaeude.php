<?php

namespace Model\Stadtplan;

use Model\Konstanten\TabellenName;
use Model\SimpleWertepaarFabrik;
use Model\Wertepaar;

class Gebaeude extends Kartenelement {

    /**
     * @var Wertepaar
     */
    private $interieurAussehen;

    /**
     * Gebaeude constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->interieurAussehen = SimpleWertepaarFabrik::erzeugeWertepaar();
    }

    /**
     * @param Wertepaar $interieurAussehen
     */
    public function setInterieurAussehen($interieurAussehen) {
        $this->interieurAussehen = $interieurAussehen;
    }

    /**
     * @return Wertepaar
     */
    public function getInterieurAussehen() {
        return $this->interieurAussehen;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::GEBAEUDE;
    }
}

