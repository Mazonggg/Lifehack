<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Institut;
use Model\Konstanten\TabellenSpalten;

class InstitutFormEintragAdapter extends MitPrimaerschluesselFormAdapter {

    /**
     * @var Institut
     */
    protected $datenbankEintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $nameInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenName::INSTITUT . Keyword::NAME,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getName()]
        );
        $beschreibungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::INSTITUT_BESCHREIBUNG,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getBeschreibung()]
        );
        $institutArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT_ART,
            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
        );
        $instituArtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenName::INSTITUT_ART . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $institutArten,
                SimpleInputFabrik::SELECTED => $this->datenbankEintrag->getInstitutArt()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Art des Instituts']
        );
        return [$nameInput, $beschreibungInput, $instituArtInput];
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
        return TabellenName::INSTITUT;
    }
}

