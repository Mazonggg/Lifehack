<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

use Model\Wertepaar;

class NumberInputAdapter extends TextInputAdapter {

    /**
     * @var int
     */
    private $min = 0;
    /**
     * @var int
     */
    private $max = 100000;

    /**
     * @param int $min
     */
    public function setMin($min) {
        $this->min = $min;
    }

    /**
     * @param int $max
     */
    public function setMax($max) {
        $this->max = $max;
    }

    /**
     * @return string
     */
    public function getType() {
        return SimpleInputFabrik::NUMBER;
    }

    /**
     * @return Wertepaar[]
     */
    public function getAttribute() {
        return array_merge(
            parent::getAttribute(),
            [
                new Wertepaar("min", $this->min),
                new Wertepaar("max", $this->max)
            ]
        );
    }
}

