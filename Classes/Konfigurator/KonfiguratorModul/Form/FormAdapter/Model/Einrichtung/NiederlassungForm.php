<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\MitPrimaerschluesselForm;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselForm;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Niederlassung;

class NiederlassungForm extends OhnePrimaerschluesselForm {
    /**
     * @var Niederlassung
     */
    private $niederlassung;

    /**
     * NiederlassungFormAdapter constructor.
     * @param Niederlassung $niederlassung
     */
    public function __construct($niederlassung) {
        parent::__construct($niederlassung);
        $this->niederlassung = $niederlassung;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $interieurAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT,
            TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME
        );
        $interieurAussehensInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::SELECT,
            TabellenName::NIEDERLASSUNG . '_' . TabellenName::INSTITUT . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $interieurAussehens,
                SimpleFormInputFabrik::SELECTED => $this->niederlassung->getInstitut()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Geh&ouml;rt zu Einrichtung']
        );
        return [$interieurAussehensInput];
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
        return false;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::NIEDERLASSUNG;
    }
}

