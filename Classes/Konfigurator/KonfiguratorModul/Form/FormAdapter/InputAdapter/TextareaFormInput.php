<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class TextareaFormInput extends TextInput {

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

