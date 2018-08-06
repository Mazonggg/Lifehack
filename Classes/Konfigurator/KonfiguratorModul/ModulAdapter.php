<?php

namespace Konfigurator\KonfiguratorModul;

use Model\Singleton\ISingleton;

abstract class ModulAdapter implements IModul, ISingleton {

    /**
     * @param string $inhalt = alternativ vogegebener Inhalt
     * @return string
     */
    public function getModulHtml($inhalt = "") {
        $html =
            '<' . $this->getTag() .
            (empty($this->getId()) ? '' : ' id="' . $this->getId()) . '" ' .
            (empty($this->getClass()) ? '' : ' class="' . $this->getClass()) . '" ';
        return $html . '>' . (empty($inhalt) ? $this->getInhalt() : $inhalt) . '</' . $this->getTag() . '>';
    }

    /**
     * @return string
     */
    abstract protected function getInhalt();
}

