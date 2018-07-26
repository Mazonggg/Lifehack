<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter;

class AuswahlbildInput extends SelectInput {

    /**
     * @return string
     */
    public function getPlaceholder() {
        return '';
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'form_input hidden';
    }

    /**
     * @return string
     */
    public function getInputHtml() {
        $bildUrl = 'na.png';
        foreach ($this->optionen as $option) {
            if ($option->getSchluessel() == $this->selected) {
                $bildUrl = $option->getWert();
            }
        }
        return parent::getInputHtml() .
            '<button class="form_item hoverbox form_bild"' .
            ' id="' . $this->getName() . '_auswahlbild_button"' . '>' .
            '<img src="img/' . $bildUrl . '"' .
            ' id="' . $this->getName() . '_auswahlbild_img">' .
            '</button>';
    }
}

