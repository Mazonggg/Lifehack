<?php

namespace Anwendung\Konfigurator\Menue;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\ModulAdapter;
use Anwendung\Konfigurator\Menue\MenueEintragAdapter\IMenueEintrag;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class MenueModulAdapter extends ModulAdapter {
    /**
     * @var MenueModulAdapter|null
     */
    private static $_instance = null;

    /**
     * @param string[] $elementArten
     * @return MenueModulAdapter
     */
    public static function Instance($elementArten = []) {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->elementArten = $elementArten;
        }
        return self::$_instance;
    }

    /**
     * @var IMenueEintrag[]
     */
    private $elementArten = [];


    /**
     * @return string
     */
    public function getCssUrl() {
        return 'css/menue.css';
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return 'js/menue.js';
    }

    /**
     * @return string
     */
    protected function getInhalt() {
        $menue =
            '<div id="logo_container" class="logo_container">' .
            '<p id="logo" class="logo">Lifehack</p>' .
            '</div>' .
            '<div id="menue" class="menue">' .
            '<h3>Inhalte bearbeiten</h3>';
        foreach ($this->elementArten as $elementArt) {
            $menue .= $elementArt->getMenuePunktHtml();
        }
        $menue .= '</div><div id="stadtplan_menue" class="menue">' .
            '<h3>Kartenelement hinzuf&uuml;gen</h3>';
        $kartenelementArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::KARTENELEMENT_ART,
            TabellenName::KARTENELEMENT_ART . "." . TabellenName::KARTENELEMENT_ART . Keyword::NAME
        );
        foreach ($kartenelementArten as $kartenelementArt) {
            $menue .= '<div class="menue_block">' .
                '<div class="menue_head align_right"><p>' . ucfirst($kartenelementArt->getWert()) . '</p>' .
                '<button id="' . $kartenelementArt->getWert() . '_' . AjaxKeywords::ERSTELLEN . '" class="wechsel_button hinzu hoverbox">' .
                '</button></div></div>';
        }
        return $menue . '</div>';
    }

    /**
     * @return string
     */
    public function getId() {
        return 'menue_container';
    }

    /**
     * @return string
     */
    public function getClass() {
        return $this->getId();
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }
}

