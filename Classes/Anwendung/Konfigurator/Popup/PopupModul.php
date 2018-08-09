<?php

namespace Anwendung\Konfigurator\Popup;

use Anwendung\Konfigurator\Modul;
use Anwendung\Konfigurator\Popup\PopupEintrag\IPopupEintrag;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Einrichtung\InstitutPopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Prozess\AufgabePopupEintragAdapter;
use Anwendung\Konfigurator\Popup\PopupEintrag\Model\Prozess\ItemPopupEintragAdapter;
use Model\Einrichtung\Institut;
use Model\IDatenbankEintrag;
use Model\Konstanten\AjaxKeywords;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;

class PopupModul extends Modul {
    /**
     * @var PopupModul|null
     */
    private static $_instance = null;

    /**
     * @return PopupModul
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
        return 'popup_container';
    }

    /**
     * @param IDatenbankEintrag $eintrag
     * @return IPopupEintrag
     */
    protected function erzeugeEintragAdapter($eintrag) {
        if ($eintrag instanceof Aufgabe) {
            $eintragAdapter = new AufgabePopupEintragAdapter($eintrag);
        } elseif ($eintrag instanceof Item) {
            $eintragAdapter = new ItemPopupEintragAdapter($eintrag);
        } elseif ($eintrag instanceof Institut) {
            $eintragAdapter = new InstitutPopupEintragAdapter($eintrag);
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

