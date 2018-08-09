<?php

namespace Anwendung\Konfigurator\Stadtplan;

use Anwendung\Konfigurator\Modul;
use Anwendung\Konfigurator\Stadtplan\Kachel\IKachel;
use Anwendung\Konfigurator\Stadtplan\Kachel\Model\LeereKachelAdapter;
use Anwendung\Konfigurator\Stadtplan\Kachel\Model\Stadtplan\KartenelementKachelAdapter;
use Model\IDatenbankEintrag;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\IKartenelement;
use Model\Stadtplan\Kartenschreiber;
use Model\Stadtplan\SimpleAbmessungFabrik;

class StadtplanModul extends Modul {
    /**
     * @var StadtplanModul|null
     */
    private static $_instance = null;

    /**
     * @return StadtplanModul
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->kartenschreiber = Kartenschreiber::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var Kartenschreiber
     */
    private $kartenschreiber;

    /**
     * @var Abmessung[];
     */
    private $abmessungen = [];

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
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    protected function getContainerHtml($eintraege) {
        $kachelnHtml = $this->getInhaltHtml($eintraege);
        $stadtplanAbmessung = $this->getStadtplanAbmessung();
        $html =
            '<div id="stadtplan_overlay" class="stadtplan_overlay ausgeblendet display_none"></div>' .
            '<div id="stadtplan" class="stadtplan" ' .
            'data-xmin="' . $stadtplanAbmessung->xMin() . '" ' .
            'data-ymin="' . $stadtplanAbmessung->yMin() . '" ' .
            'style="grid-template-columns: repeat(' .
            $stadtplanAbmessung->getBreite() . ', ' . self::KACHELGROESZE . 'px); ' .
            'grid-template-rows: repeat(' .
            $stadtplanAbmessung->getHoehe() . ', ' . self::KACHELGROESZE . 'px);">';
        $html .= $kachelnHtml;
        return $html . "</div>";
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhaltHtml($eintraege) {
        /**
         * @var IKachel[] $kacheln
         */
        $kacheln = $this->erzeugeEintragAdapters($eintraege);
        $html = '';
        foreach ($kacheln as $kachel) {
            $html .= $kachel->getEintragHtml();
        }
        return $html . $this->erzeugeEintragAdapter(null)[0]->getEintragHtml();
    }

    /**
     * @return string
     */
    public function getId() {
        return 'stadtplan_container';
    }

    /**
     * @param IKartenelement $eintrag
     * @return IKachel[]
     */
    protected function erzeugeEintragAdapter($eintrag) {
        if (empty($eintrag)) {
            return [new LeereKachelAdapter(SimpleAbmessungFabrik::erzeugeAbmessung('1/1/1/1', ''))];
        } else {
            $kacheln = [];
            foreach ($eintrag->getAbmessungen() as $abmessung) {
                array_push($this->abmessungen, $abmessung);
                array_push($kacheln, new KartenelementKachelAdapter($abmessung, $eintrag));
            }
            return $kacheln;
        }
    }

    /**
     * @return Abmessung
     */
    public function getStadtplanAbmessung() {
        return $this->kartenschreiber->getKartengroesse($this->abmessungen, self::RANDBREITE);
    }
}

