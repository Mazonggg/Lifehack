<?php

namespace Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Model\DatenbankEintrag;
use Model\Konstanten\TabellenName;

class Abmessung extends DatenbankEintrag {

    /**
     * @var int
     */
    private $x = 0, $breite = 0, $y = 0, $hoehe = 0;

    /**
     * @var string
     */
    private $kartenelementId;

    /**
     * Abmessung constructor.
     */
    public function __construct() {
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $breite
     * @param int $hoehe
     */
    public function setAbmessungen($x, $y, $breite, $hoehe) {
        $this->x = $x;
        $this->y = $y;
        $this->breite = $breite;
        $this->hoehe = $hoehe;
    }

    /**
     * @return string
     */
    public function getKartenelementId() {
        return $this->kartenelementId;
    }

    /**
     * @param string $kartenelementId
     */
    public function setKartenelementId($kartenelementId) {
        $this->kartenelementId = $kartenelementId;
    }

    /**
     * @return int
     */
    public function xMin() {
        return $this->x;
    }

    /**
     * @return int
     */
    public function xMax() {
        return $this->x + $this->breite;
    }

    /**
     * @return int
     */
    public function yMin() {
        return $this->y;
    }

    /**
     * @return int
     */
    public function yMax() {
        return $this->y + $this->hoehe;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isInnerhalb($x, $y) {
        return
            $x >= $this->x && $x < ($this->x + $this->breite) &&
            $y >= $this->y && $y < ($this->y + $this->hoehe);
    }

    /**
     * @return int
     */
    public function getBreite() {
        return $this->breite;
    }

    /**
     * @return int
     */
    public function getHoehe() {
        return $this->hoehe;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::ABMESSUNG;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->getKartenelementId();
    }

    /**
     * @return string
     */
    public function __toString() {
        return
            $this->x . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->y . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->breite . AustauschKonstanten::ABMESSUNG_TRENNER .
            $this->hoehe;
    }
}

