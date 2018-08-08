<?php

namespace Anwendung\Konfigurator\Menue\MenueEintrag;

use Model\IDatenbankEintrag;
use Model\Konstanten\AjaxKeywords;

class MenueEintragAdapter implements IMenueEintrag {

    /**
     * @var IDatenbankEintrag
     */
    private $datenbankEintrag;

    /**
     * MenueEintragAdapter constructor.
     * @param IDatenbankEintrag $datenbankEintrag
     */
    public function __construct(IDatenbankEintrag $datenbankEintrag) {
        $this->datenbankEintrag = $datenbankEintrag;
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
        return $this->datenbankEintrag->getId();
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
        return '<div id="' . $this->datenbankEintrag->getTabelle() . '_menue" class="menue_block">' .
            $this->getMenueButton($this->datenbankEintrag->getTabelle()) .
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

