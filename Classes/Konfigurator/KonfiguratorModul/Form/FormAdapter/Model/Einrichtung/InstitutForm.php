<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\MitPrimaerschluesselForm;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Institut;
use Model\Konstanten\TabellenSpalten;

class InstitutForm extends MitPrimaerschluesselForm {
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
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $nameInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXT,
            TabellenName::INSTITUT . Keyword::NAME,
            [SimpleFormInputFabrik::INHALT => $this->institut->getName()]
        );
        $beschreibungInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::INSTITUT_BESCHREIBUNG,
            [SimpleFormInputFabrik::INHALT => $this->institut->getBeschreibung()]
        );
        $institutArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT_ART,
            TabellenName::INSTITUT_ART . "." . TabellenName::INSTITUT_ART . Keyword::NAME
        );
        $instituArtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenName::INSTITUT_ART . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $institutArten,
                SimpleFormInputFabrik::SELECTED => $this->institut->getInstitutArt()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Art des Instituts']
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

