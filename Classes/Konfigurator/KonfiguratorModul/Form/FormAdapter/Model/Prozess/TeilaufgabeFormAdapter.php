<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Teilaufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class TeilaufgabeFormAdapter extends MitPrimaerschluesselFormAdapter {
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
     * @return IInput[]
     */
    public function getFormInputs() {
        $menueTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_MENUE_TEXT,
            [SimpleInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getMenueText()]
        );
        $anspracheTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT,
            [SimpleInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getAnspracheText()]
        );
        $antwortTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT,
            [SimpleInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getAntwortText()]
        );
        $erfuellungTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT,
            [SimpleInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getErfuellungsText()]
        );
        $scheiternTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT,
            [SimpleInputFabrik::INHALT => $this->teilaufgabe->getDialog()->getScheiternText()]
        );
        $items = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::ITEM,
            TabellenName::ITEM . "." . TabellenName::ITEM . Keyword::NAME
        );
        $bedingungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenSpalten::TEILAUFGABE_BEDINGUNG_ITEM_REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $items,
                SimpleInputFabrik::SELECTED => $this->teilaufgabe->getBedingungId(),
                SimpleInputFabrik::LABEL => 'Ben&ouml;tigtes Item']
        );
        $belohnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $items,
                SimpleInputFabrik::SELECTED => $this->teilaufgabe->getBelohnungId(),
                SimpleInputFabrik::LABEL => 'Erhaltenes Item']
        );
        $teilaufgabeArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::TEILAUFGABE_ART,
            TabellenName::TEILAUFGABE_ART . "." . TabellenName::TEILAUFGABE_ART . Keyword::NAME
        );
        $teilaufgabeArtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenName::TEILAUFGABE_ART . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $teilaufgabeArten,
                SimpleInputFabrik::SELECTED => $this->teilaufgabe->getTeilaufgabeArt()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Art der Teilaufgabe']
        );
        $institutArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT_ART,
            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
        );
        $institutArtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenName::INSTITUT_ART . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $institutArten,
                SimpleInputFabrik::SELECTED => $this->teilaufgabe->getInstitutArt()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Art des Instituts']
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

