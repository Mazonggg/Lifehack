<?php

namespace Anwendung\Konfigurator\Menue\MenueEintragAdapter;

class SimpleMenueEintragFabrik {

    /**
     * @param string $eintragName
     * @return MenueEintragAdapter
     */
    public static function erzeugeMenueEintrag($eintragName) {
        return new MenueEintragAdapter($eintragName);
    }
}

