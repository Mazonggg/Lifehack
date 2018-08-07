<?php

namespace Anwendung\Konfigurator\Popup;

use Anwendung\Konfigurator\ModulAdapter;
use Anwendung\Konfigurator\Popup\PopupEintrag\IPopupEintrag;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Einrichtung\InstitutPopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Prozess\AufgabePopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Prozess\ItemPopupEintragAdapter;
use Model\Einrichtung\Institut;
use Model\IDatenbankEintrag;
use Model\Konstanten\AjaxKeywords;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;

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
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    protected function getContainerHtml($eintraege) {
        return
            '<div id="popup_titel_container" class="align_right">' .
            '<h2 id="popup_titel"></h2>' .
            '<button id="popup_schliesser" class="wechsel_button schliessen hoverbox">' .
            '</button>' .
            '</div>';
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhaltHtml($eintraege) {
        /**
         * @var IPopupEintrag[] $blockDaten
         */
        $blockDaten = $this->erzeugeEintragAdapters($eintraege);
        $tabelle = (isset($eintraege[0]) ? $eintraege[0]->getTabelle() : '');
        $blockHtml = '<ul id="' . $tabelle . '_popup_block" class="popup_block">';
        foreach ($blockDaten as $block) {
            $blockHtml .= $block->getEintragHtml();
        }
        return $blockHtml .
            '</ul>' .
            self::getHinzuButton($tabelle . "_" . AjaxKeywords::ERSTELLEN, $tabelle . " neu erstellen");
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
    public function getClass() {
        return 'popup_container';
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IPopupEintrag
     */
    protected function erzeugeEintragAdapter($datenbankEintrag) {
        if ($datenbankEintrag instanceof Aufgabe) {
            $eintragAdapter = new AufgabePopupEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Item) {
            $eintragAdapter = new ItemPopupEintragAdapter($datenbankEintrag);
        } elseif ($datenbankEintrag instanceof Institut) {
            $eintragAdapter = new InstitutPopupEintragAdapter($datenbankEintrag);
        } else {
            $eintragAdapter = null;
        }
        return $eintragAdapter;
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

