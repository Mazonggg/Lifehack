<?php

namespace Konfigurator\HtmlModul\Menue\MenueEintragAdapter;

use Konfigurator\HtmlModul\IHtmlClass;
use Konfigurator\HtmlModul\IHtmlId;
use Konfigurator\HtmlModul\IHtmlTag;

interface IMenueEintragAdapter extends IHtmlTag, IHtmlId, IHtmlClass {

    /**
     * @return string
     */
    public function getMenuePunktHtml();
}

