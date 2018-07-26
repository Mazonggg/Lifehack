<?php

namespace Model\Fabrik;

use Model\IDatenbankEintrag;
use Pattern\SingletonPattern;

abstract class DatenbankEintragFabrik extends SingletonPattern implements IDatenbankEintragFabrik {

    /**
     * @return IDatenbankEintrag
     */
    abstract protected function erzeugeLeeresEintragObjekt();

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    abstract protected function setAttribute($datenbankEintrag, $eintragdaten);

    /**
     * @param array $eintragdaten
     * @return IDatenbankEintrag
     */
    public function erzeugeEintragObjekt($eintragdaten = []) {
        $eintrag = $this->erzeugeLeeresEintragObjekt();
        if ($eintragdaten) {
            return $this->setAttribute($eintrag, $eintragdaten);
        }
        return $eintrag;
    }
}

