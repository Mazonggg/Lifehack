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
     * @return string
     */
    public function getClass() {
        return $this->getId();
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    abstract protected function getContainerHtml($eintraege);

    /**
     * @param IDatenbankEintrag $eintrag
     * @return IModulEintrag|IModulEintrag[]
     * TODO Die Rueckgabe als IModulEintrag[] kann durch den Einsatz eines Composite Pattern umgangen werden.
     */
    abstract protected function erzeugeEintragAdapter($eintrag);

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return IModulEintrag[]
     */
    protected function erzeugeEintragAdapters($eintraege) {
        $adapters = [];
        foreach ($eintraege as $datenbankEintrag) {
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

