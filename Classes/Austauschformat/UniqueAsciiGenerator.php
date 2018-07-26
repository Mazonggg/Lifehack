<?php

namespace Austauschformat;

use Pattern\SingletonPattern;

/**
 * Erzeugt eindeutig unterscheidbare Zeichenketten.
 *
 * Class UniqueAsciiGenerator
 * @package Konfigurator\Stadtplan
 */
final class UniqueAsciiGenerator extends SingletonPattern {
    /**
     * @var UniqueAsciiGenerator|null
     */
    protected static $_instance = null;

    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @var int
     */
    private $index = 0;
    /**
     * @var int
     */
    private $laenge = AustauschKonstanten::ASCII_CODE_LAENGE;

    const ERSTE_ENTITAET = 65;
    const LETZTE_ENTITAET = 90;

    /**
     * @return string|false
     */
    public function naechteZeichenkette() {
        if (!$this->indexIstImRahmen($this->index)) {
            return false;
        }
        return $this->getZeichenketteFuerIndex($this->index++);
    }

    /**
     * @param int $index
     * @return bool
     */
    private function indexIstImRahmen($index) {
        return $index < pow(self::LETZTE_ENTITAET - self::ERSTE_ENTITAET, $this->laenge);
    }

    /**
     * @param int $index
     * @return string
     */
    private function getZeichenketteFuerIndex($index) {
        $entitaeten = [$this->getEntitaetFuerIndex($index)];
        for ($i = 1; $i < $this->laenge; $i++) {
            $index /= (self::LETZTE_ENTITAET - self::ERSTE_ENTITAET);
            array_push($entitaeten, $this->getEntitaetFuerIndex($index));
        }
        return implode("", $entitaeten);
    }

    /**
     * @param $index
     * @return string
     */
    private function getEntitaetFuerIndex($index) {
        $index %= self::LETZTE_ENTITAET - self::ERSTE_ENTITAET;
        return chr(($index < 0 ? 0 : $index) + self::ERSTE_ENTITAET);
    }

    /**
     * @return int
     */
    public function getLaenge() {
        return $this->laenge;
    }

    /**
     * @return string
     */
    public static function getEmptyZeichenkette() {
        return '';
    }
}

