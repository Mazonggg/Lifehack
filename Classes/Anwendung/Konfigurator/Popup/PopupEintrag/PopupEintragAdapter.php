<?php

namespace Anwendung\Konfigurator\Popup\PopupEintrag;

use Anwendung\Konfigurator\ModulEintragAdapter;
use Model\Konstanten\AjaxKeywords;
use Model\Wertepaar;

abstract class PopupEintragAdapter extends ModulEintragAdapter implements IPopupEintrag {

    /**
     * @return string
     */
    public function getEintragInhalt() {
        return '<' . $this->getTag() . ' class="' . $this->getClass() . '"><p>' . $this->getKurzInfo() . '</p>' .
            '<div class="popup_optionen">' .
            '<button id="' . $this->eintrag->getTabelle() . "_"
            . AjaxKeywords::AKTUALISIEREN . "-"
            . $this->eintrag->getId() .
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

