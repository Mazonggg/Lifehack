<?php

namespace Model;

interface IDatenbankEintrag {

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getTabelle();
}

