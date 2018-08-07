<?php

namespace Anwendung\Konfigurator\Popup\PopupEintrag\Model\Prozess;

use Anwendung\Konfigurator\Popup\PopupEintrag\PopupEintragAdapter;
use Model\Prozess\Aufgabe;

class AufgabePopupEintragAdapter extends PopupEintragAdapter {

    /**
     * @var Aufgabe
     */
    private $aufgabe;

    /**
     * AufgabePopupListenEintrag constructor.
     * @param Aufgabe $aufgabe
     */
    public function __construct($aufgabe) {
        parent::__construct($aufgabe);
        $this->aufgabe = $aufgabe;
    }

    /**
     * @return string
     */
    protected function getKurzInfo() {
        return $this->aufgabe->getBezeichnung();
    }
}

