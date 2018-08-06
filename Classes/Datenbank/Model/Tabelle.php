<?php

namespace Datenbank\Model;

use Model\Wertepaar;

class Tabelle {
    /**
     * @var string
     */
    private $tabellenName = '';
    /**
     * @var Wertepaar
     */
    private $primaerschluessel = null;
    /**
     * @var Wertepaar[]
     */
    private $spalten = [];
    /**
     * @var Relation[]
     */
    private $relationen = [];
    /**
     * @var GroupConcat[]
     */
    private $groupConcats = [];

    /**
     * DbTabelle constructor.
     * @param string $tabellenName
     * @param Wertepaar $primaerschluessel
     * @param Wertepaar[] $spalten
     * @param Relation[] $relationen
     * @param GroupConcat[] $groupConcats
     */
    public function __construct($tabellenName, $spalten = [], $primaerschluessel = null, $relationen = [], $groupConcats = []) {
        $this->tabellenName = $tabellenName;
        $this->primaerschluessel = $primaerschluessel;
        $this->spalten = $spalten;
        $this->relationen = $relationen;
        $this->groupConcats = $groupConcats;
    }

    /**
     * @return string
     */
    public function getTabellenName() {
        return $this->tabellenName;
    }

    /**
     * @return Wertepaar
     */
    public function getPrimaerschluessel() {
        return $this->primaerschluessel;
    }

    /**
     * @return Relation[]
     */
    public function getRelationen() {
        return $this->relationen;
    }

    /**
     * @return GroupConcat[]
     */
    public function getGroupConcats() {
        return $this->groupConcats;
    }

    /**
     * @param bool $mitSchluessel
     * @return Wertepaar[]
     */
    public function getSpalten($mitSchluessel) {
        /**
         * @var Wertepaar[]
         */
        return array_merge(($mitSchluessel ? [$this->primaerschluessel] : []), $this->spalten);
    }
}

