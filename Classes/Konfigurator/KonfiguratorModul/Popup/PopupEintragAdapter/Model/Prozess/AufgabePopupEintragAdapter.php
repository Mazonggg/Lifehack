<?php

namespace Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\Model\Prozess;

use Konfigurator\KonfiguratorModul\Popup\PopupEintragAdapter\PopupEintragAdapter;
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

