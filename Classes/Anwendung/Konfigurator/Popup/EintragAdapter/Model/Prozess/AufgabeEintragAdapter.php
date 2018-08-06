<?php

namespace Anwendung\Konfigurator\Popup\EintragAdapter\Model\Prozess;

use Anwendung\Konfigurator\Popup\EintragAdapter\EintragAdapter;
use Model\Prozess\Aufgabe;

class AufgabeEintragAdapter extends EintragAdapter {

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

