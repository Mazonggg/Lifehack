<?php

include('autoloader.php');

use Datenbank\Adapter\Delete\SimpleDeleteQueryFabrik;
use Datenbank\Adapter\Insert\SimpleInsertQueryFabrik;
use Datenbank\Adapter\IQueryAdapter;
use Datenbank\Adapter\Update\SimpleUpdateQueryFabrik;
use Datenbank\DatenbankHandler;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;

if (isset($_POST)) {
    /**
     * @var IQueryAdapter[]
     */
    #die(json_encode($_POST[AjaxKeywords::DATEN]));
    $queryAdapters = [];
    $hauptForm = json_decode($_POST[AjaxKeywords::DATEN], true);
    $teilForms = [];
    if (isset($hauptForm[AjaxKeywords::TEILFORMS])) {
        $teilForms = $hauptForm[AjaxKeywords::TEILFORMS];
        unset($hauptForm[AjaxKeywords::TEILFORMS]);
    }
    if ($hauptForm[AjaxKeywords::MODUS] == AjaxKeywords::ERSTELLEN) {
        if (DatenbankHandler::Instance()->fuehreQueryAus(erzeugeQueryAdapter($hauptForm))) {
            $queryAdapters = [];
            $tabelle = $hauptForm[AjaxKeywords::TABELLE];
            $id = DatenbankHandler::Instance()->getLetzteInsertId();
            foreach ($teilForms as $teilForm) {
                array_push($queryAdapters, erzeugeQueryAdapter($teilForm, $tabelle, $id));
            }
        }
    } elseif ($hauptForm[AjaxKeywords::MODUS] == AjaxKeywords::AKTUALISIEREN) {
        $queryAdapters = [erzeugeQueryAdapter($hauptForm)];
        $tabelle = $hauptForm[AjaxKeywords::TABELLE];
        $id = $hauptForm[AjaxKeywords::ID];
        foreach ($teilForms as $teilForm) {
            if (isset($teilForm[AjaxKeywords::MODUS]) && $teilForm[AjaxKeywords::MODUS] == AjaxKeywords::AKTUALISIEREN) {
                $teilForm[AjaxKeywords::FREMDSCHLUESSEL] = [
                    $teilForm[AjaxKeywords::TABELLE] . '.' .
                    $teilForm[AjaxKeywords::TABELLE] . '_' .
                    $hauptForm[AjaxKeywords::TABELLE] . Keyword::REF,
                    $id
                ];
            }
            array_push($queryAdapters, erzeugeQueryAdapter($teilForm, $tabelle, $id));
        }
    } elseif ($hauptForm[AjaxKeywords::MODUS] == AjaxKeywords::LOESCHEN) {
        foreach ($teilForms as $teilForm) {
            array_push($queryAdapters, erzeugeQueryAdapter($teilForm));
        }
        array_push($queryAdapters, erzeugeQueryAdapter($hauptForm));
    }
    foreach ($queryAdapters as $queryAdapter) {
        echo "<h1>query:</h1><p>" . $queryAdapter->getQuery() . "</p>";
        if (!DatenbankHandler::Instance()->fuehreQueryAus($queryAdapter)) {
            $fehlerMeldung = DatenbankHandler::Instance()->getFehler();
            die('Die Anfrage konnte nicht ausgeführt werden!: ' . $fehlerMeldung);
        }
    }
}

/**
 * @param array $daten
 * @param string $fremdSchluesselTabellenName
 * @param string $fremdschluesselId
 * @return IQueryAdapter|null
 */
function erzeugeQueryAdapter($daten, $fremdSchluesselTabellenName = "", $fremdschluesselId = null) {
    if (isset($daten[AjaxKeywords::MODUS])) {
        $modus = $daten[AjaxKeywords::MODUS];
        unset($daten[AjaxKeywords::MODUS]);
        $adapter = "";
        if ($modus == AjaxKeywords::ERSTELLEN) {
            if (isset($daten[AjaxKeywords::ID])) {
                unset($daten[AjaxKeywords::ID]);
            }
            $adapter = SimpleInsertQueryFabrik::erzeugeQueryAdapter($daten, $fremdSchluesselTabellenName, $fremdschluesselId);
        } elseif ($modus == AjaxKeywords::LOESCHEN) {
            $adapter = SimpleDeleteQueryFabrik::erzeugeQueryAdapters($daten);
        } elseif ($modus == AjaxKeywords::AKTUALISIEREN) {
            $adapter = SimpleUpdateQueryFabrik::erzeugeQueryAdapters($daten);
        }
        return $adapter;
    }
    return null;
}

