<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormAdapter\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Institut;
use Model\Konstanten\TabellenSpalten;

class InstitutFormAdapter extends MitPrimaerschluesselFormAdapter {
    /**
     * @var Institut
     */
    private $institut;

    /**
     * InstitutFormAdapter constructor.
     * @param Institut $institut
     */
    public function __construct($institut) {
        parent::__construct($institut);
        $this->institut = $institut;
    }

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $nameInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenName::INSTITUT . Keyword::NAME,
            [SimpleInputFabrik::INHALT => $this->institut->getName()]
        );
        $beschreibungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::INSTITUT_BESCHREIBUNG,
            [SimpleInputFabrik::INHALT => $this->institut->getBeschreibung()]
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
                SimpleInputFabrik::SELECTED => $this->institut->getInstitutArt()->getSchluessel(),
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

