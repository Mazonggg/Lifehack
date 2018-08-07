<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan;

use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormAdapter\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Wohnhaus;

class WohnhausFormAdapter extends OhnePrimaerschluesselFormAdapter {
    /**
     * @var Wohnhaus $wohnhaus
     */
    private $wohnhaus;

    /**
     * WohnhausFormAdapter constructor.
     * @param Wohnhaus $wohnhaus
     * @param string $modus
     */
    public function __construct($wohnhaus, $modus) {
        parent::__construct($wohnhaus, $modus);
        $this->wohnhaus = $wohnhaus;
    }

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $wohneinheitenInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::NUMBER,
            TabellenSpalten::WOHNHAUS_WOHNEINHEITEN,
            [SimpleInputFabrik::INHALT => $this->wohnhaus->getWohneinheiten(),
                SimpleInputFabrik::MIN => '1',
                SimpleInputFabrik::MAX => '20',
                SimpleInputFabrik::LABEL => 'Anzahl der Wohneinheiten']
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

