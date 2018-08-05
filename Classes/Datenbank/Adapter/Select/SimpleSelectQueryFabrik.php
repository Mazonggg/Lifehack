<?php

namespace Datenbank\Adapter\Select;

use Datenbank\Adapter\IQueryAdapter;
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
     * @return IQueryAdapter
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
            return new GroupConcatLeftJoinQuery($tabelle);
        }
        if (!empty($relationen)) {
            return new LeftJoinQuery($tabelle);
        }
        return new SelectQuery($tabelle);
    }
}

