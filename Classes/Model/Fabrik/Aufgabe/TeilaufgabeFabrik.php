<?php

namespace Model\Fabrik\Aufgabe;

use Anwendung\Konfigurator\ModulAdapter;
use Model\ModelHandler;
use Model\Prozess\SimpleDialogFabrik;
use Model\Prozess\Teilaufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenSpalten;
use Model\Konstanten\TabellenName;
use Model\Fabrik\DatenbankEintragFabrik;
use Model\IDatenbankEintrag;
use Model\Wertepaar;

class TeilaufgabeFabrik extends DatenbankEintragFabrik {
    /**
     * @var TeilaufgabeFabrik|null
     */
    protected static $_instance = null;

    /**
     * @return TeilaufgabeFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return Teilaufgabe
     */
    public function erzeugeLeeresEintragObjekt() {
        return new Teilaufgabe();
    }

    /**
     * @param Teilaufgabe $teilaufgabe
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    protected function setAttribute($teilaufgabe, $eintragdaten) {
        $teilaufgabe->setId($eintragdaten[TabellenName::TEILAUFGABE . Keyword::ID]);
        $teilaufgabe->setTeilaufgabeArt(new Wertepaar(
            $eintragdaten[TabellenName::TEILAUFGABE_ART . Keyword::REF],
            $eintragdaten[TabellenName::TEILAUFGABE_ART . Keyword::NAME]));
        $teilaufgabe->setDialog(SimpleDialogFabrik::erzeugeDialog(
            $eintragdaten[TabellenSpalten::TEILAUFGABE_MENUE_TEXT],
            $eintragdaten[TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT],
            $eintragdaten[TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT],
            $eintragdaten[TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT],
            $eintragdaten[TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT]
        ));
        $teilaufgabe->setInstitutArt(new Wertepaar(
            $eintragdaten[TabellenName::INSTITUT_ART . Keyword::REF],
            $eintragdaten[TabellenName::INSTITUT_ART . Keyword::NAME]));
        $items = ModelHandler::Instance()->getItems();
        foreach ($items as $item){
            if($item->getId() == $eintragdaten[TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF]){
                $teilaufgabe->setBedingung($item);
            } else if($item->getId() == $eintragdaten[TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF]){
                $teilaufgabe->setBelohnung($item);
            }
        }
        return $teilaufgabe;
    }
}

