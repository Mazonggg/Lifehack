<?php

namespace Konfigurator\HtmlModul;

use Datenbank\DatenbankAbrufHandler;
use Model\DatenbankEintragDirector;
use Model\Konstanten\TabellenName;
use Model\Fabrik\Aufgabe\AufgabeFabrik;
use Model\Fabrik\Aufgabe\ItemFabrik;
use Model\Fabrik\Einrichtung\InstitutFabrik;
use Model\Fabrik\Einrichtung\NiederlassungFabrik;
use Model\Fabrik\Stadtplan\GebaeudeFabrik;
use Model\Fabrik\Stadtplan\UmweltFabrik;
use Model\Fabrik\Stadtplan\WohnhausFabrik;
use Model\IDatenbankEintrag;
use Model\Stadtplan\IKartenelement;
use Pattern\SingletonPattern;

class ModulAbrufer extends SingletonPattern {
    /**
     * @var ModulAbrufer|null
     */
    private static $_instance = null;

    /**
     * @return ModulAbrufer
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->datenbankHandler = DatenbankAbrufHandler::Instance();
            self::$_instance->datenbankEintragDirector = DatenbankEintragDirector::Instance();
        }
        return self::$_instance;
    }

    /**
     * @var DatenbankAbrufHandler
     */
    private $datenbankHandler;

    /**
     * @var DatenbankEintragDirector
     */
    private $datenbankEintragDirector;


    /**
     * @return IDatenbankEintrag[]
     */
    public function getInstitutDaten() {
        return $this->datenbankEintragDirector->arrayZuObjekten(
            $this->datenbankHandler->findElementDaten(TabellenName::INSTITUT),
            InstitutFabrik::Instance());
    }

    /**
     * @return IDatenbankEintrag[]
     */
    public function getItemDaten() {
        return $this->datenbankEintragDirector->arrayZuObjekten(
            $this->datenbankHandler->findElementDaten(TabellenName::ITEM),
            ItemFabrik::Instance());
    }


    /**
     * @return IDatenbankEintrag[]
     */
    public function getAufgabeDaten() {
        return $this->datenbankEintragDirector->arrayZuObjekten(
            $this->datenbankHandler->findElementDaten(TabellenName::AUFGABE),
            AufgabeFabrik::Instance());
    }

    /**
     * @return IKartenelement[]
     */
    public function getKartenelementDaten() {
        $kartenelementDaten = $this->datenbankHandler->findElementDaten(TabellenName::KARTENELEMENT);
        return array_merge(
            $this->datenbankEintragDirector->arrayZuObjekten(
                $kartenelementDaten,
                UmweltFabrik::Instance()
            ),
            $this->datenbankEintragDirector->arrayZuObjekten(
                $kartenelementDaten,
                GebaeudeFabrik::Instance()
            ),
            $this->datenbankEintragDirector->arrayZuObjekten(
                $kartenelementDaten,
                NiederlassungFabrik::Instance()
            ),
            $this->datenbankEintragDirector->arrayZuObjekten(
                $kartenelementDaten,
                WohnhausFabrik::Instance()
            ));
    }

}

