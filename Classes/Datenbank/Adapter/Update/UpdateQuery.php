<?php

namespace Datenbank\Adapter\Update;

use Datenbank\Adapter\Query;
use Model\Konstanten\Keyword;
use Model\Wertepaar;

class UpdateQuery extends Query {

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
            $this->tabelle->getTabellenName(),
            Keyword::SET,
            $this->verketteDatenpaare($this->tabelle->getSpalten(false)),
            Keyword::WHERE,
            $this->verketteDatenpaare([$this->tabelle->getPrimaerschluessel()])
        ];
    }

    /**
     * @param Wertepaar[] $wertePaare
     * @return string
     */
    private function verketteDatenpaare($wertePaare) {
        $werte = "";
        foreach ($wertePaare as $wertePaar) {
            $werte .= $wertePaar->getSchluessel() . Keyword::EQUALS . "'" . $wertePaar->getWert() . "', ";
        }
        return substr($werte, 0, -2);
    }
}

