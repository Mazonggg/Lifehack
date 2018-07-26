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
     * @param int|bool $letzteId
     * @return string
     */
    public function getQuery($letzteId = false) {
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
<<<<<<< HEAD:Classes/Datenbank/Adapter/Select/SelectQuery.php
        return implode("", $queryElemente) . ";";
=======
        return implode(" ", $queryElemente) . " ; ";
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2:Classes/Datenbank/Adapter/Select/SelectQueryAdapter.php
    }
}

