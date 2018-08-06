<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\InputAdapter;

class TextareaInputAdapter extends TextInputAdapter {

    /**
     * @return string
     */
    public function getTag() {
        return "textarea";
    }

    /**
     * @return string
     */
    public function getType() {
        return '';
    }
}

