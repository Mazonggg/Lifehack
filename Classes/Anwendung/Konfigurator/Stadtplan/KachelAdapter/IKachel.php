<?php

namespace Anwendung\Konfigurator\Stadtplan\KachelAdapter;

use Anwendung\Konfigurator\IHtmlClass;
use Model\Stadtplan\Abmessung;

interface IKachel extends IHtmlClass {

    /**
     * @return string
     */
    public function getKachelHtml();

    /**
     * @return Abmessung
     */
    public function getAbmessung();
}

