<?php

use Austauschformat\AustauschGenerator;
use Konfigurator\Konfigurator;
use Model\Konstanten\AjaxKeywords;

include('autoloader.php');

<<<<<<< HEAD
echo Index::getContent();

class Index {

    public static function getContent() {
        if (isset($_GET[AjaxKeywords::MODUS]) && $_GET[AjaxKeywords::MODUS] == self::KONFIG) {
            $konfigurator = Konfigurator::Instance();
            return $konfigurator->getModulHtml();
        } elseif (isset($_GET[AjaxKeywords::MODUS]) && $_GET[AjaxKeywords::MODUS] == self::JSON) {
            $austauschAbruf = AustauschGenerator::Instance();
            return $austauschAbruf->getJsonKomplett();
        } else {
            return self::getMenueLink(self::JSON) . self::getMenueLink(self::KONFIG);
        }
    }

    const PARAMETER_QUERY = "?modus=";
    const JSON = "JSON";
    const KONFIG = "Konfigurator";

    private static function getMenueLink($modus) {
        return "<p class='link'><a href='" . self::PARAMETER_QUERY . "$modus'>" . $modus . "</a></p>";
    }
}
=======
$htmlGenerator = HtmlGenerator::Instance();
$htmlGenerator->setModus((isset($_GET[HtmlGenerator::MODUS]) ? $_GET[HtmlGenerator::MODUS] : null));
echo $htmlGenerator->getContent();

>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2

