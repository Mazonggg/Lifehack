<?php

namespace Datenbank\Adapter;

interface IQueryAdapter {
    /**
     * @param int|bool $letzteId
     * @return string
     */
    public function getQuery($letzteId = false);
}

