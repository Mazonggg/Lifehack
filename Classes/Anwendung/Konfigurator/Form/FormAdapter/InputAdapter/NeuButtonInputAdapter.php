<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\InputAdapter;

class NeuButtonInputAdapter extends ButtonInputAdapter {

    /**
     * @return string
     */
    public function getInputHtml() {
        return '<div id="form_neu_body" class="form_body_content">' . parent::getInputHtml() . '</div>';
    }
}

