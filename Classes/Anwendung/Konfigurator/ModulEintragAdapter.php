<?php

namespace Anwendung\Konfigurator;

use Model\IDatenbankEintrag;

abstract class ModulEintragAdapter implements IModulEintrag {
    /**
     * @var IDatenbankEintrag
     */
    protected $datenbankEintrag;

    /**
     * ModulEintragAdapter constructor.
     * @param IDatenbankEintrag $datenbankEintrag
     */
    public function __construct(IDatenbankEintrag $datenbankEintrag) {
        $this->datenbankEintrag = $datenbankEintrag;
    }
}

