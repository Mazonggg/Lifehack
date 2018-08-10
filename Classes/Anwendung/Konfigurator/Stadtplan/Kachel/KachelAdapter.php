<?php

namespace Anwendung\Konfigurator\Stadtplan\Kachel;

use Anwendung\Konfigurator\ModulEintragAdapter;
use Austauschformat\AustauschKonstanten;
use Anwendung\Konfigurator\Stadtplan\StadtplanModul;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\SimpleAbmessungFabrik;
use Model\Wertepaar;

abstract class KachelAdapter extends ModulEintragAdapter implements IKachel {

    /**
     * @var Abmessung
     */
    protected $eintrag;

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
            ($this->eintrag->xMin() - $stadtplanAbmessung->xMin()) . AustauschKonstanten::ABMESSUNG_TRENNER .
            ($this->eintrag->yMin() - $stadtplanAbmessung->yMin()) . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->eintrag->getBreite() . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->eintrag->getHoehe() . AustauschKonstanten::ABMESSUNG_TRENNER, '');
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
    public function getEintrag() {
        return $this->eintrag;
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

