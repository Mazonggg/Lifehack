<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model;

use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\KachelAdapter;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

class LeereKachelAdapter extends KachelAdapter {

    /**
     * @return string
     */
    public function getClass() {
        return parent::getClass() . ' leere_kachel ausgeblendet';
    }

    public function getAttribute() {
        return array_merge(parent::getAttribute(), [
            new Wertepaar('id', TabellenName::KARTENELEMENT . '_' . AjaxKeywords::HINZUFUEGEN)
        ]);
    }
}

