<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Prozess\AufgabeForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Prozess\ItemForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Prozess\TeilaufgabeForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Einrichtung\InstitutForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Einrichtung\NiederlassungForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan\AbmessungenForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan\GebaeudeForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan\KartenelementForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan\UmweltForm;
use Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan\WohnhausForm;
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
     * @param IDatenbankEintrag[] $datenbankEintraege
     * @return IFormAdapter[]
     */
    public static function erzeugeFormAdapter($datenbankEintraege) {
        /**
         * @var IFormAdapter[]
         */
        $formAdapters = [];
        foreach ($datenbankEintraege as $datenbankEintrag) {
            if ($datenbankEintrag instanceof Aufgabe) {
                array_push($formAdapters, new AufgabeForm($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Item) {
                array_push($formAdapters, new ItemForm($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Teilaufgabe) {
                array_push($formAdapters, new TeilaufgabeForm($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Institut) {
                array_push($formAdapters, new InstitutForm($datenbankEintrag));
            } elseif ($datenbankEintrag instanceof Kartenelement) {
                $formAdapters = array_merge($formAdapters, SimpleFormFabrik::erzeugeKartenelementAdapters($datenbankEintrag));
            }
        }
        return $formAdapters;
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IFormAdapter[]
     */
    private static function erzeugeKartenelementAdapters($kartenelement) {
        $formAdapters = [
            new KartenelementForm(self::pruefeKartenelementArt($kartenelement)),
            new AbmessungenForm($kartenelement->getAbmessungen())
        ];
        if ($kartenelement instanceof Umwelt) {
            array_push($formAdapters, new UmweltForm($kartenelement));
        } elseif ($kartenelement instanceof Gebaeude) {
            array_push($formAdapters, new GebaeudeForm($kartenelement));
            if ($kartenelement instanceof Wohnhaus) {
                array_push($formAdapters, new WohnhausForm($kartenelement));
            } elseif ($kartenelement instanceof Niederlassung) {
                array_push($formAdapters, new NiederlassungForm($kartenelement));
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

