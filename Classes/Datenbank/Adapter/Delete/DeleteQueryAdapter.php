<?php

namespace Datenbank\Adapter\Delete;

use Datenbank\Adapter\QueryAdapter;
use Model\Konstanten\Keyword;

class DeleteQueryAdapter extends QueryAdapter {

    /**
     * @return string
     */
    public function getQuery() {
        return implode("", [
            Keyword::DELETE,
            Keyword::FROM,
            $this->tabelle->getTabellenName(),
            Keyword::WHERE,
            $this->tabelle->getPrimaerschluessel()->getSchluessel(),
            Keyword::EQUALS,
            $this->tabelle->getPrimaerschluessel()->getWert(),
            ";"
        ]);
    }
}

