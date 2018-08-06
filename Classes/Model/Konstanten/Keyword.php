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
    #keywordsfuerFeldermitkeys
    const REF = '_ref';
    const ID = '_id';
    const URL = '_url';
    const NAME = '_name';
    const GROUP_CONCAT = ' GROUP_CONCAT';
    const GROUP_BY = ' GROUP BY ';
    const AS_ = ' AS ';

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

