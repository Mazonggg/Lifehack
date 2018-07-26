<?php

namespace Model;

final class Wertepaar {

    /**
     * @var string
     */
    private $schluessel = "";
    /**
     * @var string
     */
    private $wert = "";

    /**
     * Wertepaar constructor.
     * @param string $schluessel
     * @param string $wert
     */
    public function __construct($schluessel, $wert) {
        $this->schluessel = $schluessel;
        $this->wert = $wert;
    }

    /**
     * @return string
     */
    public function getSchluessel() {
        return $this->schluessel;
    }

    /**
     * @return string
     */
    public function getWert() {
        return $this->wert;
    }
}

