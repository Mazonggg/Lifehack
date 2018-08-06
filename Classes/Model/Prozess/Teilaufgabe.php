<?php

namespace Model\Prozess;

use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

class Teilaufgabe extends DatenbankEintrag {

    /**
     * @var string
     */
    private $bedingungId;

    /**
     * @var string
     */
    private $belohnungId;

    /**
     * @var Wertepaar
     */
    private $teilaufgabeArt;

    /**
     * @var Dialog
     */
    private $dialog;

    /**
     * @var Wertepaar
     */
    private $institut_art;

    /**
     * Teilaufgabe constructor.
     */
    public function __construct() {
        $this->dialog = new Dialog();
        $this->teilaufgabeArt = new Wertepaar('', '');
        $this->institut_art = new Wertepaar('', '');
    }


    /**
     * @return string
     */
    public function getBedingungId() {
        return $this->bedingungId;
    }

    /**
     * @param string $bedingungId
     */
    public function setBedingungId($bedingungId) {
        $this->bedingungId = $bedingungId;
    }

    /**
     * @return string
     */
    public function getBelohnungId() {
        return $this->belohnungId;
    }

    /**
     * @param string $belohnungId
     */
    public function setBelohnungId($belohnungId) {
        $this->belohnungId = $belohnungId;
    }

    /**
     * @return Wertepaar
     */
    public function getTeilaufgabeArt() {
        return $this->teilaufgabeArt;
    }

    /**
     * @param Wertepaar $teilaufgabeArt
     */
    public function setTeilaufgabeArt($teilaufgabeArt) {
        $this->teilaufgabeArt = $teilaufgabeArt;
    }

    /**
     * @return Dialog
     */
    public function getDialog() {
        return $this->dialog;
    }

    /**
     * @param Dialog $dialog
     */
    public function setDialog($dialog) {
        $this->dialog = $dialog;
    }

    /**
     * @return Wertepaar
     */
    public function getInstitutArt() {
        return $this->institut_art;
    }

    /**
     * @param Wertepaar $institut_art
     */
    public function setInstitutArt($institut_art) {
        $this->institut_art = $institut_art;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::TEILAUFGABE;
    }
}

