<?php

namespace Datenbank\Adapter\Delete;

use Datenbank\Adapter\IQuery;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class SimpleDeleteQueryFabrik {

    /**
     * @param array $anfrageDaten
     * @return IQuery
     */
    public static function erzeugeQueryAdapters($anfrageDaten) {
        return new DeleteQueryAdapter(
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

