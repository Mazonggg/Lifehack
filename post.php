<?php

include('autoloader.php');

<<<<<<< HEAD
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
                $teilForm[AjaxKeywords::FREMDSCHLUESSEL] =
                    $teilForm[AjaxKeywords::TABELLE] . '.' .
                    $teilForm[AjaxKeywords::TABELLE] . '_' .
                    $hauptForm[AjaxKeywords::TABELLE] . Keyword::REF;
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
=======
use Datenbank\Adapter\Speicher\InsertQueryAdapter;
use Datenbank\Adapter\Speicher\SimpleSpeicherQueryFabrik;
use Datenbank\DatenbankSpeicherHandler;
use Model\Enum\AjaxKeywords;

if (isset($_GET[AjaxKeywords::MODUS]) && $_GET[AjaxKeywords::MODUS] == AjaxKeywords::FORM) {
    fuehreQueriesAus(json_decode($_POST[AjaxKeywords::DATEN], true));
}

function fuehreQueriesAus($daten) {
    $speicherQueryFabrik = SimpleSpeicherQueryFabrik::Instance();
    /**
     * @var InsertQueryAdapter[]
     */
    $queryAdapter = $speicherQueryFabrik->erzeugeQueryAdapters($daten);
    echo "<h1>fuehreQueriesAus</h1>";
    var_export($queryAdapter);
    foreach ($queryAdapter as $adapter) {
        DatenbankSpeicherHandler::Instance()->fuehreQueryAus($adapter);
    }
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
}

