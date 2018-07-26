<?php

namespace Model\Konstanten;

class Keyword {

    const FROM = ' FROM ';
    const WHERE = ' WHERE ';
    const ANY = ' * ';
    const SELECT = ' SELECT ';
    const BRACKET_CLOSE = ')';
    const DELETE = ' DELETE ';
    const BRACKET_OPEN = '(';
    const INSERT = ' INSERT ';
    const UPDATE = ' UPDATE ';
    const VALUES = ' VALUES ';
    const ON = ' ON ';
    const INTO = ' INTO ';
    const SET = ' SET ';
    const EQUALS = ' = ';
    const LEFT_JOIN = ' LEFT JOIN ';
<<<<<<< HEAD:Classes/Model/Konstanten/Keyword.php
    #keywordsfuerFeldermitkeys
    const REF = '_ref';
    const ID = '_id';
    const URL = '_url';
    const NAME = '_name';
    const GROUP_CONCAT = ' GROUP_CONCAT';
    const GROUP_BY = ' GROUP BY ';
    const AS_ = ' AS ';
=======
    # keywords fuer Felder mit keys
    const REF = "_ref";
    const ID = "_id";
    const URL = "_url";
    const NAME = "_name";
    const GROUP_CONCAT = "GROUP_CONCAT";
    const GROUP_BY = "GROUP BY";
    const AS_ = "AS";
    const TABELLE = "tabelle";
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2:Classes/Model/Enum/Keyword.php

    /**
     * @returnstring[]
     */
    public static function getKeyMarker() {
        return [self::ID,
            self::REF,
            self::URL,
            self::NAME];
    }
}

