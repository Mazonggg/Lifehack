<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

abstract class OhnePrimaerschluesselForm extends Form {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return '0';
    }
}

