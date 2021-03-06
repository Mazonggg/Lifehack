<?php

namespace Datenbank;

use Datenbank\Adapter\Select\SimpleSelectQueryFabrik;
use Datenbank\Model\SimpleGroupConcatFabrik;
use Datenbank\Model\SimpleRelationFabrik;
use Model\Konstanten\Keyword;
use Model\Konstanten\Serialisierer;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\SimpleWertepaarFabrik;
use Model\Wertepaar;
use mysqli;

final class DatenbankAbrufHandler extends DatenbankHandler {
    /**
     * @var DatenbankAbrufHandler|null
     */
    protected static $_instance = null;

    /**
     * @return DatenbankAbrufHandler
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->db = new mysqli('127.0.0.1', 'dgsql18', '!2e=WyMpl3', 'dgsql18');
        }
        return self::$_instance;
    }

    /**
     * @param string $tabelle
     * @param string $id
     * @return array
     */
    public function findElementDaten($tabelle, $id = null) {
        $daten = [];
        if ($tabelle === TabellenName::KARTENELEMENT) {
            $daten = $this->findKartenelementDaten($id);
        } else if ($tabelle === TabellenName::INSTITUT) {
            $daten = $this->findInstitutDaten($id);
        } else if ($tabelle === TabellenName::AUFGABE) {
            $daten = $this->findAufgabeDaten($id);
        } else if ($tabelle === TabellenName::ITEM) {
            $daten = $this->findItemDaten($id);
        }
        return $daten;
    }

