<?php

namespace Anwendung\Konfigurator\Form\FormEintrag;

abstract class OhnePrimaerschluesselFormAdapter extends FormEintragAdapter {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return '0';
    }
}

