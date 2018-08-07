<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

use Model\Wertepaar;

class HiddenInputAdapter extends TextInputAdapter {

    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getClass() {
        return parent::getClass() . ' hidden';
    }

    /**
     * @return Wertepaar[]
     */
    public function getAttribute() {
        return array_merge(parent::getAttribute(), [
            new Wertepaar('value', $this->getInhalt())
        ]);
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
}

