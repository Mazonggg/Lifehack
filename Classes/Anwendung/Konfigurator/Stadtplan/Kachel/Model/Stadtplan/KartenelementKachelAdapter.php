<?php

namespace Anwendung\Konfigurator\Stadtplan\Kachel\Model\Stadtplan;

use Anwendung\Konfigurator\Stadtplan\Kachel\KachelAdapter;
use Model\Konstanten\AjaxKeywords;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\IKartenelement;
use Model\Wertepaar;

class KartenelementKachelAdapter extends KachelAdapter {

    /**
     * @var IKartenelement
     */
    private $kartenelement;

    /**
     * KartenelementKachel constructor.
     * @param Abmessung $abmessung
     * @param IKartenelement $kartenelement
     */
    public function __construct($abmessung, $kartenelement) {
        parent::__construct($abmessung);
        $this->kartenelement = $kartenelement;
    }

    /**
     * @return Wertepaar[]
     */
    public function getStyleAttribute() {
        return array_merge(
            parent::getStyleAttribute(),
            [SimpleWertepaarFabrik::erzeugeWertepaar('background-image',
                'url(img/' .
                $this->kartenelement->getKartenelementAussehen()->getWert() .
                ')')]);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->kartenelement->getTabelle() . '_' . AjaxKeywords::AKTUALISIEREN . '-' . $this->kartenelement->getId();
    }
}

