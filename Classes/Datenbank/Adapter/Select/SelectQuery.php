<?php

namespace Datenbank\Adapter\Select;

use Datenbank\Adapter\Query;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class SelectQuery extends Query {

    /**
     * @var Wertepaar
     */
    protected $bedingung;

    /**
     * @param Wertepaar $bedingung
     */
    public function setBedingung($bedingung) {
        $this->bedingung = $bedingung;
    }

    /**
     * @return string
     */
    public function getQuery() {
        return $this->verketteQueryElemente(
            array_merge(
                $this->getSelectQueryParts(),
                (isset($this->bedingung) ? $this->getBedingungQueryParts() : [])
            )
        );
    }

    /**
     * @return string[]
     */
    protected function getSelectQueryParts() {
        return [
            Keyword::SELECT,
            implode(",", $this->tabelle->getSpalten(true)),
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
            $this->bedingung->getSchluessel(),
            Keyword::EQUALS,
            $this->bedingung->getWert()
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

