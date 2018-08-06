<?php

namespace Konfigurator;

use Konfigurator\KonfiguratorModul\Form\FormModulAdapter;
use Konfigurator\KonfiguratorModul\HeaderAbrufer;
use Konfigurator\KonfiguratorModul\HtmlModulAdapter;
use Konfigurator\KonfiguratorModul\IHtmlModul;
use Konfigurator\KonfiguratorModul\Menue\MenueEintragAdapter\SimpleMenueEintragFabrik;
use Konfigurator\KonfiguratorModul\Menue\MenueModulAdapter;
use Konfigurator\KonfiguratorModul\Popup\PopupModulAdapter;
use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\SimpleKachelFabrik;
use Konfigurator\KonfiguratorModul\Stadtplan\StadtplanModulAdapter;
use Model\Konstanten\TabellenName;
use Model\ModelHandler;

class Konfigurator extends HtmlModulAdapter {
    /**
     * @var Konfigurator|null
     */
    private static $_instance = null;

    /**
     * @return Konfigurator
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            $menueEintraege = [
                SimpleMenueEintragFabrik::erzeugeMenueEintrag(TabellenName::ITEM),
                SimpleMenueEintragFabrik::erzeugeMenueEintrag(TabellenName::INSTITUT),
                SimpleMenueEintragFabrik::erzeugeMenueEintrag(TabellenName::AUFGABE)

            ];
            $kacheln = [];
            foreach (ModelHandler::Instance()->getKartenelementDaten() as $kartenelement) {
                $kacheln = array_merge($kacheln, SimpleKachelFabrik::erzeugeKacheln($kartenelement));
            }
            self::$_instance->htmlModule = [
                self::$_instance,
                PopupModulAdapter::Instance(),
                MenueModulAdapter::Instance($menueEintraege),
                FormModulAdapter::Instance(),
                StadtplanModulAdapter::Instance($kacheln)
            ];
            self::$_instance->headerGenerator = HeaderAbrufer::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var IHtmlModul[]
     */
    private $htmlModule;

    /**
     * @var HeaderAbrufer
     */
    private $headerGenerator;

    /**
     * @return IHtmlModul[]
     */
    public function getHtmlModule() {
        return $this->htmlModule;
    }

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
     * @return string
     */
    protected function getInhalt() {
        return '<html lang="en">' .
            $this->headerGenerator->getHeader() .
            '<body>' .
            $this->getHtmlVonModulen() .
            '</body></html>';
    }

    public function getModulHtml($inhalt = "") {
        return '<!DOCTYPE html>' . $this->getInhalt();
    }

    /**
     * @return string
     */
    private function getHtmlVonModulen() {
        $html = "";
        foreach ($this->htmlModule as $htmlModul) {
            if ($htmlModul !== $this) {
                $html .= $htmlModul->getModulHtml();
            }
        }
        return $html;
    }

    /**
     * @return string
     */
    public function getClass() {
        return '';
    }

    /**
     * @return string
     */
    public function getTag() {
        return $this->getClass();
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->getTag();
    }
}

