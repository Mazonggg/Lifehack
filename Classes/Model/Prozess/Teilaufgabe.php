<?php

namespace Model\Prozess;

use Model\DatenbankEintrag;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

class Teilaufgabe extends DatenbankEintrag {

    /**
     * @var Item
     */
    private $bedingung;

    /**
     * @var Item
     */
    private $belohnung;

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
        $this->bedingung = ItemFabrik::Instance()->erzeugeLeeresEintragObjekt();
        $this->belohnung = ItemFabrik::Instance()->erzeugeLeeresEintragObjekt();
        $this->dialog = new Dialog();
        $this->teilaufgabeArt = new Wertepaar('', '');
        $this->institut_art = new Wertepaar('', '');
    }

    /**
     * @return Item
     */
    public function getBedingung() {
        return $this->bedingung;
    }

    /**
     * @param Item $bedingung
     */
    public function setBedingung($bedingung) {
        $this->bedingung = $bedingung;
    }

    /**
     * @return Item
     */
    public function getBelohnung() {
        return $this->belohnung;
    }

    /**
     * @param Item $belohnung
     */
    public function setBelohnung($belohnung) {
        $this->belohnung = $belohnung;
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

