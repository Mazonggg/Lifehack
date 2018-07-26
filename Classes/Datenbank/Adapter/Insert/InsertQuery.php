<?php

namespace Datenbank\Adapter\Insert;

use Datenbank\Adapter\Query;
use Model\Konstanten\Keyword;

class InsertQuery extends Query {

    /**
     * @var array
     */
    private $queryDaten = [];

    /**
     * @param array $queryDaten
     */
    public function setQueryDaten($queryDaten) {
        $this->queryDaten = $queryDaten;
    }

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
        return [
            Keyword::INSERT,
            Keyword::INTO,
            $this->tabelle->getTabellenName(),
            Keyword::BRACKET_OPEN,
            implode(",", array_keys($this->queryDaten)),
            Keyword::BRACKET_CLOSE,
            Keyword::VALUES,
            Keyword::BRACKET_OPEN,
            "'",
            implode("','", array_values($this->queryDaten)),
            "'",
            Keyword::BRACKET_CLOSE
        ];
    }
}