    /**
     * @param string $kartenelementId
     * @return array
     */
    private function findKartenelementDaten($kartenelementId = null) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter(
            TabellenName::KARTENELEMENT, [
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT_ART . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::KARTENELEMENT_ART . "." . TabellenName::KARTENELEMENT_ART . Keyword::NAME),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::KARTENELEMENT_AUSSEHEN . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::URL),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEZEICHUNG),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEGEHBAR),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEGEHBAR),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::GEBAEUDE . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INTERIEUR_AUSSEHEN . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::URL),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::NIEDERLASSUNG . "." . TabellenName::NIEDERLASSUNG . '_' . TabellenName::INSTITUT . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::WOHNHAUS . "." . TabellenSpalten::WOHNHAUS_WOHNEINHEITEN)
        ], (empty($kartenelementId) ? null : SimpleWertepaarFabrik::erzeugeWertepaar(
            TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT . Keyword::ID,
            $kartenelementId)
        ), [
            SimpleRelationFabrik::erzeugeRelation(TabellenName::ABMESSUNG,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT),
                Serialisierer::alsFremdschluessel(TabellenName::ABMESSUNG, TabellenName::ABMESSUNG . "_" . TabellenName::KARTENELEMENT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::UMWELT,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT),
                Serialisierer::alsFremdschluessel(TabellenName::UMWELT, TabellenName::UMWELT . "_" . TabellenName::KARTENELEMENT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::GEBAEUDE,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT),
                Serialisierer::alsFremdschluessel(TabellenName::GEBAEUDE, TabellenName::GEBAEUDE . "_" . TabellenName::KARTENELEMENT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::WOHNHAUS,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT),
                Serialisierer::alsFremdschluessel(TabellenName::WOHNHAUS, TabellenName::WOHNHAUS . "_" . TabellenName::KARTENELEMENT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::NIEDERLASSUNG,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT),
                Serialisierer::alsFremdschluessel(TabellenName::NIEDERLASSUNG, TabellenName::NIEDERLASSUNG . "_" . TabellenName::KARTENELEMENT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::KARTENELEMENT_ART,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT_ART),
                Serialisierer::alsFremdschluessel(TabellenName::KARTENELEMENT, TabellenName::KARTENELEMENT_ART)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::INSTITUT,
                Serialisierer::alsPrimaerschluessel(TabellenName::INSTITUT),
                Serialisierer::alsFremdschluessel(TabellenName::NIEDERLASSUNG, TabellenName::NIEDERLASSUNG . "_" . TabellenName::INSTITUT)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::KARTENELEMENT_AUSSEHEN,
                Serialisierer::alsPrimaerschluessel(TabellenName::KARTENELEMENT_AUSSEHEN),
                Serialisierer::alsFremdschluessel(TabellenName::KARTENELEMENT, TabellenName::KARTENELEMENT_AUSSEHEN)),
            SimpleRelationFabrik::erzeugeRelation(TabellenName::INTERIEUR_AUSSEHEN,
                Serialisierer::alsPrimaerschluessel(TabellenName::INTERIEUR_AUSSEHEN),
                Serialisierer::alsFremdschluessel(TabellenName::GEBAEUDE, TabellenName::INTERIEUR_AUSSEHEN)),
        ], [
                SimpleGroupConcatFabrik::erzeugeGroupConcat(TabellenName::ABMESSUNG . "." . TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG, TabellenName::ABMESSUNG)
            ]
        );
        return $this->getResult($adapter);
    }

    /**
     * @param string $institutId
     * @return array
     */
    private function findInstitutDaten($institutId = null) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter(
            TabellenName::INSTITUT, [
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT . "." . TabellenSpalten::INSTITUT_BESCHREIBUNG),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT . "." . TabellenName::INSTITUT_ART . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME)
        ], (empty($institutId) ? null : SimpleWertepaarFabrik::erzeugeWertepaar(
            TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::ID,
            $institutId)
        ), [
                SimpleRelationFabrik::erzeugeRelation(TabellenName::INSTITUT_ART,
                    Serialisierer::alsPrimaerschluessel(TabellenName::INSTITUT_ART),
                    Serialisierer::alsFremdschluessel(TabellenName::INSTITUT, TabellenName::INSTITUT_ART)),

            ]
        );
        return $this->getResult($adapter);
    }

    /**
     * @param string $aufgabeId
     * @return array
     */
    private function findAufgabeDaten($aufgabeId = null) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter(
            TabellenName::AUFGABE, [
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenSpalten::AUFGABE_BEZEICHNUNG),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE)
        ], (empty($aufgabeId) ? null : SimpleWertepaarFabrik::erzeugeWertepaar(
            TabellenName::AUFGABE . "." . TabellenName::AUFGABE . Keyword::ID,
            $aufgabeId))
        );

        $aufgabenDaten = $this->getResult($adapter);

        $aufgabenNeu = [];
        if (!empty($aufgabenDaten)) {
            foreach ($aufgabenDaten as $aufgabe) {
                $aufgabe[TabellenName::TEILAUFGABE] = $this->findTeilaufgabenDaten($aufgabe[TabellenName::AUFGABE . Keyword::ID]);
                array_push($aufgabenNeu, $aufgabe);
            }
        }
        return $aufgabenNeu;
    }

    /**
     * @param int $aufgabeId
     * @return array
     */
    private function findTeilaufgabenDaten($aufgabeId) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter(
            TabellenName::TEILAUFGABE, [
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenName::TEILAUFGABE . Keyword::ID),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_MENUE_TEXT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenName::TEILAUFGABE_ART . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE_ART . "." . TabellenName::TEILAUFGABE_ART . Keyword::NAME),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::TEILAUFGABE . "." . TabellenName::INSTITUT_ART . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME)
        ], SimpleWertepaarFabrik::erzeugeWertepaar(
            TabellenName::TEILAUFGABE . "." . TabellenName::TEILAUFGABE . "_" . TabellenName::AUFGABE . Keyword::REF,
            $aufgabeId
        ), [
                SimpleRelationFabrik::erzeugeRelation(TabellenName::INSTITUT_ART,
                    Serialisierer::alsPrimaerschluessel(TabellenName::INSTITUT_ART),
                    Serialisierer::alsFremdschluessel(TabellenName::TEILAUFGABE, TabellenName::INSTITUT_ART)),
                SimpleRelationFabrik::erzeugeRelation(TabellenName::TEILAUFGABE_ART,
                    Serialisierer::alsPrimaerschluessel(TabellenName::TEILAUFGABE_ART),
                    Serialisierer::alsFremdschluessel(TabellenName::TEILAUFGABE, TabellenName::TEILAUFGABE_ART))
            ]
        );
        return $this->getResult($adapter);
    }

    /**
     * @param int|null $itemId
     * @return array
     */
    private function findItemDaten($itemId = null) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter(
            TabellenName::ITEM, [
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::ITEM . "." . TabellenSpalten::ITEM_GEWICHT),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::ITEM . "." . TabellenSpalten::ITEM_KONFIGURATION),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::ITEM . "." . TabellenName::ITEM_ART . Keyword::REF),
            SimpleWertepaarFabrik::erzeugeWertepaar(TabellenName::ITEM_ART . "." . TabellenName::ITEM_ART . Keyword::NAME)
        ], (empty($itemId) ? null : SimpleWertepaarFabrik::erzeugeWertepaar(
            TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::ID,
            $itemId)
        ),
            [
                SimpleRelationFabrik::erzeugeRelation(TabellenName::ITEM_ART,
                    Serialisierer::alsPrimaerschluessel(TabellenName::ITEM_ART),
                    Serialisierer::alsFremdschluessel(TabellenName::ITEM, TabellenName::ITEM_ART)),

            ]
        );
        return $this->getResult($adapter);
    }

    /**
     * @param string $tabellenName
     * @param string $spaltenName
     * @return Wertepaar[]|bool
     */
    public function findSpalteZuId($tabellenName, $spaltenName) {
        $adapter = SimpleSelectQueryFabrik::erzeugeQueryAdapter($tabellenName, [SimpleWertepaarFabrik::erzeugeWertepaar($spaltenName)]);
        return $this->arrayZuWertepaaren($this->getResult($adapter));
    }

    /**
     * @param array]bool $daten
     * @return Wertepaar[]
     */
    private function arrayZuWertepaaren($daten) {
        /**
         * @var Wertepaar[]
         */
        $wertepaare = [];
        if (is_array($daten)) {
            foreach ($daten as $eintrag) {
                array_push($wertepaare, SimpleWertepaarFabrik::erzeugeWertepaar(array_values($eintrag)[0], array_values($eintrag)[1]));
            }
            return $wertepaare;
        } else {
            return $daten;
        }
    }
}

