<?php

namespace Anwendung\Konfigurator\Popup\PopupEintragAdapter;

use Model\Konstanten\AjaxKeywords;
use Model\IDatenbankEintrag;
use Model\Wertepaar;

abstract class PopupEintragAdapter implements IPopupEintrag {
    /**
     * @var IDatenbankEintrag
     */
    private $datenbankEintrag;

    /**
     * PopupListenEintragAdapter constructor.
     * @param IDatenbankEintrag $datenbankEintrag
     */
    public function __construct($datenbankEintrag) {
        $this->datenbankEintrag = $datenbankEintrag;
    }

    /**
     * @return string
     */
    public function getEintragHtml() {
        return '<' . $this->getTag() . ' class="' . $this->getClass() . '"><p>' . $this->getKurzInfo() . '</p>' .
            '<div class="popup_optionen">' .
            '<button id="' . $this->datenbankEintrag->getTabelle() . "_"
            . AjaxKeywords::AKTUALISIEREN . "-"
            . $this->datenbankEintrag->getId() .
            '" class="wechsel_button bearbeiten hoverbox">' .
            '</button>' .
            '</div>' .
            '</li>';
    }

    /**
     * @return string
     */
    abstract protected function getKurzInfo();

    /**
     * @return string
     */
    public function getId() {
        return '';
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'align_right';
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'li';
    }

    /**
     * @return Wertepaar[]
     */
    public function getAttribute() {
        return [];
    }
}

