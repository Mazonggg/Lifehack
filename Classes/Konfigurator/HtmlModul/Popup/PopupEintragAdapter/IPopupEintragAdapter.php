<?php

namespace Konfigurator\HtmlModul\Popup\PopupEintragAdapter;

use Konfigurator\HtmlModul\IHtmlClass;

interface IPopupEintragAdapter extends IHtmlClass {

    /**
     * @return string
     */
    public function getPopupEintragHtml();
}

