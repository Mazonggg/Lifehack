<?php

namespace Datenbank\Model;

class Relation {
    /**
     * @var string
     */
    private $tabellenname = "";
    /**
     * @var string
     */
    private $primaerschluessel = "";
    /**
     * @var string
     */
    private $fremdschluessel = "";

    /**
     * Fremdschluessel constructor.
     * @param string $tabellenname
     * @param string $primaerschluessel
     * @param string $fremdschluessel
     */
    public function __construct($tabellenname, $primaerschluessel, $fremdschluessel) {
        $this->tabellenname = $tabellenname;
        $this->primaerschluessel = $primaerschluessel;
        $this->fremdschluessel = $fremdschluessel;
    }

    /**
     * @return string
     */
    public function getTabellenname() {
        return $this->tabellenname;
    }

    /**
     * @return string
     */
    public function getPrimaerschluessel() {
        return $this->primaerschluessel;
    }

    /**
     * @return string
     */
    public function getFremdschluessel() {
        return $this->fremdschluessel;
    }
}

