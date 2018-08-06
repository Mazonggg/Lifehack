<?php

namespace Anwendung\Konfigurator;

interface IModul extends IHtmlClass, IHtmlTag, IHtmlId {

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

