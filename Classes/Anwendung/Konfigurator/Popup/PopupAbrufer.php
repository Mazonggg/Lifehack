<?php

namespace Anwendung\Konfigurator\Popup;

use Anwendung\Konfigurator\Popup\PopupEintragAdapter\IPopupEintrag;
use Model\Konstanten\AjaxKeywords;
use Model\Singleton\ISingleton;

class PopupAbrufer implements ISingleton {
    /**
     * @var PopupAbrufer|null
     */
    private static $_instance = null;

    /**
     * @return PopupAbrufer
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param string $tabelle
     * @param IPopupEintrag[] $blockDaten
     * @return string
     */
    public function getPopupBlockDaten($tabelle, $blockDaten) {
        $blockHtml = '<ul id="' . $tabelle . '_popup_block" class="popup_block">';
        foreach ($blockDaten as $block) {
            $blockHtml .= $block->getPopupEintragHtml();
        }
        return $blockHtml .
            '</ul>' .
            self::getHinzuButton($tabelle . "_" . AjaxKeywords::ERSTELLEN, $tabelle . " neu erstellen");
    }

    /**
     * @param string $zweckId
     * @param string $name
     * @return string
     */
    private static function getHinzuButton($zweckId, $name) {
        return
            '<div class="neu_button_container">' .
            '<button ' .
            'id="' . $zweckId . '" ' .
            'type="button" ' .
            'class="neu_button hoverbox" ' .
            'name="' . $name . '">' .
            ucfirst($name) .
            '</button>' .
            '</div>';
    }
}
