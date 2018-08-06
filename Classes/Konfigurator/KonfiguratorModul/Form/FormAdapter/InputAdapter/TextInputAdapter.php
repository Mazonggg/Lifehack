<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

class TextInputAdapter extends InputAdapter {

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
