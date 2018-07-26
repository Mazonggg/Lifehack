<?php

namespace Konfigurator\HtmlGenerator;

use Austauschformat\AustauschGenerator;
use Konfigurator\Konfigurator;
use Pattern\SingletonPattern;

class HtmlGenerator extends SingletonPattern {
    /**
     * @var HtmlGenerator|null
     */
    protected static $_instance = null;

    /**
     * @return HtmlGenerator
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->headerGenerator = HeaderGenerator::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var string|null
     */
    private $modus = null;

    public function setModus($modus) {
        $this->modus = $modus;
    }

    const MODUS = "modus";
    const PARAMETER_QUERY = "?modus=";
    const JSON = "JSON";
    const KONFIG = "Konfigurator";
    const INFO = "Info";

    /**
     * @var HeaderGenerator
     */
    private $headerGenerator;

    /**
     * @return array|string
     */
    public function getContent() {
        $header = "";
        if ($this->modus == null) {
            $body = $this->getMenueLink(self::JSON) .
                $this->getMenueLink(self::KONFIG) .
                $this->getMenueLink(self::INFO);
        } else {
            $body = $this->geContentFuerModus();
        }
        if ($this->isSeite()) {
            $header = $this->headerGenerator->getHeader();
        }
        return "<!DOCTYPE html>
                    <html lang='en'>
                        $header
                        <body>
                            $body
                        </body>
                    </html>";
    }

    private function getMenueLink($modus) {
        return "<p class='link'><a href='" . self::PARAMETER_QUERY . "$modus'>" . $modus . "</a></p>";
    }

    /**
     * @return string
     */
    private function geContentFuerModus() {

        switch ($this->modus) {
            case self::JSON:
                $austauschAbruf = AustauschGenerator::Instance();
                $htmlAdapter = $austauschAbruf->getJsonKomplett();
                break;
            case self::KONFIG:
                $konfiguratorAbruf = Konfigurator::Instance();
                $htmlAdapter = $konfiguratorAbruf->getHtml();
                break;
            case self::INFO:
                $htmlAdapter = "<h1>" . self::INFO . " AUFGERUFEN </h1> ";
                break;
            default:
                $htmlAdapter = "<h1> " . self::INFO . " AUFGERUFEN </h1> ";
                break;
        }
        return $htmlAdapter;
    }

    /**
     * @return bool
     */
    private function isSeite() {
        return $this->modus != self::JSON;
    }
}

