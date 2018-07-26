<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter;

class TextInput extends Input {

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
        return SimpleInputFabrik::TEXT;
    }
}

