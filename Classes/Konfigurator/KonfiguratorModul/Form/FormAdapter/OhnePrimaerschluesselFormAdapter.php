<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

abstract class OhnePrimaerschluesselFormAdapter extends FormAdapter {
    /**
     * @return string
     */
    public function getDatenbankEintragId() {
        return '0';
    }
}

