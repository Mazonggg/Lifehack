<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
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
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $nameInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXT,
            TabellenName::ITEM . Keyword::NAME,
            [SimpleFormInputFabrik::INHALT => $this->item->getName()]
        );
        $gewichtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::NUMBER,
            TabellenSpalten::ITEM_GEWICHT,
            [SimpleFormInputFabrik::INHALT => $this->item->getGewicht(),
                SimpleFormInputFabrik::MIN => '1',
                SimpleFormInputFabrik::MAX => '20',
                SimpleFormInputFabrik::LABEL => 'Gewicht des Items']
        );
        $konfigInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::ITEM_KONFIGURATION,
            [SimpleFormInputFabrik::INHALT => $this->item->getKonfiguration()]
        );
        $itemArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::ITEM_ART,
            TabellenName::ITEM_ART . "." . TabellenName::ITEM_ART . Keyword::NAME
        );
        $itemArtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenName::ITEM_ART . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $itemArten,
                SimpleFormInputFabrik::SELECTED => $this->item->getItemArt()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Art des Items']
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

