<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class NeuButtonFormInput extends ButtonFormInput {

    /**
     * @return string
     */
    public function getInputHtml() {
        return '<div id="form_neu_body" class="form_body_content">' . parent::getInputHtml() . '</div>';
    }
}

