<?php

namespace Model\Singleton;

interface ISingleton {

    /**
     * @return ISingleton
     */
    public static function Instance();
}

