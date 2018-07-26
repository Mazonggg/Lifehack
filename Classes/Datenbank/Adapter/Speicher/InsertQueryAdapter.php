<?php

namespace Datenbank\Adapter\Speicher;

use Datenbank\Adapter\IQueryAdapter;
use Model\Enum\Keyword;

class InsertQueryAdapter implements IQueryAdapter {
    /**
     * @var string
     */
    private $tabelle = "";
    /**
     * @var array
     */
    private $queryDaten = [];

    /**
     * InsertQueryAdapter constructor.
     * @param string $tabelle
     * @param array $queryDaten
     */
    public function __construct($tabelle, $queryDaten) {
        $this->tabelle = $tabelle;
        $this->queryDaten = $queryDaten;
    }

    /**
     * @param int|bool $letzteId
     * @return string
     */
    public function getQuery($letzteId = false) {
        if ($letzteId) {
            echo "<h1>letzteId</h1>";
            $this->ersetzeLetzteIdPlatzhalter($letzteId);
        }
        return implode(" ", $this->getInsertQueryParts()) . " ; ";
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
            $this->tabelle,
            Keyword::BRACKET_OPEN,
            implode(", ", array_keys($this->queryDaten)),
            Keyword::BRACKET_CLOSE,
            Keyword::VALUES,
            Keyword::BRACKET_OPEN,
            "'",
            implode("', '", array_values($this->queryDaten)),
            "'",
            Keyword::BRACKET_CLOSE
        ];
    }

    /**
     * @param int $letzteId
     */
    private function ersetzeLetzteIdPlatzhalter($letzteId) {
        foreach ($this->queryDaten as $schluessel => $wert) {
            if ($wert == SpeicherKeywords::LETZTE_ID) {
                $this->queryDaten[$schluessel] = $letzteId;
            }
        }
    }
}

