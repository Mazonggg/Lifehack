<?php

namespace Model;

final class SimpleWertepaarFabrik {
    /**
     * @param string $schluessel
     * @param string $wert
     * @return Wertepaar
     */
    public static function erzeugeWertepaar($schluessel = '', $wert = '') {
        return new Wertepaar($schluessel, $wert);
    }
}

