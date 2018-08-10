<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Item;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class ItemFormEintragAdapter extends MitPrimaerschluesselFormAdapter {

    /**
     * @var Item
     */
    protected $datenbankEintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $nameInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenName::ITEM . Keyword::NAME,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getName()]
        );
        $gewichtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::NUMBER,
            TabellenSpalten::ITEM_GEWICHT,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getGewicht(),
                SimpleInputFabrik::MIN => '1',
                SimpleInputFabrik::MAX => '20',
                SimpleInputFabrik::LABEL => 'Gewicht des Items']
        );
        $konfigInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::ITEM_KONFIGURATION,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getKonfiguration()]
        );
        $itemArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::ITEM_ART,
            TabellenName::ITEM_ART . "." . TabellenName::ITEM_ART . Keyword::NAME
        );
        $itemArtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenName::ITEM_ART . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $itemArten,
                SimpleInputFabrik::SELECTED => $this->datenbankEintrag->getItemArt()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Art des Items']
        );
        return [$nameInput, $gewichtInput, $konfigInput, $itemArtInput];
    }

    /**
     * @return bool
     */
    public function istTeilForm() {
        return false;
    }

    /**
     * @return bool
     */
    public function hatTitelElement() {
        return true;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::ITEM;
    }
}

