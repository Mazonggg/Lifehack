<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

abstract class MitPrimaerschluesselFormAdapter extends FormAdapter {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return $this->datenbankEintrag->getId();
    }
}

