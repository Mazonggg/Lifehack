<?php

namespace Datenbank\Adapter\Delete;

use Datenbank\Adapter\IQueryAdapter;
use Datenbank\Model\Tabelle;
use Model\Konstanten\AjaxKeywords;

class SimpleDeleteQueryFabrik {

    /**
     * @param array $anfrageDaten
     * @return IQueryAdapter
     */
    public static function erzeugeQueryAdapters($anfrageDaten) {
        return new DeleteQuery(
            new Tabelle(
                $anfrageDaten[AjaxKeywords::TABELLE],
                $anfrageDaten[AjaxKeywords::ID]
            ));
    }
}

