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
        if (isset($formDaten[AjaxKeywords::FREMDSCHLUESSEL])) {
            $fremdschluessel = $formDaten[AjaxKeywords::FREMDSCHLUESSEL];
            unset($formDaten[AjaxKeywords::FREMDSCHLUESSEL]);
        } else {
            $fremdschluessel = $tabelle . "." . $tabelle . Keyword::ID;
        }
        unset($formDaten[AjaxKeywords::TABELLE]);
        $id = $formDaten[AjaxKeywords::ID];
        unset($formDaten[AjaxKeywords::ID]);
        return new UpdateQuery(
            $tabelle,
            $formDaten,
            new Wertepaar($fremdschluessel, $id));
    }
}

