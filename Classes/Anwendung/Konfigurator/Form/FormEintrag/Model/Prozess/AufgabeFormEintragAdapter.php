<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess;

use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenSpalten;
use Model\Prozess\Aufgabe;
use Model\Konstanten\TabellenName;

class AufgabeFormEintragAdapter extends MitPrimaerschluesselFormAdapter {

    /**
     * @var Aufgabe
     */
    private $aufgabe;

    /**
     * AufgabeFormAdapter constructor.
     * @param Aufgabe $aufgabe
     * @param string $modus
     */
    public function __construct($aufgabe, $modus) {
        parent::__construct($aufgabe, $modus);
        $this->aufgabe = $aufgabe;
    }

    /**
     * @return IInput[]
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

