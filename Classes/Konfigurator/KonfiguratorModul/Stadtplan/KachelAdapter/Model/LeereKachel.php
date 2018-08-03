<?php

namespace Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Model;

use Konfigurator\KonfiguratorModul\Stadtplan\KachelAdapter\Kachel;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

class LeereKachel extends Kachel {

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
