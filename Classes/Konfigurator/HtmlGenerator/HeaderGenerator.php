<?php

namespace Konfigurator\HtmlGenerator;

use Konfigurator\HtmlGenerator\Menue\MenueGenerator;
use Konfigurator\HtmlGenerator\Stadtplan\StadtplanGenerator;
use Konfigurator\Konfigurator;
use Pattern\SingletonPattern;

class HeaderGenerator extends SingletonPattern {
    /**
     * @var HeaderGenerator|null
     */
    protected static $_instance = null;

    /**
     * @return HeaderGenerator
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getHeader() {
        return '<head>
                    <meta charset="UTF-8">
                    <link rel="stylesheet" href="css/index.css">
                    <link rel="stylesheet" href="' . StadtplanGenerator::Instance()->getCssUrl() . '">
                    <link rel="stylesheet" href="' . MenueGenerator::Instance()->getCssUrl() . '">
                    <link rel="stylesheet" href="' . Konfigurator::Instance()->getCssUrl() . '">
                    <script type="application/javascript" src="' . Konfigurator::Instance()->getJavaScriptUrl() . '"></script>
                    <script type="application/javascript" src="' . MenueGenerator::Instance()->getJavaScriptUrl() . '"></script>
                    <title>Lifehack</title>
                </head>';
    }
}

