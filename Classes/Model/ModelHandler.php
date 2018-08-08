<?php

namespace Model;

use Datenbank\DatenbankAbrufHandler;
use Model\Einrichtung\Institut;
use Model\Konstanten\TabellenName;
use Model\Fabrik\Aufgabe\AufgabeFabrik;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Fabrik\Einrichtung\InstitutFabrik;
use Model\Fabrik\Einrichtung\NiederlassungFabrik;
use Model\Fabrik\Stadtplan\GebaeudeFabrik;
use Model\Fabrik\Stadtplan\UmweltFabrik;
use Model\Fabrik\Stadtplan\WohnhausFabrik;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\Singleton\ISingleton;
use Model\Stadtplan\IKartenelement;

class ModelHandler implements ISingleton {
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
            self::$_instance->datenbankEintragParser = new DatenbankEintragParser();
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
     * @return Institut[]
     */
    public function getInstitute() {
        /**
         * @var Institut[] $institute
         */
        $institute = $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::INSTITUT),
            InstitutFabrik::Instance());
        return $institute;
    }

    /**
     * @return Item[]
     */
    public function getItems() {
        /**
         * @var Item[] $items
         */
        $items = $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::ITEM),
            ItemFabrik::Instance());
        return $items;
    }


    /**
     * @return Aufgabe[]
     */
    public function getAufgaben() {
        /**
         * @var Aufgabe[] $aufgaben
         */
        $aufgaben = $this->datenbankEintragParser->arrayZuDatenbankEintraegen(
            $this->datenbankHandler->findElementDaten(TabellenName::AUFGABE),
            AufgabeFabrik::Instance());
        return $aufgaben;
    }

    /**
     * @return IKartenelement[]
     */
    public function getKartenelemente() {
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

