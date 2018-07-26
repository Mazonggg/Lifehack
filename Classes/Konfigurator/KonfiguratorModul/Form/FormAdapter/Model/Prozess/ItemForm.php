<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Item;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class ItemForm extends Form {

    /**
     * @var Item
     */
    private $item;

    /**
     * ItemFormAdapter constructor.
     * @param Item $item
     */
    public function __construct($item) {
        parent::__construct($item);
        $this->item = $item;
    }


    /**
     * @return IInputAdapter[]
     */
    public function getFormInputs() {
        $nameInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenName::ITEM . Keyword::NAME,
            [SimpleInputFabrik::INHALT => $this->item->getName()]
        );
        $gewichtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::NUMBER,
            TabellenSpalten::ITEM_GEWICHT,
            [SimpleInputFabrik::INHALT => $this->item->getGewicht(),
                SimpleInputFabrik::MIN => '1',
                SimpleInputFabrik::MAX => '20',
                SimpleInputFabrik::LABEL => 'Gewicht des Items']
        );
        $konfigInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::ITEM_KONFIGURATION,
            [SimpleInputFabrik::INHALT => $this->item->getKonfiguration()]
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
                SimpleInputFabrik::SELECTED => $this->item->getItemArt()->getSchluessel(),
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

