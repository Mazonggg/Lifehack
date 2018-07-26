<?php

namespace Konfigurator\HtmlModul;

interface IHtmlModul extends IHtmlClass, IHtmlTag, IHtmlId {

    /**
     * @return string
     */
    public function getCssUrl();

    /**
     * @return string
     */
    public function getJavaScriptUrl();

    /**
     * @return string
     */
    public function getModulHtml();
}

