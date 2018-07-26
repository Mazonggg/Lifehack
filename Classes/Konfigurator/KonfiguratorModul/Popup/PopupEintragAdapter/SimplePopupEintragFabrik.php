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
     * @param IDatenbankEintrag[] $datenbankEintraege
     * @return IPopupEintragAdapter[]
     */
    public static function erzeugePopupEintraege($datenbankEintraege) {
        $eintragAdapters = [];
        foreach ($datenbankEintraege as $datenbankEintrag) {
            if ($datenbankEintrag instanceof Aufgabe) {
                array_push($eintragAdapters, new AufgabePopupEintrag($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Item) {
                array_push($eintragAdapters, new ItemPopupEintrag($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Institut) {
                array_push($eintragAdapters, new InstitutPopupEintrag($datenbankEintrag));
            }
        }
        return $eintragAdapters;
    }
}

