<?php

namespace Anwendung\Konfigurator\Form\FormAdapter;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\AufgabeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\ItemFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\TeilaufgabeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Einrichtung\InstitutFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Einrichtung\NiederlassungFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\AbmessungenFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\GebaeudeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\KartenelementFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\UmweltFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\WohnhausFormAdapter;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\Prozess\Teilaufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\IDatenbankEintrag;
use Model\Einrichtung\Institut;
use Model\Einrichtung\Niederlassung;
use Model\Stadtplan\Gebaeude;
use Model\Stadtplan\IKartenelement;
use Model\Stadtplan\Kartenelement;
use Model\Stadtplan\Umwelt;
use Model\Stadtplan\Wohnhaus;

class SimpleFormFabrik {

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IForm[]
     */
    public static function erzeugeForms($datenbankEintrag) {
        /**
         * @var IForm[]
         */
        $formAdapters = [];
        if ($datenbankEintrag instanceof Aufgabe) {
            array_push($formAdapters, new AufgabeFormAdapter($datenbankEintrag));
        } elseif ($datenbankEintrag instanceof Item) {
            array_push($formAdapters, new ItemFormAdapter($datenbankEintrag));
        } elseif ($datenbankEintrag instanceof Teilaufgabe) {
            array_push($formAdapters, new TeilaufgabeFormAdapter($datenbankEintrag));
        } elseif ($datenbankEintrag instanceof Institut) {
            array_push($formAdapters, new InstitutFormAdapter($datenbankEintrag));
        } elseif ($datenbankEintrag instanceof Kartenelement) {
            $formAdapters = array_merge($formAdapters, SimpleFormFabrik::erzeugeKartenelementForms($datenbankEintrag));
        }
        return $formAdapters;
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IForm[]
     */
    private static function erzeugeKartenelementForms($kartenelement) {
        $formAdapters = [
            new KartenelementFormAdapter(self::pruefeKartenelementArt($kartenelement)),
            new AbmessungenFormAdapter($kartenelement->getAbmessungen())
        ];
        if ($kartenelement instanceof Umwelt) {
            array_push($formAdapters, new UmweltFormAdapter($kartenelement));
        } elseif ($kartenelement instanceof Gebaeude) {
            array_push($formAdapters, new GebaeudeFormAdapter($kartenelement));
            if ($kartenelement instanceof Wohnhaus) {
                array_push($formAdapters, new WohnhausFormAdapter($kartenelement));
            } elseif ($kartenelement instanceof Niederlassung) {
                array_push($formAdapters, new NiederlassungFormAdapter($kartenelement));
            }
        }
        return $formAdapters;
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IKartenelement
     */
    private static function pruefeKartenelementArt($kartenelement) {
        if (!empty($kartenelement->getKartenelementArt()) || !($kartenelement instanceof Kartenelement)) {
            return $kartenelement;
        } else {
            $kartenelementArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
                TabellenName::KARTENELEMENT_ART,
                TabellenName::KARTENELEMENT_ART . Keyword::NAME);
            foreach ($kartenelementArten as $kartenelementArt) {
                if ($kartenelementArt->getWert() == $kartenelement->getTabelle()) {
                    $kartenelement->setKartenelementArt($kartenelementArt);
                }
            }
        }
        return $kartenelement;
    }
}

