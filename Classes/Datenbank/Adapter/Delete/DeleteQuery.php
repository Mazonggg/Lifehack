<?php

namespace Datenbank\Adapter\Delete;

use Datenbank\Adapter\Query;
use Model\Konstanten\Keyword;

class DeleteQuery extends Query {

    /**
     * @return string
     */
    public function getQuery() {
        return implode("", [
            Keyword::DELETE,
            Keyword::FROM,
            $this->tabelle->getTabellenName(),
            Keyword::WHERE,
            $this->tabelle->getTabellenName() . "." . $this->tabelle->getTabellenName() . Keyword::ID,
            Keyword::EQUALS,
            $this->tabelle->getPrimaerschluessel(),
            ";"
        ]);
    }
}

