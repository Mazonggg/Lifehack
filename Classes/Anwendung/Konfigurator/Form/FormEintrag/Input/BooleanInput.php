<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

use Model\Wertepaar;

class BooleanInput extends SelectInput {

    /**
     * @param Wertepaar[] $optionen
     * @deprecated
     */
    public function setOptionen($optionen) {
    }

    /**
     * @return string
     */
    public function getInhalt() {
        return
            '<option value="1" ' .
            ($this->selected == '1' ? ' selected="selected" ' : '') .
            ' ">' .
            'Ja' .
            '</option><option value="0" ' .
            ($this->selected == '0' ? ' selected="selected" ' : '') .
            ' ">' .
            'Nein' .
            '</option>';
    }
}

