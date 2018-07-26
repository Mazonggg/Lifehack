<?php

namespace Konfigurator\HtmlModul\Popup\PopupEintragAdapter\Model\Prozess;

use Konfigurator\HtmlModul\Popup\PopupEintragAdapter\PopupEintrag;
use Model\Prozess\Aufgabe;

class AufgabePopupEintrag extends PopupEintrag {

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

