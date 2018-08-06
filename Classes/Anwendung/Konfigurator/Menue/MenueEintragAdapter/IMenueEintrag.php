<?php

namespace Anwendung\Konfigurator\Menue\MenueEintragAdapter;

use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IHtmlId;
use Anwendung\Konfigurator\IHtmlTag;

interface IMenueEintrag extends IHtmlTag, IHtmlId, IHtmlClass {

    /**
     * @return string
     */
    public function getMenuePunktHtml();
}

