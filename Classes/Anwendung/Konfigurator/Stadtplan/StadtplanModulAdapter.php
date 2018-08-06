<?php

namespace Anwendung\Konfigurator\Stadtplan;

use Anwendung\Konfigurator\ModulAdapter;
use Anwendung\Konfigurator\Stadtplan\KachelAdapter\IKachel;
use Anwendung\Konfigurator\Stadtplan\KachelAdapter\SimpleKachelFabrik;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\Kartenschreiber;
use Model\Stadtplan\SimpleAbmessungFabrik;

class StadtplanModulAdapter extends ModulAdapter {
    /**
     * @var StadtplanModulAdapter|null
     */
    private static $_instance = null;

    /**
     * @param IKachel[] $kacheln
     * @return StadtplanModulAdapter
     */
    public static function Instance($kacheln = []) {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->kartenschreiber = Kartenschreiber::Instance();
            self::$_instance->kacheln = $kacheln;
        }
        return self::$_instance;
    }

    /**
     * @var IKachel[]
     */
    private $kacheln;

    /**
     * @var Kartenschreiber
     */
    private $kartenschreiber;

    const RANDBREITE = 16;
    const KACHELGROESZE = 25;

    /**
     * @return string
     */
    public function getCssUrl() {
        return "css/stadtplan.css";
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return "js/stadtplan.js";
    }

    /**
     * @return string
     */
    protected function getInhalt() {
        $abmessungen = $this->getStadtplanGroesze();
        $html =
            '<div id="stadtplan_overlay" class="stadtplan_overlay ausgeblendet display_none"></div>' .
            '<div id="stadtplan" class="stadtplan" ' .
            'data-xmin="' . $abmessungen->xMin() . '" ' .
            'data-ymin="' . $abmessungen->yMin() . '" ' .
            'style="grid-template-columns: repeat(' .
            $abmessungen->getBreite() . ', ' . self::KACHELGROESZE . 'px); ' .
            'grid-template-rows: repeat(' .
            $abmessungen->getHoehe() . ', ' . self::KACHELGROESZE . 'px);">';
        foreach ($this->kacheln as $kachel) {
            $html .= $kachel->getKachelHtml();
        }
        $html .= SimpleKachelFabrik::erzeugeLeereKachel(SimpleAbmessungFabrik::erzeugeAbmessung('1/1/1/1', ''))->getKachelHtml();
        return $html . "</div>";
    }

    /**
     * @return Abmessung
     */
    public function getStadtplanGroesze() {
        /**
         * @var Abmessung[]
         */
        $abmessungen = [];
        foreach ($this->kacheln as $kachel) {
            array_push($abmessungen, $kachel->getAbmessung());
        }
        return $this->kartenschreiber->getKartengroesse($abmessungen, self::RANDBREITE);
    }

    /**
     * @return string
     */
    public function getId() {
        return 'stadtplan_container';
    }

    /**
     * @return string
     */
    public function getClass() {
        return $this->getId();
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }
}

