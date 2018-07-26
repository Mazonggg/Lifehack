<?php

namespace Datenbank\Adapter\Select;

use Datenbank\Model\Tabelle;

final class SimpleSelectQueryFactory {
    /**
     * @param Tabelle $tabelle
     * @return SelectQuery
     */
    public static function erzeugeQueryAdapter($tabelle) {
        if (!empty($tabelle->getGroupConcats())) {
            return new GroupConcatLeftJoinQuery($tabelle);
        }
        if (!empty($tabelle->getRelationen())) {
            return new LeftJoinQuery($tabelle);
        }
        return new SelectQuery($tabelle);
    }
}

