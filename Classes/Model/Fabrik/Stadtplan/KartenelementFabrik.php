<?php

namespace Model\Fabrik\Stadtplan;

use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Fabrik\DatenbankEintragFabrik;
use Model\SimpleWertepaarFabrik;
use Model\Stadtplan\Kartenelement;
use Model\Stadtplan\SimpleAbmessungFabrik;

abstract class KartenelementFabrik extends DatenbankEintragFabrik {
    /**
     * @return string
     */
    public abstract function getKartenelementTyp();

    /**
     * @return string
     */
    public function getEintragSchluessel() {
        return TabellenName::KARTENELEMENT_ART . Keyword::NAME;
    }

    /**
     * @param Kartenelement $kartenelement
     * @param array $eintragdaten
     * @return Kartenelement
     */
    protected function setAttribute($kartenelement, $eintragdaten) {
        $kartenelement->setId((int)$eintragdaten[TabellenName::KARTENELEMENT . Keyword::ID]);
        $abmessungen = SimpleAbmessungFabrik::erzeugeAbmessungen(
            $eintragdaten[TabellenName::ABMESSUNG],
            $kartenelement->getId());
        $kartenelement->setAbmesungen($abmessungen);
        $kartenelement->setKartenelementAussehen(SimpleWertepaarFabrik::erzeugeWertepaar(
            $eintragdaten[TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::REF],
            $eintragdaten[TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::URL]
        ));
        $kartenelement->setKartenelementArt(SimpleWertepaarFabrik::erzeugeWertepaar(
            $eintragdaten[TabellenName::KARTENELEMENT_ART . Keyword::REF],
            $eintragdaten[TabellenName::KARTENELEMENT_ART . Keyword::NAME]
        ));
        return $kartenelement;
    }
}

