<?php

namespace Model\Fabrik;

use Model\IDatenbankEintrag;
use Model\Singleton\ISingleton;

interface IDatenbankEintragFabrik extends ISingleton {

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

