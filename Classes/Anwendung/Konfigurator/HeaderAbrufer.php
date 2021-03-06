<?php

namespace Anwendung\Konfigurator;

use Model\Singleton\ISingleton;

class HeaderAbrufer implements ISingleton {
    /**
     * @var HeaderAbrufer|null
     */
    protected static $_instance = null;

    /**
     * @return HeaderAbrufer
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    const HEAD_LEFT = '<head><meta charset="UTF-8">';
    const HEAD_RIGHT = '<title > Lifehack</title ></head > ';
    const STYLESHEET_LEFT = '<link rel="stylesheet" href="';
    const STYLESHEET_RIGHT = '"/>';
    const SCRIPT_LEFT = '<script src="';
    const SCRIPT_RIGHT = '"></script>';


    /**
     * @param IModul[] $module
     * @return string
     */
    public function getHeader($module) {
        $header = "";
        foreach ($module as $modul) {
            $header .=
                self::STYLESHEET_LEFT . $modul->getCssUrl() . self::STYLESHEET_RIGHT .
                self::SCRIPT_LEFT . $modul->getJavaScriptUrl() . self::SCRIPT_RIGHT;
        }
        return self::HEAD_LEFT . $header . self::HEAD_RIGHT;
    }
}

