<?php

namespace Model\Stadtplan;

use Model\Konstanten\TabellenName;

class Wohnhaus extends Gebaeude {

    /**
     * @var int
     */
    private $wohneinheiten = 0;

    /**
     * @return int
     */
    public function getWohneinheiten() {
        return $this->wohneinheiten;
    }

    /**
     * @param int $wohneinheiten
     */
    public function setWohneinheiten($wohneinheiten) {
        $this->wohneinheiten = $wohneinheiten;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::WOHNHAUS;
    }
}

