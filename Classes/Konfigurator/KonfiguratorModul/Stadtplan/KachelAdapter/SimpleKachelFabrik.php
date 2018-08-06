<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter;

use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model\LeereKachelAdapter;
use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model\Stadtplan\KartenelementKachelAdapter;
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
            array_push($kacheln, new KartenelementKachelAdapter($abmessung, $kartenelement));
        }
        return $kacheln;
    }

    /**
     * @param Abmessung $abmessung
     * @return LeereKachelAdapter
     */
    public static function erzeugeLeereKachel($abmessung) {
        return new LeereKachelAdapter($abmessung);
    }
}

