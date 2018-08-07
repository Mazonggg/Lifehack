<?php

namespace Anwendung\Konfigurator\Stadtplan\KachelAdapter;

use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IModulEintrag;
use Model\Stadtplan\Abmessung;

interface IKachel extends IModulEintrag, IHtmlClass {

    /**
     * @return Abmessung
     */
    public function getAbmessung();
}

