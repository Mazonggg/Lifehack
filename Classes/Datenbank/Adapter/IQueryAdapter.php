<?php

namespace Datenbank\Adapter;

interface IQueryAdapter {
    /**
     * @return string
     */
    public function getQuery();
}

