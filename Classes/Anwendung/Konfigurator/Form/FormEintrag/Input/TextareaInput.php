<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

class TextareaInput extends TextInput {

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

