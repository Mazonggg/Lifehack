<?php

namespace Datenbank\Model;

final class SimpleRelationFabrik {
    /**
     * @param string $tabellenname
     * @param string $primaerschluessel
     * @param string $fremdschluessel
     * @return Relation
     */
    public static function erzeugeRelation($tabellenname, $primaerschluessel, $fremdschluessel) {
        return new Relation($tabellenname, $primaerschluessel, $fremdschluessel);
    }
}

