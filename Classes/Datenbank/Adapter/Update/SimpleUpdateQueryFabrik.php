<?php

namespace Datenbank\Adapter\Update;

use Datenbank\Adapter\IQueryAdapter;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class SimpleUpdateQueryFabrik {

    /**
     * @param array $formDaten
     * @return IQueryAdapter
     */
    public static function erzeugeQueryAdapters($formDaten) {
        $tabelle = $formDaten[AjaxKeywords::TABELLE];
        if (isset($formDaten[AjaxKeywords::ID]) && $formDaten[AjaxKeywords::ID] == '0') {
            $fremdschluessel = $formDaten[AjaxKeywords::FREMDSCHLUESSEL][0];
            $id = $formDaten[AjaxKeywords::FREMDSCHLUESSEL][1];
        } else {
            $fremdschluessel = $tabelle . "." . $tabelle . Keyword::ID;
            $id = $formDaten[AjaxKeywords::ID];
        }
        unset($formDaten[AjaxKeywords::FREMDSCHLUESSEL]);
        unset($formDaten[AjaxKeywords::TABELLE]);
        unset($formDaten[AjaxKeywords::ID]);
        return new UpdateQuery(
            $tabelle,
            $formDaten,
            new Wertepaar($fremdschluessel, $id));
    }
}

