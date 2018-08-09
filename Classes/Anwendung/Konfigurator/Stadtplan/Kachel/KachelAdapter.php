<?php

namespace Anwendung\Konfigurator\Stadtplan\Kachel;

use Austauschformat\AustauschKonstanten;
use Anwendung\Konfigurator\Stadtplan\StadtplanModul;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\SimpleAbmessungFabrik;
use Model\Wertepaar;

abstract class KachelAdapter implements IKachel {

    /**
     * @var Abmessung
     */
    private $abmessung;

    /**
     * KartenelementKachelAdapter constructor.
     * @param Abmessung $abmessung
     */
    public function __construct($abmessung) {
        $this->abmessung = $abmessung;
    }

    /**
     * @return Wertepaar[]
     */
    public function getAttribute() {
        return [
            SimpleWertepaarFabrik::erzeugeWertepaar('class', $this->getClass()),
            SimpleWertepaarFabrik::erzeugeWertepaar('name', $this->getName())
        ];
    }

    /**
     * @return Abmessung
     */
    private function getUmgerechneteAbmessungen() {
        $stadtplanAbmessung = StadtplanModul::Instance()->getStadtplanAbmessung();
        return SimpleAbmessungFabrik::erzeugeAbmessung(
            ($this->abmessung->xMin() - $stadtplanAbmessung->xMin()) . AustauschKonstanten::ABMESSUNG_TRENNER .
            ($this->abmessung->yMin() - $stadtplanAbmessung->yMin()) . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->abmessung->getBreite() . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->abmessung->getHoehe() . AustauschKonstanten::ABMESSUNG_TRENNER, '');
    }

    /**
     * @return Wertepaar[]
     */
    public function getStyleAttribute() {
        $abmessungUmgerechnet = $this->getUmgerechneteAbmessungen();
        return [
            SimpleWertepaarFabrik::erzeugeWertepaar('grid-column', ($abmessungUmgerechnet->xMin() + 1) . " / span " . $abmessungUmgerechnet->getBreite()),
            SimpleWertepaarFabrik::erzeugeWertepaar('grid-row', ($abmessungUmgerechnet->yMin() + 1) . " / span " . $abmessungUmgerechnet->getHoehe())
        ];
    }

    /**
     * @return string
     */
    public function getEintragHtml() {
        return '<' . $this->getTag() . $this->getAttributeHtml() . ' ></' . $this->getTag() . '>';
    }

    private function getAttributeHtml() {
        $attibute = ' ';
        foreach ($this->getAttribute() as $attribut) {
            $attibute .= $attribut->getSchluessel() . '="' . $attribut->getWert() . '" ';
        }
        $attibute .= ' style="';
        foreach ($this->getStyleAttribute() as $styleAttribut) {
            $attibute .= $styleAttribut->getSchluessel() . ': ' . $styleAttribut->getWert() . '; ';
        }
        return $attibute . '" ';
    }

    /**
     * @return Abmessung
     */
    public function getAbmessung() {
        return $this->abmessung;
    }

    /**
     * @return string
     */
    public function getName() {
        return '';
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'kachel hoverbox kartenelement';
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'button';
    }
}

