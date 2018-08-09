<?php

namespace Anwendung\Konfigurator;

use Model\IDatenbankEintrag;
use Model\Singleton\ISingleton;

abstract class Modul implements IModul, ISingleton, IHtmlClass, IHtmlTag, IHtmlId {

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getModulHtml($eintraege) {
        $html =
            '<' . $this->getTag() .
            (empty($this->getId()) ? '' : ' id="' . $this->getId()) . '" ' .
            (empty($this->getClass()) ? '' : ' class="' . $this->getClass()) . '" ';
        return $html . '>' . $this->getContainerHtml($eintraege) . '</' . $this->getTag() . '>';
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    abstract protected function getContainerHtml($eintraege);

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    abstract public function getInhaltHtml($eintraege);

    /**
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IModulEintrag|IModulEintrag[]
     */
    abstract protected function erzeugeEintragAdapter($datenbankEintrag);

    /**
     * @param IDatenbankEintrag[] $datenbankEintraege
     * @return IModulEintrag[]
     */
    protected function erzeugeEintragAdapters($datenbankEintraege) {
        $adapters = [];
        foreach ($datenbankEintraege as $datenbankEintrag) {
            $adapter = $this->erzeugeEintragAdapter($datenbankEintrag);
            if (is_array($adapter) && !is_object($adapter)) {
                $adapters = array_merge($adapters, $adapter);
            } else {
                array_push($adapters, $adapter);
            }
        }
        return $adapters;
    }
}

