<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter;

class NeuButtonInput extends ButtonInput {

    /**
     * @return string
     */
    public function getInputHtml() {
        return '<div id="form_neu_body" class="form_body_content">' . parent::getInputHtml() . '</div>';
    }
}

