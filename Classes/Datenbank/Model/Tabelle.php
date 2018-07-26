<?php

namespace Datenbank\Model;

class Tabelle {
    /**
     * @var string
     */
    private $tabellenName = "";
    /**
     * @var string
     */
    private $primaerschluessel = "";
    /**
     * @var string[]
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
     * @param string $primaerschluessel
     * @param string[] $spalten
     * @param Relation[] $relationen
     * @param GroupConcat[] $groupConcats
     */
    public function __construct($tabellenName, $primaerschluessel = "", $spalten = [], $relationen = [], $groupConcats = []) {
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
     * @return string
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
     * @return string[]
     */
    public function getSpalten($mitSchluessel) {
        /**
         * @var string[]
         */
        return array_merge(($mitSchluessel ? [$this->primaerschluessel] : []), $this->spalten);
    }
}

