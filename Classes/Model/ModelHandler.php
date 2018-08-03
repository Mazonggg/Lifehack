<?php

namespace Model;

use Datenbank\DatenbankAbrufHandler;
use Model\Konstanten\TabellenName;
use Model\Fabrik\Aufgabe\AufgabeFabrik;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Fabrik\Einrichtung\InstitutFabrik;
use Model\Fabrik\Einrichtung\NiederlassungFabrik;
use Model\Fabrik\Stadtplan\GebaeudeFabrik;
use Model\Fabrik\Stadtplan\UmweltFabrik;
use Model\Fabrik\Stadtplan\WohnhausFabrik;
use Model\Stadtplan\IKartenelement;
use Singleton\SingletonPattern;

class ModelHandler extends SingletonPattern {
    /**
     * @var ModelHandler|null
     */
    private static $_instance = null;

    /**
     * @return ModelHandler
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->datenbankHandler = DatenbankAbrufHandler::Instance();
            self::$_instance->datenbankEintragParser = DatenbankEintragParser::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var DatenbankAbrufHandler
     */
    private $datenbankHandler;

    /**
     * @var DatenbankEintragParser
     */
    private $datenbankEintragParser;


    /**
     * @return IDatenbankEintrag[]
     */
    public function getInstitutDaten() {
        return $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::INSTITUT),
            InstitutFabrik::Instance());
    }

    /**
     * @return IDatenbankEintrag[]
     */
    public function getItemDaten() {
        return $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::ITEM),
            ItemFabrik::Instance());
    }


    /**
     * @return IDatenbankEintrag[]
     */
    public function getAufgabeDaten() {
        return $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::AUFGABE),
            AufgabeFabrik::Instance());
    }

    /**
     * @return IKartenelement[]
     */
    public function getKartenelementDaten() {
        $kartenelementDaten = $this->datenbankHandler->findElementDaten(TabellenName::KARTENELEMENT);
        return array_merge(
            $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
                $kartenelementDaten,
                UmweltFabrik::Instance()
            ),
            $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
                $kartenelementDaten,
                GebaeudeFabrik::Instance()
            ),
            $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
                $kartenelementDaten,
                NiederlassungFabrik::Instance()
            ),
            $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
                $kartenelementDaten,
                WohnhausFabrik::Instance()
            ));
    }
}

