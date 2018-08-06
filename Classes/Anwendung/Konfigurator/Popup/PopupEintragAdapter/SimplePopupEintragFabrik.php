<?php

namespace Anwendung\Konfigurator\Popup\PopupEintragAdapter;

use Anwendung\Konfigurator\Popup\PopupEintragAdapter\Model\Prozess\AufgabePopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintragAdapter\Model\Prozess\ItemPopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintragAdapter\Model\Einrichtung\InstitutPopupEintragAdapter;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Institut;

class SimplePopupEintragFabrik {

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IPopupEintrag
     */
    public static function erzeugePopupEintrag($datenbankEintrag) {
        if ($datenbankEintrag instanceof Aufgabe) {
            $eintragAdapter = new AufgabePopupEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Item) {
            $eintragAdapter = new ItemPopupEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Institut) {
            $eintragAdapter = new InstitutPopupEintragAdapter($datenbankEintrag);
        } else {
            $eintragAdapter = null;
        }
        return $eintragAdapter;
    }
}

