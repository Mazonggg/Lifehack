<?php

namespace Konfigurator\KonfiguratorModul\Menue\MenueEintragAdapter;

class SimpleMenueEintragFabrik {

    /**
     * @param string $eintragName
     * @return MenueEintrag
     */
    public static function erzeugeMenueEintrag($eintragName) {
        return new MenueEintrag($eintragName);
    }
}

