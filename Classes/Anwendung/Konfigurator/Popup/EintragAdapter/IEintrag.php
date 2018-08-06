<?php

namespace Anwendung\Konfigurator\Popup\EintragAdapter;

use Anwendung\Konfigurator\IHtmlClass;

interface IEintrag extends IHtmlClass {

    /**
     * @return string
     */
    public function getPopupEintragHtml();
}

