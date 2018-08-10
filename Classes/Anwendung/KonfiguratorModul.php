<?php

namespace Anwendung;

use Anwendung\Konfigurator\Form\FormModul;
use Anwendung\Konfigurator\HeaderAbrufer;
use Anwendung\Konfigurator\IModul;
use Anwendung\Konfigurator\Menue\MenueModul;
use Anwendung\Konfigurator\Popup\PopupModul;
use Anwendung\Konfigurator\Stadtplan\StadtplanModul;
use Model\Fabrik\Aufgabe\AufgabeFabrik;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Fabrik\Einrichtung\InstitutFabrik;
use Model\IDatenbankEintrag;
use Model\ModelHandler;

class KonfiguratorModul implements IModul {
    /**
     * @var KonfiguratorModul|null
     */
    private static $_instance = null;

    /**
     * @return KonfiguratorModul
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();

            self::$_instance->popupModul = PopupModul::Instance();
            self::$_instance->menueModul = MenueModul::Instance();
            self::$_instance->formModul = FormModul::Instance();
            self::$_instance->stadtplanModul = StadtplanModul::Instance();
            self::$_instance->headerAbrufer = HeaderAbrufer::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var IModul
     */
    private $popupModul, $menueModul, $formModul, $stadtplanModul;

    /**
     * @var HeaderAbrufer
     */
    private $headerAbrufer;

    /**
     * @return string
     */
    public function getCssUrl() {
        return "css/konfigurator.css";
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return "js/konfigurator.js";
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getModulHtml($eintraege) {
        return '<!DOCTYPE html><html lang="en">' .
            $this->headerAbrufer->getHeader() . $this->getInhalt($eintraege) . '</html>';
    }

    /**
     * @return IModul[]
     */
    public function getModule() {
        return [$this, $this->popupModul, $this->menueModul, $this->formModul, $this->stadtplanModul];
    }

    /**
     * @return string
     */
    private function getHtmlVonModulen() {
        $html = $this->popupModul->getModulHtml([]);
        $html .= $this->menueModul->getModulHtml([
            ItemFabrik::Instance()->erzeugeLeeresEintragObjekt(),
            InstitutFabrik::Instance()->erzeugeLeeresEintragObjekt(),
            AufgabeFabrik::Instance()->erzeugeLeeresEintragObjekt()
        ]);
        $html .= $this->formModul->getModulHtml([]);
        return $html . $this->stadtplanModul->getModulHtml(ModelHandler::Instance()->getKartenelemente());
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhalt($eintraege) {
        return '<body>' .
            $this->getHtmlVonModulen() .
            '</body>';
    }
}

