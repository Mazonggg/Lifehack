<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter;

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

