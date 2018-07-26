<?php

namespace Konfigurator\HtmlGenerator\Stadtplan;

use Konfigurator\IHtmlObjekt;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\Kartenelement;
use Model\Stadtplan\Kartenschreiber;
use Pattern\SingletonPattern;

final class StadtplanGenerator extends SingletonPattern implements IHtmlObjekt {
    /**
     * @var StadtplanGenerator|null
     */
    private static $_instance = null;

    /**
     * @param Kartenelement[] $items
     * @return StadtplanGenerator
     */
    public static function Instance($items = []) {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->kartenschreiber = Kartenschreiber::Instance();
            self::$_instance->kartenelementSammlung = $items;
        }
        return self::$_instance;
    }

    /**
     * @var Kartenelement[]
     */
    private $kartenelementSammlung;

    /**
     * @var Kartenschreiber
     */
    private $kartenschreiber;

    const RANDBREITE = 1;

    /**
     * @return array
     */
    private function getAbmessungen() {
        /**
         * @var Abmessung[]
         */
        $positionen = [];
        foreach ($this->kartenelementSammlung as $kartenelement) {
            $positionen = array_merge($positionen, $kartenelement->getPositionen());
        }
        return $this->kartenschreiber->getKartengroesse($positionen);
    }


    // TODO Interface oder Pattern fuer CSS & HTML Ausgabe
    public function getCssUrl() {
        return "css/stadtplan.css";
    }

    /**
     * @return string
     */
    public function getHtml() {
        $html = "<div id=\"stadtplan\" class=\"stadtplan\">";
        $abmessungen = $this->getAbmessungen();
        $kacheln = [];
        foreach ($this->kartenelementSammlung as $kartenelement) {
            foreach ($kartenelement->getPositionen() as $position) {
                $id = "id=" . $kartenelement->getPositionen()[0]->getIdentifier();
                $class = "kachel kartenelement";
                $background = "background-image:url('img/" . $kartenelement->getKartenelementAussehen() . "')";
                $xmin = 1 + $position->getLinkeKoordinate() - $abmessungen[Kartenschreiber::XMIN];
                $xmax = 1 + $position->getRechteKoordinate() - $abmessungen[Kartenschreiber::XMIN];
                $grid_column = $xmin . " / " . $xmax;
                $ymin = 1 + $position->getObereKoordinate() - $abmessungen[Kartenschreiber::YMIN];
                $ymax = 1 + $position->getUntereKoordinate() - $abmessungen[Kartenschreiber::YMIN];
                $grid_row = $ymin . " / " . $ymax;
                array_push(
                    $kacheln,
                    "<div    class=\"$class\" 
                                $id
                                style=\"
                                grid-column:" . $grid_column . ";
                                grid-row:" . $grid_row . ";
                              $background; \" >
                        </div>");
            }
        }
        for ($y = $abmessungen[Kartenschreiber::YMIN]; $y < $abmessungen[Kartenschreiber::YMAX]; $y++) {
            for ($x = $abmessungen[Kartenschreiber::XMIN]; $x < $abmessungen[Kartenschreiber::XMAX]; $x++) {
                $id = "";
                $class = "kachel";
                $background = "";
                $grid_column = 1 + $x - $abmessungen[Kartenschreiber::XMIN];
                $grid_row = 1 + $y - $abmessungen[Kartenschreiber::YMIN];
                if (!$this->istVonElementBelegt($x, $y)) {
                    array_push(
                        $kacheln,
                        "<div    class=\"$class\" 
                                $id
                                style=\"
                                grid-column:" . $grid_column . ";
                                grid-row:" . $grid_row . ";
                              $background; \" >
                        </div>");
                }
            }
        }
        return $html . implode($kacheln) . "</div>";
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function istVonElementBelegt($x, $y) {
        foreach ($this->kartenelementSammlung as $kartenelement) {
            foreach ($kartenelement->getPositionen() as $position) {
                if ($position->isInnerhalb($x, $y)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return "";
    }
}

