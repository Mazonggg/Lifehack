<?php

namespace Anwendung\Konfigurator;

use Model\IDatenbankEintrag;

interface IModul {

    /**
     * @return string
     */
    public function getCssUrl();

    /**
     * @return string
     */
    public function getJavaScriptUrl();

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getModulHtml($eintraege);
}

