<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

use Model\Wertepaar;

class SelectInput extends TextInput {

    /**
     * @var Wertepaar[]
     */
    protected $optionen;
    /**
     * @var string
     */
    protected $selected;

    /**
     * @param Wertepaar[] $optionen
     */
    public function setOptionen($optionen) {
        $this->optionen = $optionen;
    }

    /**
     * @param string $selected
     */
    public function setSelected($selected) {
        $this->selected = $selected;
    }

    /**
     * @return string
     */
    public function getTag() {
        return "select";
    }

    /**
     * @return string
     */
    public function getType() {
        return '';
    }

    /**
     * @return string
     */
    public function getClass() {
        return parent::getClass() . " form_select";
    }

    /**
     * @return string
     */
    public function getInhalt() {
        $inhalt = '';
        $hatSelected = false;
        foreach ($this->optionen as $option) {
            $inhalt .= '<option value="' . $option->getSchluessel() . '" ';
            if ($this->selected == $option->getSchluessel()) {
                $hatSelected = true;
                $inhalt .= ' selected="selected" ';
            }
            $inhalt .= '>' . implode(' ', explode('_', ucfirst($option->getWert()) . '</option>'));
        }
        return ($hatSelected ? '' : '<option selected disabled hidden style="display: none" value=""></option>') . $inhalt;
    }
}

