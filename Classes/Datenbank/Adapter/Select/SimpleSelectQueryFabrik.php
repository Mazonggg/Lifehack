<?php

namespace Datenbank\Adapter\Select;

use Datenbank\Adapter\IQuery;
use Datenbank\Model\GroupConcat;
use Datenbank\Model\Relation;
use Datenbank\Model\SimpleTabelleFabrik;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

final class SimpleSelectQueryFabrik {

    /**
     * @param string $tabellenName
     * @param Wertepaar[] $spalten
     * @param Wertepaar $schluessel
     * @param Relation[] $relationen
     * @param GroupConcat[] $groupConcats
     * @return IQuery
     */
    public static function erzeugeQueryAdapter($tabellenName, $spalten, $schluessel = null, $relationen = [], $groupConcats = []) {
        $tabelle = SimpleTabelleFabrik::erzeugeTabelle(
            $tabellenName,
            $spalten,
            (empty($schluessel) ? new Wertepaar($tabellenName . '.' . $tabellenName . Keyword::ID) : $schluessel),
            $relationen,
            $groupConcats
        );
        if (!empty($groupConcats)) {
            return new GroupConcatLeftJoinQueryAdapter($tabelle);
        }
        if (!empty($relationen)) {
            return new LeftJoinQueryAdapter($tabelle);
        }
        return new SelectQueryAdapter($tabelle);
    }
}

