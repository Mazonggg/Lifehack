<?php

namespace Anwendung\Konfigurator\Form\FormEintrag;

abstract class MitPrimaerschluesselFormAdapter extends FormEintragAdapter {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return $this->datenbankEintrag->getId();
    }
}

