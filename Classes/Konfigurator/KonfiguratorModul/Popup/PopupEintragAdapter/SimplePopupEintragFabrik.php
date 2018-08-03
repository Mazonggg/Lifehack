<?php

namespace Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter;

use Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\Model\Prozess\AufgabePopupEintrag;
use Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\Model\Prozess\ItemPopupEintrag;
use Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\Model\Einrichtung\InstitutPopupEintrag;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Institut;

class SimplePopupEintragFabrik {

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IPopupEintragAdapter
     */
    public static function erzeugePopupEintrag($datenbankEintrag) {
        if ($datenbankEintrag instanceof Aufgabe) {
            $eintragAdapter = new AufgabePopupEintrag($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Item) {
            $eintragAdapter = new ItemPopupEintrag($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Institut) {
            $eintragAdapter = new InstitutPopupEintrag($datenbankEintrag);
        } else {
            $eintragAdapter = null;
        }
        return $eintragAdapter;
    }
}

