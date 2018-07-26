<?php

include('autoloader.php');

use Datenbank\DatenbankAbrufHandler;
<<<<<<< HEAD
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
=======
use Konfigurator\HtmlGenerator\Menue\MenueGenerator;
use Model\Enum\AjaxKeywords;
use Model\Enum\Keyword;
use Model\Enum\TabellenName;
use Model\Enum\TabellenSpalten;

if (isset($_GET[AjaxKeywords::MODUS])) {

    $html = "";
    switch ($_GET[AjaxKeywords::MODUS]) {
        case  TabellenName::ITEM . AjaxKeywords::SPEICHERN:
            $html = itemSpeichern();
            break;
        case TabellenName::INSTITUT . AjaxKeywords::SPEICHERN:
            $html = institutSpeichern();
            break;
        case TabellenName::AUFGABE . AjaxKeywords::SPEICHERN:
            $html = aufgabeSpeichern();
            break;
        case TabellenName::TEILAUFGABE . AjaxKeywords::HINZUFUEGEN:
            $html = teilaufgabeSpeichern();
            break;
        default:
            $html = "falscher Modus angegeben: " . $_GET[AjaxKeywords::MODUS];
    }
    echo $html;
}

/**
 * @return string
 */
function itemSpeichern() {
    return json_encode(
        MenueGenerator::Instance()->getForm(
            $_GET[AjaxKeywords::MODUS],
            TabellenName::ITEM, [
                [AjaxKeywords::TYP => AjaxKeywords::TEXT,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenName::ITEM . Keyword::NAME
                        ]
                ], [AjaxKeywords::TYP => AjaxKeywords::NUMBER,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::ITEM_GEWICHT,
                            AjaxKeywords::MAX => 20
                        ]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::ITEM_KONFIGURATION,
                        ]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenName::ITEM_ART . Keyword::REF,
                        AjaxKeywords::LABEL => "Art des Items",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::ITEM_ART,
                            TabellenName::ITEM_ART . "." . TabellenName::ITEM_ART . Keyword::NAME
                        ))
                    ]
                ]
            ]
        )
    );
}

/**
 * @return string
 */
function institutSpeichern() {
    return json_encode(
        MenueGenerator::Instance()->getForm(
            $_GET[AjaxKeywords::MODUS],
            TabellenName::INSTITUT, [
                [AjaxKeywords::TYP => AjaxKeywords::TEXT,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenName::INSTITUT . Keyword::NAME]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXT,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::INSTITUT_BESCHREIBUNG]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenName::INSTITUT_ART . Keyword::REF,
                        AjaxKeywords::LABEL => "Art des Instituts",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::INSTITUT_ART,
                            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
                        ))
                    ]
                ]
            ]
        )
    );
}

/**
 * @return string
 */
function aufgabeSpeichern() {
    return json_encode(
        MenueGenerator::Instance()->getForm(
            $_GET[AjaxKeywords::MODUS],
            TabellenName::AUFGABE, [
                [AjaxKeywords::TYP => AjaxKeywords::TEXT,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::AUFGABE_BEZEICHNUNG]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXT,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE]
                ], [AjaxKeywords::TYP => AjaxKeywords::CHILD_FORM,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenName::TEILAUFGABE . AjaxKeywords::HINZUFUEGEN]
                ]
            ]
        )
    );
}

/**
 * @return string
 */
function teilaufgabeSpeichern() {
    return json_encode(
        MenueGenerator::Instance()->getTeilabschnittForm(
            $_GET[AjaxKeywords::MODUS],
            TabellenName::TEILAUFGABE, [
                [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_MENUE_TEXT]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT]
                ], [AjaxKeywords::TYP => AjaxKeywords::TEXTAREA,
                    AjaxKeywords::INPUT_DATEN =>
                        [AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenName::INSTITUT_ART . Keyword::REF,
                        AjaxKeywords::LABEL => "Art des Instituts",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::INSTITUT_ART,
                            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
                        ))
                    ]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF,
                        AjaxKeywords::LABEL => "Ben&ouml;tigtes Item",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::ITEM,
                            TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME
                        ))
                    ]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF,
                        AjaxKeywords::LABEL => "Erhaltenes Item",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::ITEM,
                            TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME
                        ))
                    ]
                ], [AjaxKeywords::TYP => AjaxKeywords::SELECT,
                    AjaxKeywords::INPUT_DATEN => [
                        AjaxKeywords::NAME => TabellenName::TEILAUFGABE_ART . Keyword::REF,
                        AjaxKeywords::LABEL => "Art der Teilaufgabe",
                        AjaxKeywords::OPTIONEN => idAlsArrayKey(DatenbankAbrufHandler::Instance()->findSpalteZuId(
                            TabellenName::TEILAUFGABE_ART,
                            TabellenName::TEILAUFGABE_ART . "." . TabellenName::TEILAUFGABE_ART . Keyword::NAME
                        ))
                    ]
                ]
            ]
        )
    );
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
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

