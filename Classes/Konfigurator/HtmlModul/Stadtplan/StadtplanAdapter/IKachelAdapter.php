<?php

namespace Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter;

use Konfigurator\HtmlModul\IHtmlClass;
use Model\Stadtplan\Abmessung;

interface IKachelAdapter extends IHtmlClass {

    /**
     * @return string
     */
    public function getKachelHtml();

    /**
     * @return Abmessung
     */
    public function getAbmessung();
}

