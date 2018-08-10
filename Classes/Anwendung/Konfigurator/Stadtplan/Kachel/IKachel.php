<?php

namespace Anwendung\Konfigurator\Stadtplan\Kachel;

use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IModulEintrag;
use Model\Stadtplan\Abmessung;

interface IKachel extends IModulEintrag, IHtmlClass {

    /**
     * @return Abmessung
     */
    public function getDatenbankEintrag();
}

