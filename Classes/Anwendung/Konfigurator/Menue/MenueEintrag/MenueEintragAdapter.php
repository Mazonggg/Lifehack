<?php

namespace Anwendung\Konfigurator\Menue\MenueEintrag;

use Anwendung\Konfigurator\ModulEintragAdapter;
use Model\Konstanten\AjaxKeywords;

class MenueEintragAdapter extends ModulEintragAdapter implements IMenueEintrag {

    /**
     * @return string
     */
    public function getClass() {
        return 'menue_block';
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->eintrag->getId();
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }

    /**
     * @return string
     */
    public function getEintragInhalt() {
        return '<div id="' . $this->eintrag->getTabelle() . '_menue" class="menue_block">' .
            $this->getMenueButton($this->eintrag->getTabelle()) .
            '</div>';
    }

    /**
     * @param string $tabelle
     * @return string
     */
    private function getMenueButton($tabelle) {
        return '<div class="menue_head align_right"><p>' . ucfirst($tabelle) . '</p>' .
            '<button id="' . $tabelle . "_" . AjaxKeywords::BEARBEITEN . '" class="wechsel_button bearbeiten hoverbox"></button></div>';
    }
}

