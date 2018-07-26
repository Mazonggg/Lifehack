<?php

include('autoloader.php');

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\HtmlModul\Form\FormModul;
use Konfigurator\HtmlModul\Form\FormAdapter\SimpleFormFabrik;
use Konfigurator\HtmlModul\ModulAbrufer;
use Konfigurator\HtmlModul\Popup\PopupAbrufer;
use Konfigurator\HtmlModul\Popup\PopupEintragAdapter\SimplePopupEintragFabrik;
use Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\SimpleKachelFabrik;
use Konfigurator\HtmlModul\Stadtplan\StadtplanModul;
use Model\Prozess\Aufgabe;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Fabrik\Aufgabe\AufgabeFabrik;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Fabrik\Aufgabe\TeilaufgabeFabrik;
use Model\Fabrik\Einrichtung\InstitutFabrik;
use Model\Fabrik\Einrichtung\NiederlassungFabrik;
use Model\Fabrik\Stadtplan\GebaeudeFabrik;
use Model\Fabrik\Stadtplan\UmweltFabrik;
use Model\Fabrik\Stadtplan\WohnhausFabrik;

if (isset($_GET[AjaxKeywords::MODUS])) {
    $tabelle = (isset($_GET[AjaxKeywords::TABELLE]) ? $_GET[AjaxKeywords::TABELLE] : "");
    $modus = (isset($_GET[AjaxKeywords::MODUS]) ? $_GET[AjaxKeywords::MODUS] : "");
    $id = (isset($_GET[AjaxKeywords::ID]) ? $_GET[AjaxKeywords::ID] : "");

    $html = "";
    if ($modus === AjaxKeywords::BEARBEITEN) {
        $html = elementOeffnen($tabelle);
    } elseif ($modus === AjaxKeywords::STADTPLAN) {
        $html = StadtplanModul::Instance(
            SimpleKachelFabrik::erzeugeKacheln(
                ModulAbrufer::Instance()->getKartenelementDaten()
            ))->getModulHtml();
    } else {
        $eintraege = [];
        switch ($tabelle) {
            case TabellenName::AUFGABE:
                $aufgabenDaten = DatenbankAbrufHandler::Instance()->findElementDaten($tabelle, $id);
                /**
                 * @var Aufgabe $aufgabe
                 */
                $aufgabe = AufgabeFabrik::Instance()->erzeugeEintragObjekt(
                    empty($aufgabenDaten) ?: $aufgabenDaten[0]
                );
                $eintraege = [$aufgabe];
                foreach ($aufgabe->getTeilaufgaben() as $teilaufgabe) {
                    array_push($eintraege, $teilaufgabe);
                }
                break;
            case TabellenName::ITEM:
                $eintraege = [
                    ItemFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten($tabelle, $id)[0]
                    )];
                break;
            case TabellenName::TEILAUFGABE:
                $eintraege = [
                    TeilaufgabeFabrik::Instance()->erzeugeEintragObjekt()
                ];
                break;
            case TabellenName::INSTITUT:
                $eintraege = [
                    InstitutFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten($tabelle, $id)[0]
                    )];
                break;
            case TabellenName::UMWELT:
                $eintraege = [
                    UmweltFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten(TabellenName::KARTENELEMENT, $id)[0]
                    )];
                break;
            case TabellenName::WOHNHAUS:
                $eintraege = [
                    WohnhausFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten(TabellenName::KARTENELEMENT, $id)[0]
                    )];
                break;
            case TabellenName::NIEDERLASSUNG:
                $eintraege = [
                    NiederlassungFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten(TabellenName::KARTENELEMENT, $id)[0]
                    )];
                break;
            case TabellenName::GEBAEUDE:
                $eintraege = [
                    GebaeudeFabrik::Instance()->erzeugeEintragObjekt(
                        DatenbankAbrufHandler::Instance()->findElementDaten(TabellenName::KARTENELEMENT, $id)[0]
                    )];
                break;
            default:
                die('Fehlerhafte Anfrage: ' . var_export($_GET));
        }
        $formAdapters = SimpleFormFabrik::erzeugeFormAdapter($eintraege);
        $html = FormModul::Instance()->getModulHtml($modus, $formAdapters);
    }
    echo json_encode($html);
}

/**
 * @param string $tabelle
 * @return string
 */
function elementOeffnen($tabelle) {
    switch ($tabelle) {
        case TabellenName::ITEM:
            $daten = ModulAbrufer::Instance()->getItemDaten();
            break;
        case TabellenName::INSTITUT:
            $daten = ModulAbrufer::Instance()->getInstitutDaten();
            break;
        default:
            $daten = ModulAbrufer::Instance()->getAufgabeDaten();
            break;
    }
    $listenEintraege = SimplePopupEintragFabrik::erzeugePopupEintraege($daten);
    return PopupAbrufer::Instance()->getPopupBlockDaten($tabelle, $listenEintraege);
}

/**
 * @param array $array
 * @return array
 */
function idAlsArrayKey($array) {
    $keyArray = [];
    foreach ($array as $eintrag) {
        $id = "";
        $wert = "";
        foreach ($eintrag as $key => $spalte) {
            if (substr($key, -strlen(Keyword::ID)) == Keyword::ID) {
                $id = $spalte;
            } else {
                $wert = $spalte;
            }
        }
        $keyArray[$id] = $wert;
    }
    return $keyArray;
}

