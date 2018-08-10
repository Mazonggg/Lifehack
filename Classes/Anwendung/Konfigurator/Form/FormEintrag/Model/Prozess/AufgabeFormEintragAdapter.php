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
    protected $datenbankEintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {

        $bezeichnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenSpalten::AUFGABE_BEZEICHNUNG,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getBezeichnung()]
        );
        $gesetzInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXTAREA,
            TabellenSpalten::AUFGABE_GESETZESGRUNDLAGE,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getGesetzesgrundlage()]
        );
        $teilaufgabeNeuButton = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::NEUBUTTON,
            TabellenName::TEILAUFGABE,
            [SimpleInputFabrik::INHALT => $this->datenbankEintrag->getGesetzesgrundlage(),
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

