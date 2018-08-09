<?php

use Austauschformat\AustauschAbrufer;
use Anwendung\KonfiguratorModul;
use Model\Konstanten\AjaxKeywords;

include('autoloader.php');

echo Index::getContent();

class Index {

    public static function getContent() {

        if (isset($_GET[AjaxKeywords::MODUS]) && $_GET[AjaxKeywords::MODUS] == self::KONFIG) {
            $konfiguratorModul = KonfiguratorModul::Instance();
            return $konfiguratorModul->getModulHtml([]);
        } elseif (isset($_GET[AjaxKeywords::MODUS]) && $_GET[AjaxKeywords::MODUS] == self::JSON) {
            $austauschAbrufer = AustauschAbrufer::Instance();
            return $austauschAbrufer->getJsonKomplett();
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

