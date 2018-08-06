<?php

include('autoloader.php');

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormModulAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\SimpleFormFabrik;
use Konfigurator\KonfiguratorModul\Popup\PopupAbrufer;
use Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\SimplePopupEintragFabrik;
use Model\DatenbankEintragParser;
use Model\Fabrik\IDatenbankEintragFabrik;
use Model\IDatenbankEintrag;
use Model\ModelHandler;
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
    } else {
        $eintraege = [];
        if ($tabelle == TabellenName::UMWELT ||
            $tabelle == TabellenName::WOHNHAUS ||
            $tabelle == TabellenName::NIEDERLASSUNG ||
            $tabelle == TabellenName::GEBAEUDE) {
            $abruf = DatenbankAbrufHandler::Instance()->findElementDaten(TabellenName::KARTENELEMENT, $id);
        } else {
            $abruf = DatenbankAbrufHandler::Instance()->findElementDaten($tabelle, $id);
        }
        if ($modus === AjaxKeywords::ERSTELLEN) {
            $eintragDaten = [];
        } else {
            $eintragDaten = empty($abruf) ?: $abruf;
        }
        switch ($tabelle) {
            case TabellenName::AUFGABE:
                /**
                 * @var Aufgabe[] $aufgaben
                 */
                $aufgaben = getEintraege($eintragDaten, AufgabeFabrik::Instance());
                $eintraege = [];
                foreach ($aufgaben as $aufgabe) {
                    array_push($eintraege, $aufgabe);
                    foreach ($aufgabe->getTeilaufgaben() as $teilaufgabe) {
                        array_push($eintraege, $teilaufgabe);
                    }
                }
                break;
            case TabellenName::ITEM:
                $eintraege = getEintraege($eintragDaten, ItemFabrik::Instance());
                break;
            case TabellenName::TEILAUFGABE:
                $eintraege = getEintraege($eintragDaten, TeilaufgabeFabrik::Instance());
                break;
            case TabellenName::INSTITUT:
                $eintraege = getEintraege($eintragDaten, InstitutFabrik::Instance());
                break;
            case TabellenName::UMWELT:
                $eintraege = getEintraege($eintragDaten, UmweltFabrik::Instance());
                break;
            case TabellenName::WOHNHAUS:
                $eintraege = getEintraege($eintragDaten, WohnhausFabrik::Instance());
                break;
            case TabellenName::NIEDERLASSUNG:
                $eintraege = getEintraege($eintragDaten, NiederlassungFabrik::Instance());
                break;
            case TabellenName::GEBAEUDE:
                $eintraege = getEintraege($eintragDaten, GebaeudeFabrik::Instance());
                break;
            default:
                die('Fehlerhafte Anfrage: ' . var_export($_GET));
        }
        $formAdapters = [];
        foreach ($eintraege as $eintrag) {
            $formAdapters = array_merge($formAdapters, SimpleFormFabrik::erzeugeForms($eintrag));
        }
        $html = FormModulAdapter::Instance()->getModulHtml($modus, $formAdapters);
    }
    echo json_encode($html);
} else {
    echo "<h1>Kein Modus angegeben!<h1>";
}

/**
 * @param string $tabelle
 * @return string
 */
function elementOeffnen($tabelle) {
    switch ($tabelle) {
        case TabellenName::ITEM:
            $daten = ModelHandler::Instance()->getItemDaten();
            break;
        case TabellenName::INSTITUT:
            $daten = ModelHandler::Instance()->getInstitutDaten();
            break;
        default:
            $daten = ModelHandler::Instance()->getAufgabeDaten();
            break;
    }
    $listenEintraege = [];
    foreach ($daten as $eintrag) {
        array_push($listenEintraege, SimplePopupEintragFabrik::erzeugePopupEintrag($eintrag));
    }
    return PopupAbrufer::Instance()->getPopupBlockDaten($tabelle, $listenEintraege);
}

/**
 * @param array $eintragDaten
 * @param IDatenbankEintragFabrik $fabrik
 * @return IDatenbankEintrag[]
 */
function getEintraege($eintragDaten, $fabrik) {
    if (empty($eintragDaten)) {
        return [$fabrik->erzeugeEintragObjekt()];
    } else {
        return DatenbankEintragParser::Instance()->arrayZuDatenbankEintraegen($eintragDaten, $fabrik);
    }
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

