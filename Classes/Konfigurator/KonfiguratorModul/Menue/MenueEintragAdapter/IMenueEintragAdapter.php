<?php

namespace Konfigurator\KonfiguratorModul\Menue\MenueEintragAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;
use Konfigurator\KonfiguratorModul\IHtmlId;
use Konfigurator\KonfiguratorModul\IHtmlTag;

interface IMenueEintragAdapter extends IHtmlTag, IHtmlId, IHtmlClass {

    /**
     * @return string
     */
    public function getMenuePunktHtml();
}

