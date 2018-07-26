<?php

namespace Datenbank\Adapter\Update;

use Datenbank\Adapter\IQueryAdapter;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class UpdateQuery implements IQueryAdapter {
    /**
     * @var string
     */
    private $tabelle = "";
    /**
     * @var array
     */
    private $queryDaten = [];
    /**
     * @var Wertepaar
     */
    private $primaerschluessel;

    /**
     * InsertQueryAdapter constructor.
     * @param string $tabelle
     * @param array $queryDaten
     * @param Wertepaar $primaerschluessel
     */
    public function __construct($tabelle, $queryDaten, $primaerschluessel) {
        $this->tabelle = $tabelle;
        $this->queryDaten = $queryDaten;
        $this->primaerschluessel = $primaerschluessel;
    }

    /**
     * @return string
     */
    public function getQuery() {
        return implode(" ", $this->getUpdateQueryParts()) . " ; ";
    }

    /**
     * @return string[]
     */
    protected function getUpdateQueryParts() {
        return [
            Keyword::UPDATE,
            $this->tabelle,
            Keyword::SET,
            $this->verketteDatenpaare($this->queryDaten),
            Keyword::WHERE,
            $this->verketteDatenpaare([$this->primaerschluessel->getSchluessel() => $this->primaerschluessel->getWert()])
        ];
    }

    /**
     * @param array $wertePaare
     * @return string
     */
    private function verketteDatenpaare($wertePaare) {
        $werte = "";
        foreach ($wertePaare as $schluessel => $wert) {
            $werte .= $schluessel . Keyword::EQUALS . "'" . $wert . "', ";
        }
        return substr($werte, 0, -2);
    }
}

