<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Wohnhaus;

class WohnhausForm extends Form {
    /**
     * @var Wohnhaus $wohnhaus
     */
    private $wohnhaus;

    /**
     * WohnhausFormAdapter constructor.
     * @param Wohnhaus $wohnhaus
     */
    public function __construct($wohnhaus) {
        parent::__construct($wohnhaus);
        $this->wohnhaus = $wohnhaus;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $wohneinheitenInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::NUMBER,
            TabellenSpalten::WOHNHAUS_WOHNEINHEITEN,
            [SimpleFormInputFabrik::INHALT => $this->wohnhaus->getWohneinheiten(),
                SimpleFormInputFabrik::MIN => '1',
                SimpleFormInputFabrik::MAX => '20',
                SimpleFormInputFabrik::LABEL => 'Anzahl der Wohneinheiten']
        );
        return [$wohneinheitenInput];
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
        return TabellenName::WOHNHAUS;
    }
}

