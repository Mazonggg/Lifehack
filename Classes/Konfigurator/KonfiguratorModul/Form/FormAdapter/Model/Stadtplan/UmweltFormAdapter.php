<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Umwelt;

class UmweltFormAdapter extends OhnePrimaerschluesselFormAdapter {
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
     * @return IInput[]
     */
    public function getFormInputs() {
        $begehbarInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::BOOLEAN,
            TabellenSpalten::UMWELT_BEGEHBAR,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::SELECTED => $this->umwelt->isBegehbar(),
                SimpleInputFabrik::LABEL => 'Ist das Element begehbar?']
        );
        $bezeichnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenSpalten::UMWELT_BEZEICHUNG,
            [SimpleInputFabrik::INHALT => $this->umwelt->getBezeichnung(),
                SimpleInputFabrik::LABEL => 'Bezeichnung des Elements']
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

