<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Teilaufgabe;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;

class TeilaufgabeFormEintragAdapter extends MitPrimaerschluesselFormAdapter {

    /**
     * @var Teilaufgabe
     */
    protected $eintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $menueTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_MENUE_TEXT,
            [SimpleInputFabrik::INHALT => $this->eintrag->getDialog()->getMenueText()]
        );
        $anspracheTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANSPRACHE_TEXT,
            [SimpleInputFabrik::INHALT => $this->eintrag->getDialog()->getAnspracheText()]
        );
        $antwortTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ANTWORT_TEXT,
            [SimpleInputFabrik::INHALT => $this->eintrag->getDialog()->getAntwortText()]
        );
        $erfuellungTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_ERFUELLUNGS_TEXT,
            [SimpleInputFabrik::INHALT => $this->eintrag->getDialog()->getErfuellungsText()]
        );
        $scheiternTextInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::TEILAUFGABE_SCHEITERN_TEXT,
            [SimpleInputFabrik::INHALT => $this->eintrag->getDialog()->getScheiternText()]
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
                SimpleInputFabrik::SELECTED => $this->eintrag->getBedingung()->getId(),
                SimpleInputFabrik::LABEL => 'Ben&ouml;tigtes Item']
        );
        $belohnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenSpalten::TEILAUFGABE_BELOHNUNG_ITEM_REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $items,
                SimpleInputFabrik::SELECTED => $this->eintrag->getBelohnung()->getId(),
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
                SimpleInputFabrik::SELECTED => $this->eintrag->getTeilaufgabeArt()->getSchluessel(),
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
                SimpleInputFabrik::SELECTED => $this->eintrag->getInstitutArt()->getSchluessel(),
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

