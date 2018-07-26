<?php

namespace Datenbank\Adapter;

use Datenbank\Model\Tabelle;

abstract class Query implements IQueryAdapter {

    /**
     * @var Tabelle
     */
    protected $tabelle;

    /**
     * QueryAdapter constructor.
     * @param Tabelle $tabelle
     */
    public function __construct($tabelle) {
        $this->tabelle = $tabelle;
    }
}

