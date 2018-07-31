<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class TextInput extends FormInput {

    /**
     * @return string
     */
    public function getTag() {
        return 'input';
    }

    /**
     * @return string
     */
    public function getType() {
        return SimpleFormInputFabrik::TEXT;
    }
}

