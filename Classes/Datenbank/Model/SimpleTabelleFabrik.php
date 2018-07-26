<?php

namespace Datenbank\Model;

use Model\Konstanten\Keyword;

class SimpleTabelleFabrik {
    /**
     * @param string $tabellenName
     * @param string[] $felderNamen
     * @param Relation[] $relationen
     * @param GroupConcat[] $groupConcats
     * @return Tabelle
     */
    public static function erzeugeTabelle($tabellenName, $felderNamen, $relationen = [], $groupConcats = []) {
        return new Tabelle(
            $tabellenName,
            $tabellenName . "." . $tabellenName . Keyword::ID,
            $felderNamen,
            $relationen,
            $groupConcats
        );
    }
}

