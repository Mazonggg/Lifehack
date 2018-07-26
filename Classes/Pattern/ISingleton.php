<?php

namespace Pattern;

interface ISingleton {

    /**
     * @return ISingleton
     */
    public static function Instance();
}

