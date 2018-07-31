<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class AuswahlButtonFormFormInput extends ButtonFormInput {

    /**
     * @var string
     */
    private $wert;

    /**
     * @return string
     */
    public function getInputHtml() {
        $hiddenInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::HIDDEN,
            parent::getName(),
            [SimpleFormInputFabrik::INHALT => $this->wert,
                SimpleFormInputFabrik::ID => parent::getId() . '_auswahl_input']
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

