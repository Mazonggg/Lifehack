<?php

namespace Datenbank\Adapter\Insert;

use Datenbank\Adapter\IQuery;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\SimpleWertepaarFabrik;

class SimpleInsertQueryFabrik {

    /**
     * @param array $formDaten
     * @param string $fremdSchluesselTabellenName
     * @param string $fremdschluesselId
     * @return IQuery
     */
    public static function erzeugeQueryAdapter($formDaten, $fremdSchluesselTabellenName = '', $fremdschluesselId = '') {
        $tabelle = $formDaten[AjaxKeywords::TABELLE];
        unset($formDaten[AjaxKeywords::TABELLE]);

        if (!empty($fremdSchluesselTabellenName && !empty($fremdschluesselId))) {
            $formDaten[$tabelle . "_" . $fremdSchluesselTabellenName . Keyword::REF] = $fremdschluesselId;
        }

        $spalten = [];
        foreach ($formDaten as $schluessel => $wert) {
            array_push($spalten, SimpleWertepaarFabrik::erzeugeWertepaar($schluessel, $wert));
        }
        return new InsertQueryAdapter(SimpleTabelleFabrik::erzeugeTabelle(
            $tabelle,
            $spalten
        ));
    }
}

