<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

abstract class MitPrimaerschluesselForm extends Form {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return $this->datenbankEintrag->getId();
    }
}

