<?php

namespace Model\Prozess;

use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;
use Model\SimpleWertepaarFabrik;
use Model\Wertepaar;

class Item extends DatenbankEintrag {

    /**
     * @var Wertepaar
     */
    private $item_art;
    /**
     * @var string
     */
    private $name = '';
    /**
     * @var int
     */
    private $gewicht = -1;

    /**
     * @var string
     */
    private $konfiguration = '';

    /**
     * Item constructor.
     */
    public function __construct() {
        $this->item_art = SimpleWertepaarFabrik::erzeugeWertepaar();
    }

    /**
     * @return Wertepaar
     */
    public function getItemArt() {
        return $this->item_art;
    }

    /**
     * @param Wertepaar $item_art
     */
    public function setItemArt($item_art) {
        $this->item_art = $item_art;
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
     * @return int
     */
    public function getGewicht() {
        return $this->gewicht;
    }

    /**
     * @param int $gewicht
     */
    public function setGewicht($gewicht) {
        $this->gewicht = $gewicht;
    }

    /**
     * @return string
     */
    public function getKonfiguration() {
        return $this->konfiguration;
    }

    /**
     * @param string $konfiguration
     */
    public function setKonfiguration($konfiguration) {
        $this->konfiguration = $konfiguration;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::ITEM;
    }
}

