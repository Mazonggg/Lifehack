<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class AuswahlButtonInput extends ButtonInput {

    /**
     * @var string
     */
    private $wert;

    /**
     * @return string
     */
    public function getInputHtml() {
        $hiddenInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::HIDDEN,
            parent::getName(),
            [SimpleInputFabrik::INHALT => $this->wert,
                SimpleInputFabrik::ID => parent::getId() . '_auswahl_input']
        );
        return parent::getInputHtml() . $hiddenInput->getInputHtml();
    }

    /**
     * @param string $wert
     */
    public function setWert($wert) {
        $this->wert = $wert;
    }

    /**
     * @return string
     */
    public function getName() {
        return parent::getName() . '_auswahl_button';
    }

    /**
     * @return string
     */
    public function getId() {
        return parent::getId() . '_auswahl_button';
    }
}

