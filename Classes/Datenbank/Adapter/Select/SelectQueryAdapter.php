<?php

namespace Datenbank\Adapter\Select;

use Datenbank\Adapter\QueryAdapter;
use Model\Konstanten\Keyword;

class SelectQueryAdapter extends QueryAdapter {

    /**
     * @return string
     */
    public function getQuery() {
        return $this->verketteQueryElemente(
            array_merge(
                $this->getSelectQueryParts(),
                (!empty($this->tabelle->getPrimaerschluessel()->getWert()) ? $this->getBedingungQueryParts() : [])
            )
        );
    }

    /**
     * @return string[]
     */
    protected function getSelectQueryParts() {
        $spalten = [];
        foreach ($this->tabelle->getSpalten(true) as $spalte) {
            array_push($spalten, $spalte->getSchluessel());
        }
        return [
            Keyword::SELECT,
            implode(",", $spalten),
            Keyword::FROM,
            $this->tabelle->getTabellenName()
        ];
    }

    /**
     * @return string[]
     */
    protected function getBedingungQueryParts() {
        return [
            Keyword::WHERE,
            $this->tabelle->getPrimaerschluessel()->getSchluessel(),
            Keyword::EQUALS,
            $this->tabelle->getPrimaerschluessel()->getWert()
        ];
    }

    /**
     * @param string[] $queryElemente
     * @return string
     */
    protected function verketteQueryElemente($queryElemente) {
        return implode("", $queryElemente) . ";";
    }
}

