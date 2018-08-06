<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;
use Model\Stadtplan\Abmessung;

interface IKachel extends IHtmlClass {

    /**
     * @return string
     */
    public function getKachelHtml();

    /**
     * @return Abmessung
     */
    public function getAbmessung();
}

