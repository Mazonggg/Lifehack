<?php

namespace Anwendung\Konfigurator\Popup\PopupEintragAdapter;

use Anwendung\Konfigurator\IHtmlClass;

interface IPopupEintrag extends IHtmlClass {

    /**
     * @return string
     */
    public function getPopupEintragHtml();
}

