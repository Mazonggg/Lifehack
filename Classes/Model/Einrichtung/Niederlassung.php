<?php

namespace Model\Einrichtung;

use Model\Konstanten\TabellenName;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Gebaeude;
use Model\Wertepaar;

class Niederlassung extends Gebaeude {

    /**
     * @var Wertepaar
     */
    private $institut;

    /**
     * Niederlassung constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->institut = SimpleWertepaarFabrik::erzeugeWertepaar();
    }

    /**
     * @param Wertepaar $institut
     */
    public function setInstitut($institut) {
        $this->institut = $institut;
    }

    /**
     * @return Wertepaar
     */
    public function getInstitut() {
        return $this->institut;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::NIEDERLASSUNG;
    }
}

