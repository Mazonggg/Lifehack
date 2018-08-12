<?php

namespace Anwendung\Konfigurator\Form;

use Anwendung\Konfigurator\Form\FormEintrag\IFormEintrag;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Einrichtung\InstitutFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Einrichtung\NiederlassungFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess\AufgabeFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess\ItemFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Prozess\TeilaufgabeFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan\AbmessungenFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan\GebaeudeFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan\KartenelementFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan\UmweltFormEintragAdapter;
use Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan\WohnhausFormEintragAdapter;
use Anwendung\Konfigurator\Modul;
use Datenbank\DatenbankAbrufHandler;
use Model\Einrichtung\Institut;
use Model\Einrichtung\Niederlassung;
use Model\IDatenbankEintrag;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Prozess\Aufgabe;
use Model\Prozess\Item;
use Model\Prozess\Teilaufgabe;
use Model\Stadtplan\Gebaeude;
use Model\Stadtplan\IKartenelement;
use Model\Stadtplan\Kartenelement;
use Model\Stadtplan\Umwelt;
use Model\Stadtplan\Wohnhaus;

class FormModul extends Modul {
    /**
     * @var FormModul|null
     */
    private static $_instance = null;

    /**
     * @return FormModul
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @var string gibt an, wie das Formular verarbeitet wird.
     */
    private $modus = '';

    /**
     * @return string
     */
    public function getCssUrl() {
        return 'css/form.css';
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return 'js/form.js';
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getModulHtml($eintraege) {
        /**
         * @var IFormEintrag[] $teilFormulare
         */
        $teilFormulare = $this->erzeugeEintragAdapters($eintraege);
        if ($this->enthaeltHauptformular($teilFormulare)) {
            return '<form id="form" class="form">' .
                '<p id="form_warnung" class="form_warnung">F&uuml;llen Sie alle Felder aus!</p>' .
                parent::getModulHtml($eintraege) .
                $this->getSubmit() . '</form>';
        } else {
            return $this->getInhalt($eintraege);
        }
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    protected function getContainerHtml($eintraege) {
        return $this->getInhalt($eintraege);
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhalt($eintraege) {
        $form = '';
        /**
         * @var IFormEintrag[] $teilFormulare
         */
        $teilFormulare = $this->erzeugeEintragAdapters($eintraege);
        foreach ($teilFormulare as $teilFormular) {
            $form .= '<div>' . $teilFormular->getEintragInhalt() . '</div>';
        }
        return $form;
    }

    /**
     * @return string
     */
    public function getId() {
        return 'form_body_wrapper';
    }

    /**
     * @param IDatenbankEintrag $eintrag
     * @return IFormEintrag[]
     */
    protected function erzeugeEintragAdapter($eintrag) {
        /**
         * @var IFormEintrag
         */
        $formAdapter = null;
        if ($eintrag instanceof Aufgabe) {
            $formAdapter = new AufgabeFormEintragAdapter($eintrag);
        } elseif ($eintrag instanceof Item) {
            $formAdapter = new ItemFormEintragAdapter($eintrag);
        } elseif ($eintrag instanceof Teilaufgabe) {
            $formAdapter = new TeilaufgabeFormEintragAdapter($eintrag);
        } elseif ($eintrag instanceof Institut) {
            $formAdapter = new InstitutFormEintragAdapter($eintrag);
        } elseif ($eintrag instanceof IKartenelement) {
            return $this->erzeugeKartenelementForms($eintrag);
        }
        if (isset($formAdapter)) {
            $formAdapter->setModus($this->modus);
            return [$formAdapter];
        } else {
            return [];
        }
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IFormEintrag[]
     * TODO Die Rueckgabe als IFormEintrag[] kann durch Einsatz eines Composite Pattern umgangen werden.
     */
    private function erzeugeKartenelementForms($kartenelement) {
        $formAdapters = [
            new KartenelementFormEintragAdapter(self::pruefeKartenelementArt($kartenelement)),
            new AbmessungenFormEintragAdapter($kartenelement->getAbmessungen())
        ];
        if ($kartenelement instanceof Umwelt) {
            array_push($formAdapters, new UmweltFormEintragAdapter($kartenelement));
        } elseif ($kartenelement instanceof Gebaeude) {
            array_push($formAdapters, new GebaeudeFormEintragAdapter($kartenelement));
            if ($kartenelement instanceof Wohnhaus) {
                array_push($formAdapters, new WohnhausFormEintragAdapter($kartenelement));
            } elseif ($kartenelement instanceof Niederlassung) {
                array_push($formAdapters, new NiederlassungFormEintragAdapter($kartenelement));
            }
        }
        foreach ($formAdapters as $formAdapter) {
            $formAdapter->setModus($this->modus);
        }
        return $formAdapters;
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IKartenelement
     */
    private function pruefeKartenelementArt($kartenelement) {
        if (!empty($kartenelement->getKartenelementArt()) || !($kartenelement instanceof Kartenelement)) {
            return $kartenelement;
        } else {
            $kartenelementArten = DatenbankAbrufHandler::Instance()->findSpalteZuId(
                TabellenName::KARTENELEMENT_ART,
                TabellenName::KARTENELEMENT_ART . Keyword::NAME);
            foreach ($kartenelementArten as $kartenelementArt) {
                if ($kartenelementArt->getWert() == $kartenelement->getTabelle()) {
                    $kartenelement->setKartenelementArt($kartenelementArt);
                }
            }
        }
        return $kartenelement;
    }

    /**
     * @param string $modus
     */
    public function setModus($modus) {
        $this->modus = $modus;
    }

    /**
     * @param IFormEintrag[] $teilFormulare
     * @return bool
     */
    private function enthaeltHauptformular($teilFormulare) {
        foreach ($teilFormulare as $teilFormular) {
            if (!$teilFormular->istTeilForm()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    private function getSubmit() {
        return
            '<div id = "form_submit_container" > ' .
            '<input ' .
            'id = "form_submit" ' .
            'class="form_item hoverbox submit" ' .
            'type = "submit" ' .
            'value = "Speichern" > ' .
            '</div > ';
    }
}

