<?php

namespace Model\Stadtplan;

use Austauschformat\AustauschKonstanten;

final class SimpleAbmessungFabrik {

    /**
     * @param string $abmessungsDaten
     * @param string $kartenelementId
     * @return Abmessung[]
     *
     */
    public static function erzeugeAbmessungen($abmessungsDaten, $kartenelementId = "") {
        /**
         * @var Abmessung[]
         */
        $abmessungen = [];
        foreach (explode(AustauschKonstanten::ABMESSUNG_EINTRAG_TRENNER, $abmessungsDaten) as $abmessung) {
            array_push(
                $abmessungen,
                self::erzeugeAbmessung($abmessung, $kartenelementId));
        }
        return $abmessungen;
    }

    /**
     * @param string $abmessungDaten
     * @param string $kartenelementId
     * @return Abmessung
     */
    public static function erzeugeAbmessung($abmessungDaten, $kartenelementId = "") {
        $daten = explode(AustauschKonstanten::ABMESSUNG_TRENNER, $abmessungDaten);
        $abmessung = new Abmessung();
        $abmessung->setAbmessungen($daten[0], $daten[1], $daten[2], $daten[3]);
        $abmessung->setKartenelementId($kartenelementId);
        return $abmessung;
    }
}

