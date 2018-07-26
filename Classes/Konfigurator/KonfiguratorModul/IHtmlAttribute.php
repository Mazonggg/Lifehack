<?php

namespace Konfigurator\KonfiguratorModul;

use Model\Wertepaar;

interface IHtmlAttribute {

    /**
     * @return Wertepaar[]
     */
    public function getAttribute();
}

