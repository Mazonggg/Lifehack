<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\Model\Prozess;

use Konfigurator\HtmlModul\Form\FormAdapter\Form;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
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
     * @return IInputAdapter[]
     */
    public function getFormInputs() {

        $bezeichnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenSpalten::AUFGABE_BEZEICHNUNG,
            [SimpleInputFabrik::INHALT => $this->aufgabe->getBezeichnung()]
        );
        $gesetzInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE,
            [SimpleInputFabrik::INHALT => $this->aufgabe->getGesetzesgrundlage()]
        );
        $teilaufgabeNeuButton = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::NEUBUTTON,
            TabellenName::TEILAUFGABE,
            [SimpleInputFabrik::INHALT => $this->aufgabe->getGesetzesgrundlage(),
                SimpleInputFabrik::ID => 'form_neu_button',
                SimpleInputFabrik::INHALT => 'Teilaufgabe hinzuf&uuml;gen']
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

