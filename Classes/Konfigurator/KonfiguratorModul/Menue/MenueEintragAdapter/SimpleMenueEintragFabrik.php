<?php

namespace Konfigurator\KonfiguratorModul\Menue\MenueEintragAdapter;

class SimpleMenueEintragFabrik {

    /**
     * @param string[] $eintragNamen
     * @return array
     */
    public static function erzeugeMenueEintraege($eintragNamen) {
        $menueEintraege = [];
        foreach ($eintragNamen as $eintragName) {
            array_push($menueEintraege, new MenueEintrag($eintragName));
        }
        return $menueEintraege;
    }
}

