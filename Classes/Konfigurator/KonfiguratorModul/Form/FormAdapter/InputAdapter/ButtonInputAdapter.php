<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

abstract class ButtonInputAdapter extends InputAdapter {

    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getClass() {
        return 'form_item hoverbox form_button';
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'button';
    }

    /**
     * @return string
     */
    public function getType() {
        return '';
    }
}

