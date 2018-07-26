<?php

namespace Konfigurator;

interface IHtmlObjekt {

    /**
     * @return string
     */
    public function getCssUrl();

    /**
     * @return string
     */
    public function getHtml();

    /**
     * @return string
     */
    public function getJavaScriptUrl();
}

