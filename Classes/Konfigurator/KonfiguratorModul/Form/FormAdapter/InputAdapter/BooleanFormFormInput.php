<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

use Model\Wertepaar;

class BooleanFormFormInput extends SelectFormInput {

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

