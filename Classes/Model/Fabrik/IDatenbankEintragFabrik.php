<?php

namespace Model\Fabrik;

use Model\IDatenbankEintrag;

interface IDatenbankEintragFabrik {

    /**
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    public function erzeugeEintragObjekt($eintragdaten = []);

    /**
     * @return IDatenbankEintrag
     */
    public function erzeugeLeeresEintragObjekt();

}

