<?php

namespace Anwendung\Konfigurator\Popup\EintragAdapter;

use Anwendung\Konfigurator\Popup\EintragAdapter\Model\Prozess\AufgabeEintragAdapter;
use Anwendung\Konfigurator\Popup\EintragAdapter\Model\Prozess\ItemEintragAdapter;
use Anwendung\Konfigurator\Popup\EintragAdapter\Model\Einrichtung\InstitutEintragAdapter;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Institut;

class SimpleEintragFabrik {

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IEintrag
     */
    public static function erzeugePopupEintrag($datenbankEintrag) {
        if ($datenbankEintrag instanceof Aufgabe) {
            $eintragAdapter = new AufgabeEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Item) {
            $eintragAdapter = new ItemEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Institut) {
            $eintragAdapter = new InstitutEintragAdapter($datenbankEintrag);
        } else {
            $eintragAdapter = null;
        }
        return $eintragAdapter;
    }
}

