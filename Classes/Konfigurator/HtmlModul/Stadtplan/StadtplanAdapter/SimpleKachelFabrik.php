<?php

namespace Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter;

use Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\Model\LeereKachel;
use Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\Model\Stadtplan\KartenelementKachel;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\IKartenelement;

class SimpleKachelFabrik {

    /**
     * @param IKartenelement[] $kartenelemente
     * @return array
     */
    public static function erzeugeKacheln($kartenelemente) {
        $kacheln = [];
        foreach ($kartenelemente as $kartenelement) {
            foreach ($kartenelement->getAbmessungen() as $abmessung) {
                array_push($kacheln, new KartenelementKachel($abmessung, $kartenelement));
            }
        }
        return $kacheln;
    }

    /**
     * @param Abmessung $abmessung
     * @return LeereKachel
     */
    public static function erzeugeLeereKachel($abmessung) {
        return new LeereKachel($abmessung);
    }
}

