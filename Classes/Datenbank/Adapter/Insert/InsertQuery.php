<?php

namespace Datenbank\Adapter\Insert;

use Datenbank\Adapter\Query;
use Model\Konstanten\Keyword;

class InsertQuery extends Query {

    /**
     * @return string
     */
    public function getQuery() {
        return implode("", $this->getInsertQueryParts()) . ";";
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return $this->tabelle;
    }

    /**
     * @return string[]
     */
    protected function getInsertQueryParts() {
        $schluessel = [];
        $werte = [];
        foreach ($this->tabelle->getSpalten(false) as $spalte) {
            array_push($schluessel, $spalte->getSchluessel());
            array_push($werte, $spalte->getWert());
        }
        return [
            Keyword::INSERT,
            Keyword::INTO,
            $this->tabelle->getTabellenName(),
            Keyword::BRACKET_OPEN,
            implode(",", $schluessel),
            Keyword::BRACKET_CLOSE,
            Keyword::VALUES,
            Keyword::BRACKET_OPEN,
            "'",
            implode("','", $werte),
            "'",
            Keyword::BRACKET_CLOSE
        ];
    }
}

