<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Prozess;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Aufgabe;
use Model\Konstanten\TabellenName;

class AufgabeForm extends Form {

    /**
     * @var Aufgabe
     */
    private $aufgabe;

    /**
     * AufgabeFormAdapter constructor.
     * @param Aufgabe $aufgabe
     */
    public function __construct($aufgabe) {
        parent::__construct($aufgabe);
        $this->aufgabe = $aufgabe;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {

        $bezeichnungInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXT,
            TabellenSpalten::AUFGABE_BEZEICHNUNG,
            [SimpleFormInputFabrik::INHALT => $this->aufgabe->getBezeichnung()]
        );
        $gesetzInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::TEXTAREA,
            TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE,
            [SimpleFormInputFabrik::INHALT => $this->aufgabe->getGesetzesgrundlage()]
        );
        $teilaufgabeNeuButton = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::NEUBUTTON,
            TabellenName::TEILAUFGABE,
            [SimpleFormInputFabrik::INHALT => $this->aufgabe->getGesetzesgrundlage(),
                SimpleFormInputFabrik::ID => 'form_neu_button',
                SimpleFormInputFabrik::INHALT => 'Teilaufgabe hinzuf&uuml;gen']
        );
        return [
            $bezeichnungInput,
            $gesetzInput,
            $teilaufgabeNeuButton
        ];
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
        return TabellenName::AUFGABE;
    }
}

