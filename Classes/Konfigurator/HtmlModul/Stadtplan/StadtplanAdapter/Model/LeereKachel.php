<?php

namespace Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\Model;

use Konfigurator\HtmlModul\Stadtplan\StadtplanAdapter\KachelAdapter;
use Model\Konstanten\AjaxKeywords;
use Model\Konstanten\TabellenName;
use Model\Wertepaar;

class LeereKachel extends KachelAdapter {

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

