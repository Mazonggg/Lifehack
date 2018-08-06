<?php

namespace Datenbank\Model;

final class SimpleGroupConcatFabrik {
    /**
     * @param string $groupConcat
     * @param string $as
     * @return GroupConcat
     */
    public static function erzeugeGroupConcat($groupConcat, $as) {
        return new GroupConcat($groupConcat, $as);
    }
}

