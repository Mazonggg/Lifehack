<?php

namespace Datenbank\Model;

use Model\Wertepaar;

final class SimpleQueryWertepaarFabrik {
    /**
     * @param string $schluessel
     * @param string $wert
     * @return Wertepaar
     */
    public static function erzeugeQueryWertePaar($schluessel, $wert) {
        return new Wertepaar($schluessel, $wert);
    }
}

