<?php

namespace Anwendung\Konfigurator\Menue\MenueEintrag;

use Model\Konstanten\AjaxKeywords;

class MenueEintragAdapter implements IMenueEintrag {

    /**
     * @var string
     */
    private $tabelle;

    /**
     * MenueEintrag constructor.
     * @param string $tabelle
     */
    public function __construct($tabelle) {
        $this->tabelle = $tabelle;
    }

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
        return $this->tabelle;
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
    public function getEintragHtml() {
        return '<div id="' . $this->tabelle . '_menue" class="menue_block">' .
            $this->getMenueButton($this->tabelle) .
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

