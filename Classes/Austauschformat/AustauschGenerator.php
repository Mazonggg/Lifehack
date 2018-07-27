<?php

namespace Austauschformat;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Stadtplan\StadtplanModul;
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
            self::$_instance->uniqueAschiiGenerator = UniqueAsciiGenerator::Instance();
            self::$_instance->kartenSchreiber = Kartenschreiber::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var DatenbankAbrufHandler
     */
    private $dbhandler;

    /**
     * @var UniqueAsciiGenerator
     */
    private $uniqueAschiiGenerator;

    /**
     * @var Kartenschreiber
     */
    private $kartenSchreiber;


    /**
     * @return string
     */
    public function getJsonKomplett() {
        return json_encode($this->getDatenKomplett());
    }

    /**
     * @return array
     */
    public function getDatenKomplett() {
        $jsonInformation = $this->getDatenInformationen();
        $karte = $this->getDatenKarte($jsonInformation[TabellenName::KARTENELEMENT]);
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
            AustauschKonstanten::ASCII_LAENGE => $this->uniqueAschiiGenerator->getLaenge(),
            AustauschKonstanten::KACHEL_GROESSE => StadtplanModul::KACHELGROESZE
        ];
    }

    /**
     * @return array
     */
    private function getDatenInformationen() {
        return [
            TabellenName::INSTITUT => $this->dbhandler->findElementDaten(TabellenName::INSTITUT),
            TabellenName::ITEM => $this->dbhandler->findElementDaten(TabellenName::ITEM),
            TabellenName::KARTENELEMENT => $this->macheArrayAsciiIdentified($this->dbhandler->findElementDaten(TabellenName::KARTENELEMENT)),
            TabellenName::AUFGABE => $this->dbhandler->findElementDaten(TabellenName::AUFGABE)
        ];
    }

    /**
     * @param array $legende
     * @return array
     */
    private function getDatenKarte($legende) {
        return $this->kartenSchreiber->schreibeKarte($legende);
    }

    private function entferneAbmessungen($legende) {
        $neueLegende = [];
        foreach ($legende as $eintrag) {
            unset($eintrag[TabellenName::ABMESSUNG]);
            array_push($neueLegende, $eintrag);
        }
        return $neueLegende;
    }

    /**
     * @param array $array
     * @return array
     */
    private function macheArrayAsciiIdentified($array) {
        $newArray = [];
        foreach ($array as $arrayData) {
            $arrayData[AustauschKonstanten::ASCII_IDENTIFIERT] = $this->uniqueAschiiGenerator->naechteZeichenkette();
            array_push($newArray, $arrayData);
        }
        return $newArray;

    }
}

