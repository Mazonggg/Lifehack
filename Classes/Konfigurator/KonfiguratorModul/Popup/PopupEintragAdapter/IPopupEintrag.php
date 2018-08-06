<?php

namespace Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;

interface IPopupEintrag extends IHtmlClass {

    /**
     * @return string
     */
    public function getPopupEintragHtml();
}

