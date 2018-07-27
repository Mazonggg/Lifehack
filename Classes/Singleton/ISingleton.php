<?php

namespace Singleton;

interface ISingleton {

    /**
     * @return ISingleton
     */
    public static function Instance();
}

