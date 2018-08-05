<?php

namespace Datenbank\Adapter\Delete;

use Datenbank\Adapter\IQueryAdapter;
use Datenbank\Model\SimpleTabelleFabrik;
use Datenbank\Model\Tabelle;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class SimpleDeleteQueryFabrik {

    /**
     * @param array $anfrageDaten
     * @return IQueryAdapter
     */
    public static function erzeugeQueryAdapters($anfrageDaten) {
        return new DeleteQuery(
            SimpleTabelleFabrik::erzeugeTabelle(
                $anfrageDaten[AjaxKeywords::TABELLE],
                [],
                new Wertepaar(
                    $anfrageDaten[AjaxKeywords::TABELLE] . '.' . $anfrageDaten[AjaxKeywords::TABELLE] . Keyword::ID,
                    $anfrageDaten[AjaxKeywords::ID]
                )
            ));
    }
}

