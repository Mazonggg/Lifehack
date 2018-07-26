<?php

namespace Datenbank;

use Datenbank\Adapter\Select\SimpleSelectQueryFactory;
use Datenbank\Model\SimpleGroupConcatFabrik;
use Datenbank\Model\SimpleQueryWertepaarFabrik;
use Datenbank\Model\SimpleRelationFabrik;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\Keyword;
use Model\Konstanten\Serialisierer;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
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
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle(TabellenName::KARTENELEMENT, [
                TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT_ART . Keyword::REF,
                TabellenName::KARTENELEMENT_ART . "." . TabellenName::KARTENELEMENT_ART . Keyword::NAME,
                TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::REF,
                TabellenName::KARTENELEMENT_AUSSEHEN . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::URL,
                TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEZEICHUNG,
                TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEGEHBAR,
                TabellenName::UMWELT . "." . TabellenSpalten::UMWELT_BEGEHBAR,
                TabellenName::GEBAEUDE . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::REF,
                TabellenName::INTERIEUR_AUSSEHEN . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::URL,
                TabellenName::NIEDERLASSUNG . "." . TabellenName::NIEDERLASSUNG . '_' . TabellenName::INSTITUT . Keyword::REF,
                TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME,
                TabellenName::WOHNHAUS . "." . TabellenSpalten::WOHNHAUS_WOHNEINHEITEN
            ], [
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
            ], [SimpleGroupConcatFabrik::erzeugeGroupConcat(TabellenName::ABMESSUNG . "." . TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG, TabellenName::ABMESSUNG)]
            ));
        if (isset($kartenelementId)) {
            $adapter->setBedingung(
                SimpleQueryWertepaarFabrik::erzeugeQueryWertePaar(
                    TabellenName::KARTENELEMENT . "." . TabellenName::KARTENELEMENT . Keyword::ID,
                    $kartenelementId
                )
            );
        }
        return $this->getResult($adapter);
    }

    /**
     * @param string $institutId
     * @return array
     */
    private function findInstitutDaten($institutId = null) {
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle(TabellenName::INSTITUT,
                [
                    TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME,
                    TabellenName::INSTITUT . "." . TabellenSpalten::INSTITUT_BESCHREIBUNG,
                    TabellenName::INSTITUT . "." . TabellenName::INSTITUT_ART . Keyword::REF,
                    TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
                ], [
                    SimpleRelationFabrik::erzeugeRelation(TabellenName::INSTITUT_ART,
                        Serialisierer::alsPrimaerschluessel(TabellenName::INSTITUT_ART),
                        Serialisierer::alsFremdschluessel(TabellenName::INSTITUT, TabellenName::INSTITUT_ART)),

                ]
            ));
        if (isset($institutId)) {
            $adapter->setBedingung(
                SimpleQueryWertepaarFabrik::erzeugeQueryWertePaar(
                    TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::ID,
                    $institutId
                )
            );
        }
        return $this->getResult($adapter);
    }

    /**
     * @param string $aufgabeId
     * @return array
     */
    private function findAufgabeDaten($aufgabeId = null) {
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle(TabellenName::AUFGABE,
                [
                    TabellenSpalten::AUFGABE_BEZEICHNUNG,
                    TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE
                ]
            ));
        if (isset($aufgabeId)) {
            $adapter->setBedingung(
                SimpleQueryWertepaarFabrik::erzeugeQueryWertePaar(
                    TabellenName::AUFGABE . "." . TabellenName::AUFGABE . Keyword::ID,
                    $aufgabeId
                )
            );
        }
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
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle(TabellenName::TEILAUFGABE,
                [
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_MENUE_TEXT,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF,
                    TabellenName::TEILAUFGABE . "." . TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF,
                    TabellenName::TEILAUFGABE . "." . TabellenName::TEILAUFGABE_ART . Keyword::REF,
                    TabellenName::TEILAUFGABE_ART . "." . TabellenName::TEILAUFGABE_ART . Keyword::NAME,
                    TabellenName::TEILAUFGABE . "." . TabellenName::INSTITUT_ART . Keyword::REF,
                    TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
                ], [
                    SimpleRelationFabrik::erzeugeRelation(TabellenName::INSTITUT_ART,
                        Serialisierer::alsPrimaerschluessel(TabellenName::INSTITUT_ART),
                        Serialisierer::alsFremdschluessel(TabellenName::TEILAUFGABE, TabellenName::INSTITUT_ART)),
                    SimpleRelationFabrik::erzeugeRelation(TabellenName::TEILAUFGABE_ART,
                        Serialisierer::alsPrimaerschluessel(TabellenName::TEILAUFGABE_ART),
                        Serialisierer::alsFremdschluessel(TabellenName::TEILAUFGABE, TabellenName::TEILAUFGABE_ART))
                ]
            ));
        $adapter->setBedingung(
            SimpleQueryWertepaarFabrik::erzeugeQueryWertePaar(
                TabellenName::TEILAUFGABE . "." . TabellenName::TEILAUFGABE . "_" . TabellenName::AUFGABE . Keyword::REF,
                $aufgabeId
            )
        );
        return $this->getResult($adapter);
    }

    /**
     * @param int|null $itemId
     * @return array
     */
    private function findItemDaten($itemId = null) {
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle(TabellenName::ITEM,
                [
                    TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME,
                    TabellenName::ITEM . "." . TabellenSpalten::ITEM_GEWICHT,
                    TabellenName::ITEM . "." . TabellenSpalten::ITEM_KONFIGURATION,
                    TabellenName::ITEM . "." . TabellenName::ITEM_ART . Keyword::REF,
                    TabellenName::ITEM_ART . "." . TabellenName::ITEM_ART . Keyword::NAME
                ], [
                    SimpleRelationFabrik::erzeugeRelation(TabellenName::ITEM_ART,
                        Serialisierer::alsPrimaerschluessel(TabellenName::ITEM_ART),
                        Serialisierer::alsFremdschluessel(TabellenName::ITEM, TabellenName::ITEM_ART)),

                ]
            ));
        if (isset($itemId)) {
            $adapter->setBedingung(
                SimpleQueryWertepaarFabrik::erzeugeQueryWertePaar(
                    TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::ID,
                    $itemId
                )
            );
        }
        return $this->getResult($adapter);
    }

    /**
     * @param string $tabellenName
     * @param string $spaltenName
     * @return Wertepaar[]|bool
     */
    public function findSpalteZuId($tabellenName, $spaltenName) {
        $adapter = SimpleSelectQueryFactory::erzeugeQueryAdapter(
            SimpleTabelleFabrik::erzeugeTabelle($tabellenName, [$spaltenName]));
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
                array_push($wertepaare, new Wertepaar(array_values($eintrag)[0], array_values($eintrag)[1]));
            }
            return $wertepaare;
        } else {
            return $daten;
        }
    }
}

