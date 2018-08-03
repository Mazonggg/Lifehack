<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter;

use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model\LeereKachel;
use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model\Stadtplan\KartenelementKachel;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\IKartenelement;

class SimpleKachelFabrik {

    /**
     * @param IKartenelement $kartenelement
     * @return array
     */
    public static function erzeugeKacheln($kartenelement) {
        $kacheln = [];
        foreach ($kartenelement->getAbmessungen() as $abmessung) {
            array_push($kacheln, new KartenelementKachel($abmessung, $kartenelement));
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

