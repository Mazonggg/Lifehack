<?php

namespace Datenbank\Adapter\Update;

use Datenbank\Adapter\IQueryAdapter;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class SimpleUpdateQueryFabrik {

    /**
     * @param array $formDaten
     * @return IQueryAdapter
     */
    public static function erzeugeQueryAdapters($formDaten) {
        $tabellenName = $formDaten[AjaxKeywords::TABELLE];
        if (isset($formDaten[AjaxKeywords::ID]) && $formDaten[AjaxKeywords::ID] == '0') {
            $fremdschluessel = new Wertepaar($formDaten[AjaxKeywords::FREMDSCHLUESSEL][0], $formDaten[AjaxKeywords::FREMDSCHLUESSEL][1]);
        } else {
            $fremdschluessel = new Wertepaar($tabellenName . "." . $tabellenName . Keyword::ID, $formDaten[AjaxKeywords::ID]);
        }
        unset($formDaten[AjaxKeywords::FREMDSCHLUESSEL]);
        unset($formDaten[AjaxKeywords::TABELLE]);
        unset($formDaten[AjaxKeywords::ID]);
        $spalten = [];
        foreach ($formDaten as $schluessel => $wert) {
            array_push($spalten, new Wertepaar($schluessel, $wert));
        }
        return new UpdateQuery(SimpleTabelleFabrik::erzeugeTabelle(
            $tabellenName,
            $spalten,
            $fremdschluessel
        ));
    }
}

