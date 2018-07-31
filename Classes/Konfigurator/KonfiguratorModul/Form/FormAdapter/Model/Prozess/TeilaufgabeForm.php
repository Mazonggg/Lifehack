<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Teilaufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class TeilaufgabeForm extends Form {
    /**
     * @var Teilaufgabe
     */
    private $teilaufgabe;

    /**
     * TeilaufgabeFormAdapter constructor.
     * @param Teilaufgabe $teilaufgabe
     */
    public function __construct($teilaufgabe) {
        parent::__construct($teilaufgabe);
        $this->teilaufgabe = $teilaufgabe;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $menueTextInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_MENUE_TEXT,
            [SimpleFormInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getMenueText()]
        );
        $anspracheTextInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT,
            [SimpleFormInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getAnspracheText()]
        );
        $antwortTextInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT,
            [SimpleFormInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getAntwortText()]
        );
        $erfuellungTextInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT,
            [SimpleFormInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getErfuellungsText()]
        );
        $scheiternTextInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT,
            [SimpleFormInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getScheiternText()]
        );
        $items = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::ITEM,
            TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME
        );
        $bedingungInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $items,
                SimpleFormInputFabrik::SELECTED => $this->teilaufgabe->getBedingungId(),
                SimpleFormInputFabrik::LABEL => 'Ben&ouml;tigtes Item']
        );
        $belohnungInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $items,
                SimpleFormInputFabrik::SELECTED => $this->teilaufgabe->getBelohnungId(),
                SimpleFormInputFabrik::LABEL => 'Erhaltenes Item']
        );
        $teilaufgabeArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::TEILAUFGABE_ART,
            TabellenName::TEILAUFGABE_ART . "." . TabellenName::TEILAUFGABE_ART . Keyword::NAME
        );
        $teilaufgabeArtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenName::TEILAUFGABE_ART . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $teilaufgabeArten,
                SimpleFormInputFabrik::SELECTED => $this->teilaufgabe->getTeilaufgabeArt()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Art der Teilaufgabe']
        );
        $institutArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT_ART,
            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
        );
        $institutArtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenName::INSTITUT_ART . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $institutArten,
                SimpleFormInputFabrik::SELECTED => $this->teilaufgabe->getInstitutArt()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Art des Instituts']
        );
        return [
            $menueTextInput,
            $anspracheTextInput,
            $antwortTextInput,
            $erfuellungTextInput,
            $scheiternTextInput,
            $bedingungInput,
            $belohnungInput,
            $teilaufgabeArtInput,
            $institutArtInput
        ];
    }

    /**
     * @return bool
     */
    public function istTeilForm() {
        return true;
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
        return TabellenName::TEILAUFGABE;
    }
}

