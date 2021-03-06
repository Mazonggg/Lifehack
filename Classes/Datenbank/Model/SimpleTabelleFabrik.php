<?php

namespace Datenbank\Model;

use Model\Konstanten\Keyword;
use Model\SimpleWertepaarFabrik;
use Model\Wertepaar;

class SimpleTabelleFabrik {
    /**
     * @param string $tabellenName
     * @param Wertepaar[] $spalten
     * @param Wertepaar $schluessel
     * @param Relation[] $relationen
     * @param GroupConcat[] $groupConcats
     * @return Tabelle
     */
    public static function erzeugeTabelle($tabellenName, $spalten, $schluessel = null, $relationen = [], $groupConcats = []) {
        return new Tabelle(
            $tabellenName,
            $spalten,
            ($schluessel === null ?
                SimpleWertepaarFabrik::erzeugeWertepaar($tabellenName . "." . $tabellenName . Keyword::ID) :
                $schluessel),
            $relationen,
            $groupConcats
        );
    }
}

