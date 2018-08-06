<?php

namespace Konfigurator\KonfiguratorModul\Menue\MenueEintragAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;
use Konfigurator\KonfiguratorModul\IHtmlId;
use Konfigurator\KonfiguratorModul\IHtmlTag;

interface IMenueEintrag extends IHtmlTag, IHtmlId, IHtmlClass {

    /**
     * @return string
     */
    public function getMenuePunktHtml();
}

