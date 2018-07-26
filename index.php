<?php

use Austauschformat\AustauschGenerator;
use Konfigurator\Konfigurator;
use Model\Konstanten\AjaxKeywords;

include('autoloader.php');

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

