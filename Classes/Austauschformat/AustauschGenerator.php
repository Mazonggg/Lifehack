<?php

namespace Austauschformat;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Stadtplan\StadtplanModulAdapter;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Kartenschreiber;
use Singleton\SingletonPattern;

class AustauschGenerator extends SingletonPattern {
    /**
     * @var AustauschGenerator|null
     */
    protected static $_instance = null;

    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->dbhandler = DatenbankAbrufHandler::Instance();
            self::$_instance->kartenSchreiber = Kartenschreiber::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var DatenbankAbrufHandler
     */
    private $dbhandler;

    /**
     * @var Kartenschreiber
     */
    private $kartenSchreiber;


    /**
     * @return string
     */
    public function getJsonKomplett() {
        $datenKomplett = $this->getDatenKomplett();
        return htmlspecialchars_decode(json_encode($datenKomplett));
    }

    /**
     * @return array
     */
    public function getDatenKomplett() {
        $jsonInformation = $this->getDatenInformationen();
        $karte = $this->kartenSchreiber->schreibeKarte($jsonInformation[TabellenName::KARTENELEMENT]);
        $jsonInformation[TabellenName::KARTENELEMENT] = $this->entferneAbmessungen($jsonInformation[TabellenName::KARTENELEMENT]);
        return [
            AustauschKonstanten::KONFIGURATION => $this->getDatenConfig(),
            AustauschKonstanten::INFORMATION => $jsonInformation,
            AustauschKonstanten::KARTE => $karte
        ];
    }

    /**
     * @return array
     */
    private function getDatenConfig() {
        return [
            AustauschKonstanten::KACHEL_GROESSE => StadtplanModulAdapter::KACHELGROESZE
        ];
    }

    /**
     * @return array
     */
    private function getDatenInformationen() {
        return [
            TabellenName::INSTITUT => $this->dbhandler->findElementDaten(TabellenName::INSTITUT),
            TabellenName::ITEM => $this->dbhandler->findElementDaten(TabellenName::ITEM),
            TabellenName::KARTENELEMENT => $this->dbhandler->findElementDaten(TabellenName::KARTENELEMENT),
            TabellenName::AUFGABE => $this->dbhandler->findElementDaten(TabellenName::AUFGABE)
        ];
    }

    private function entferneAbmessungen($legende) {
        $neueLegende = [];
        foreach ($legende as $eintrag) {
            unset($eintrag[TabellenName::ABMESSUNG]);
            array_push($neueLegende, $eintrag);
        }
        return $neueLegende;
    }
}

