<?php

namespace Model\Einrichtung;

use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;
use Model\SimpleWertepaarFabrik;
use Model\Wertepaar;

class Institut extends DatenbankEintrag {

    /**
     * @var Niederlassung[]
     */
    private $niederlassungen = [];

    /**
     * @var string
     */
    private $name = '';
    /**
     * @var string
     */
    private $beschreibung = '';

    /**
     * @var Wertepaar
     */
    private $institut_art;

    /**
     * Einrichtung constructor.
     */
    public function __construct() {
        $this->institut_art = SimpleWertepaarFabrik::erzeugeWertepaar();
    }

    /**
     * @return Niederlassung[]
     */
    public function getNiederlassungen() {
        return $this->niederlassungen;
    }

    /**
     * @param Niederlassung[] $niederlassungen
     */
    public function setNiederlassungen($niederlassungen) {
        $this->niederlassungen = $niederlassungen;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBeschreibung() {
        return $this->beschreibung;
    }

    /**
     * @param string $beschreibung
     */
    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
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
        return TabellenName::INSTITUT;
    }
}

