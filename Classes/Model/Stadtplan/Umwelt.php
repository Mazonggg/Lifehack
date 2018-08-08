<?php

namespace Model\Stadtplan;

use Model\Konstanten\TabellenName;

class Umwelt extends Kartenelement {

    /**
     * @var bool
     */
    private $begehbar = true;

    /**
     * @var string
     */
    private $bezeichnung = "";

    /**
     * Umwelt constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function isBegehbar() {
        return $this->begehbar;
    }

    /**
     * @param bool $begehbar
     */
    public function setBegehbar($begehbar) {
        $this->begehbar = $begehbar;
    }

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
    public function getTabelle() {
        return TabellenName::UMWELT;
    }
}

