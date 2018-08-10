<?php

namespace Anwendung\Konfigurator\Menue;

use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IHtmlId;
use Anwendung\Konfigurator\IHtmlTag;
use Anwendung\Konfigurator\Menue\MenueEintrag\MenueEintragAdapter;
use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Modul;
use Anwendung\Konfigurator\Menue\MenueEintrag\IMenueEintrag;
use Model\IDatenbankEintrag;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class MenueModul extends Modul implements IHtmlClass, IHtmlTag, IHtmlId {
    /**
     * @var MenueModul|null
     */
    private static $_instance = null;

    /**
     * @return MenueModul
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
        return 'css/menue.css';
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return 'js/menue.js';
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    protected function getContainerHtml($eintraege) {
        $menue =
            '<div id="logo_container" class="logo_container">' .
            '<p id="logo" class="logo">Lifehack</p>' .
            '</div>' .
            '<div id="menue" class="menue">' .
            '<h3>Inhalte bearbeiten</h3>';
        $menue .= $this->getInhalt($eintraege);
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
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhalt($eintraege) {
        /**
         * @var IMenueEintrag[] $elementArten
         */
        $elementArten = $this->erzeugeEintragAdapters($eintraege);
        $menue = '';
        foreach ($elementArten as $elementArt) {
            $menue .= $elementArt->getEintragInhalt();
        }
        return $menue;
    }

    /**
     * @return string
     */
    public function getId() {
        return 'menue_container';
    }

    /**
     * @param IDatenbankEintrag $eintrag
     * @return IMenueEintrag
     */
    protected function erzeugeEintragAdapter($eintrag) {
        return new MenueEintragAdapter($eintrag);
    }
}

