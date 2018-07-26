<?php

namespace Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;

interface IPopupEintragAdapter extends IHtmlClass {

    /**
     * @return string
     */
    public function getPopupEintragHtml();
}

