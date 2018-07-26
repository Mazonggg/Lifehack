<?php


namespace Model\Konstanten;


final class Serialisierer {

    public static final function alsPrimaerschluessel($tabellenname) {
        return $tabellenname . "." . $tabellenname . Keyword::ID;
    }

    public static final function alsFremdschluessel($tabellenname, $schluessel) {
        return $tabellenname . "." . $schluessel . Keyword::REF;
    }
}

