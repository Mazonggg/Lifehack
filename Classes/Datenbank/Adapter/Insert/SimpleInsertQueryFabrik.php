<?php

namespace Datenbank\Adapter\Insert;

use Datenbank\Adapter\IQueryAdapter;
use Datenbank\Model\Tabelle;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;

class SimpleInsertQueryFabrik {

    /**
     * @param array $formDaten
     * @param string|null $fremdSchluesselTabellenName
     * @param string|null $fremdschluesselId
     * @return IQueryAdapter
     */
    public static function erzeugeQueryAdapter($formDaten, $fremdSchluesselTabellenName, $fremdschluesselId) {
        $tabelle = $formDaten[AjaxKeywords::TABELLE];
        unset($formDaten[AjaxKeywords::TABELLE]);

        $insertQuery = new InsertQuery(new Tabelle($tabelle));
        if (!empty($fremdSchluesselTabellenName && !empty($fremdschluesselId))) {
            $formDaten[$tabelle . "_" . $fremdSchluesselTabellenName . Keyword::REF] = $fremdschluesselId;
        }
        $insertQuery->setQueryDaten($formDaten);
        return $insertQuery;
    }
}

