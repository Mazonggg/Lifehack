<?php

namespace Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Singleton\ISingleton;

class Kartenschreiber implements ISingleton {

    /**
     * @var Kartenschreiber
     */
    private static $_instance;

    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param array $legende
     * @return array
     */
    public function schreibeKarte($legende) {
        return $this->getKartenLegende($legende);
    }

    /**
     * @param array $legende
     * @return array
     */
    private function getKartenLegende($legende) {
        $karte = [];
        foreach ($legende as $eintrag) {
            $abmessungen = [];
            foreach (explode(',', $eintrag[TabellenName::ABMESSUNG]) as $abmessung) {
                array_push($abmessungen, $abmessung);
            }
            $karte[$eintrag[TabellenName::KARTENELEMENT . Keyword::ID]] = $abmessungen;
        }
        return $karte;
    }

    /**
     * @param Abmessung[] $abmessungen
     * @param int $randBreite
     * @return Abmessung
     */
    public function getKartengroesse($abmessungen, $randBreite) {
        $xmin = 0;
        $xmax = 0;
        $ymin = 0;
        $ymax = 0;
        foreach ($abmessungen as $element) {
            if ($element->xMin() < $xmin) {
                $xmin = $element->xMin();
            }
            if ($element->xMax() > $ymax) {
                $xmax = $element->xMax();
            }
            if ($element->yMin() < $ymin) {
                $ymin = $element->yMin();
            }
            if ($element->yMax() > $ymax) {
                $ymax = $element->yMax();
            }
        }
        return SimpleAbmessungFabrik::erzeugeAbmessung(
            ($xmin - $randBreite) . AustauschKonstanten::ABMESSUNG_TRENNER .
            ($ymin - $randBreite) . AustauschKonstanten::ABMESSUNG_TRENNER .
            ($xmax + (2 * $randBreite) - $xmin) . AustauschKonstanten::ABMESSUNG_TRENNER .
            ($ymax + (2 * $randBreite) - $ymin) . AustauschKonstanten::ABMESSUNG_TRENNER
        );
    }
}

