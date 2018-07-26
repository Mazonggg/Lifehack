<?php

namespace Konfigurator\HtmlModul;

use Model\Wertepaar;

interface IHtmlAttribute {

    /**
     * @return Wertepaar[]
     */
    public function getAttribute();
}

