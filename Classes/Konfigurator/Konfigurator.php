<?php

namespace Konfigurator;

<<<<<<< HEAD
use Konfigurator\HtmlModul\Form\FormModul;
use Konfigurator\HtmlModul\HeaderAbrufer;
use Konfigurator\HtmlModul\HtmlModul;
use Konfigurator\HtmlModul\IHtmlModul;
use Konfigurator\HtmlModul\Menue\MenueEintragAdapter\SimpleMenueEintragFabrik;
use Konfigurator\HtmlModul\Menue\MenueModul;
use Konfigurator\HtmlModul\ModulAbrufer;
use Konfigurator\HtmlModul\Popup\PopupModul;
use Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\SimpleKachelFabrik;
use Konfigurator\HtmlModul\Stadtplan\StadtplanModul;
use Model\Konstanten\TabellenName;

class Konfigurator extends HtmlModul {
=======
use Datenbank\DatenbankAbrufHandler;
use Konfigurator\Fabrik\Aufgabe\AufgabeFabrik;
use Konfigurator\Fabrik\Aufgabe\ItemFabrik;
use Konfigurator\Fabrik\Institut\InstitutFabrik;
use Konfigurator\Fabrik\Institut\NiederlassungFabrik;
use Konfigurator\Fabrik\Stadtplan\GebaeudeFabrik;
use Konfigurator\Fabrik\Stadtplan\UmweltFabrik;
use Konfigurator\Fabrik\Stadtplan\WohnhausFabrik;

use Konfigurator\HtmlGenerator\Menue\MenueGenerator;
use Konfigurator\HtmlGenerator\Stadtplan\StadtplanGenerator;
use Konfigurator\Pattern\DatenbankEintragPattern;
use Model\Stadtplan\Kartenelement;
use Pattern\SingletonPattern;

class Konfigurator extends SingletonPattern implements IHtmlObjekt {
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
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
            self::$_instance->htmlModule = [
                self::$_instance,
                PopupModul::Instance(),
                MenueModul::Instance(
                    SimpleMenueEintragFabrik::erzeugeMenueEintraege([
                        TabellenName::ITEM,
                        TabellenName::INSTITUT,
                        TabellenName::AUFGABE
                    ])),
                FormModul::Instance(),
                StadtplanModul::Instance(
                    SimpleKachelFabrik::erzeugeKacheln(
                        ModulAbrufer::Instance()->getKartenelementDaten()
                    ))
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
<<<<<<< HEAD
     * @return IHtmlModul[]
     */
    public function getHtmlModule() {
        return $this->htmlModule;
    }
=======
     * @var StadtplanGenerator
     */
    private $stadtplanGenerator;
    /**
     * @var MenueGenerator
     */
    private $menueGenerator;

>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2

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
<<<<<<< HEAD
    public function getClass() {
        return '';
=======
    public function getCssUrl() {
        return "css/konfigurator.css";
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getTag() {
        return $this->getClass();
=======
    public function getHtml() {
        $institute = $this->getInstitutDaten();
        $items = $this->getItemDaten();
        $aufgaben = $this->getAufgabeDaten();
        $this->menueGenerator = MenueGenerator::Instance($items, $institute, $aufgaben);
        $this->stadtplanGenerator = StadtplanGenerator::Instance($this->getKartenelementDaten());
        return
            $this->menueGenerator->getHtml() .
            $this->stadtplanGenerator->getHtml() .
            $this->getLogoHtml();
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getId() {
        return $this->getTag();
=======
    public function getJavaScriptUrl() {
        return "js/konfigurator.js";
    }

    /**
     * @return string
     */
    private function getLogoHtml() {
        return ;
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
    }
}

