<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

class NeuButtonInput extends ButtonInput {

    /**
     * @return string
     */
    public function getInputHtml() {
        return '<div id="form_neu_body" class="form_body_content">' . parent::getInputHtml() . '</div>';
    }
}

