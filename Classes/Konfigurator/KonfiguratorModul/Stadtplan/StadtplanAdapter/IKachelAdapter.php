<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\StadtplanAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;
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

