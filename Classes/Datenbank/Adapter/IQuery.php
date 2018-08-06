<?php

namespace Datenbank\Adapter;

interface IQuery {
    /**
     * @return string
     */
    public function getQuery();
}

