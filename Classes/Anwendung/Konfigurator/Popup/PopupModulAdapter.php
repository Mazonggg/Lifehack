<?php

namespace Anwendung\Konfigurator\Popup;

use Anwendung\Konfigurator\ModulAdapter;

class PopupModulAdapter extends ModulAdapter {
    /**
     * @var PopupModulAdapter|null
     */
    private static $_instance = null;

    /**
     * @return PopupModulAdapter
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return string
     */
    public function getCssUrl() {
        return 'css/popup.css';
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return 'js/popup.js';
    }

    /**
     * @return string
     */
    protected function getInhalt() {
        return
            '<div id="popup_titel_container" class="align_right">' .
            '<h2 id="popup_titel"></h2>' .
            '<button id="popup_schliesser" class="wechsel_button schliessen hoverbox">' .
            '</button>' .
            '</div>';
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'popup_container';
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->getClass();
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }
}

