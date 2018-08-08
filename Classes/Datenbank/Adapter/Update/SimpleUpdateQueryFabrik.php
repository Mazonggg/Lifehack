<?php

namespace Datenbank\Adapter\Update;

use Datenbank\Adapter\IQuery;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\SimpleWertepaarFabrik;

class SimpleUpdateQueryFabrik {

    /**
     * @param array $formDaten
     * @return IQuery
     */
    public static function erzeugeQueryAdapters($formDaten) {
        $tabellenName = $formDaten[AjaxKeywords::TABELLE];
        if (isset($formDaten[AjaxKeywords::ID]) && $formDaten[AjaxKeywords::ID] == '0') {
            $fremdschluessel = SimpleWertepaarFabrik::erzeugeWertepaar($formDaten[AjaxKeywords::FREMDSCHLUESSEL][0], $formDaten[AjaxKeywords::FREMDSCHLUESSEL][1]);
        } else {
            $fremdschluessel = SimpleWertepaarFabrik::erzeugeWertepaar($tabellenName . "." . $tabellenName . Keyword::ID, $formDaten[AjaxKeywords::ID]);
        }
        unset($formDaten[AjaxKeywords::FREMDSCHLUESSEL]);
        unset($formDaten[AjaxKeywords::TABELLE]);
        unset($formDaten[AjaxKeywords::ID]);
        $spalten = [];
        foreach ($formDaten as $schluessel => $wert) {
            array_push($spalten, SimpleWertepaarFabrik::erzeugeWertepaar($schluessel, $wert));
        }
        return new UpdateQueryAdapter(SimpleTabelleFabrik::erzeugeTabelle(
            $tabellenName,
            $spalten,
            $fremdschluessel
        ));
    }
}

