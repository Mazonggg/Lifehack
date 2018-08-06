<?php

namespace Anwendung\Konfigurator;

use Model\Wertepaar;

interface IHtmlAttribute {

    /**
     * @return Wertepaar[]
     */
    public function getAttribute();
}

