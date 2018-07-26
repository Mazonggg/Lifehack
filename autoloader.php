<?php

/**
 * @param $class
 */
function __autoload($class) {
    $path = 'Classes/' . implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}

