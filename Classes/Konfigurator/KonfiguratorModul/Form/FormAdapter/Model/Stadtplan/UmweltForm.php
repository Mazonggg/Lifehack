<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselForm;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Umwelt;

class UmweltForm extends OhnePrimaerschluesselForm {
    /**
     * @var Umwelt $umwelt
     */
    private $umwelt;

    /**
     * UmweltFormAdapter constructor.
     * @param Umwelt $umwelt
     */
    public function __construct($umwelt) {
        parent::__construct($umwelt);
        $this->umwelt = $umwelt;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $begehbarInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::BOOLEAN,
            TabellenSpalten::UMWELT_BEGEHBAR,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::SELECTED => $this->umwelt->isBegehbar(),
                SimpleFormInputFabrik::LABEL => 'Ist das Element begehbar?']
        );
        $bezeichnungInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXT,
            TabellenSpalten::UMWELT_BEZEICHUNG,
            [SimpleFormInputFabrik::INHALT => $this->umwelt->getBezeichnung(),
                SimpleFormInputFabrik::LABEL => 'Bezeichnung des Elements']
        );
        return [$begehbarInput, $bezeichnungInput];
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
        return TabellenName::UMWELT;
    }
}

