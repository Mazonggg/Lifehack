<?php

namespace Anwendung\Konfigurator\Form;

use Anwendung\Konfigurator\Form\FormAdapter\IForm;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Einrichtung\InstitutFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Einrichtung\NiederlassungFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\AufgabeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\ItemFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Prozess\TeilaufgabeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\AbmessungenFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\GebaeudeFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\KartenelementFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\UmweltFormAdapter;
use Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan\WohnhausFormAdapter;
use Anwendung\Konfigurator\ModulAdapter;
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

class FormModulAdapter extends ModulAdapter {
    /**
     * @var FormModulAdapter|null
     */
    private static $_instance = null;

    /**
     * @return FormModulAdapter
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
         * @var IForm[] $teilFormulare
         */
        $teilFormulare = $this->erzeugeEintragAdapters($eintraege);
        if ($this->enthaeltHauptformular($teilFormulare)) {
            return '<form id="form" class="form">' .
                '<p id="form_warnung" class="form_warnung">F&uuml;llen Sie alle Felder aus!</p>' .
                parent::getModulHtml($eintraege) .
                $this->getSubmit() . '</form>';
        } else {
            return $this->getInhaltHtml($eintraege);
        }
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    protected function getContainerHtml($eintraege) {
        return $this->getInhaltHtml($eintraege);
    }

    /**
     * @param IDatenbankEintrag[] $eintraege
     * @return string
     */
    public function getInhaltHtml($eintraege) {
        $form = '';
        /**
         * @var IForm[] $teilFormulare
         */
        $teilFormulare = $this->erzeugeEintragAdapters($eintraege);
        foreach ($teilFormulare as $teilFormular) {
            $form .= '<div>' . $teilFormular->getEintragHtml() . '</div>';
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
     * @param IDatenbankEintrag $datenbankEintrag
     * @return IForm[]
     */
    protected function erzeugeEintragAdapter($datenbankEintrag) {
        /**
         * @var IForm[]
         */
        $formAdapters = [];
        if ($datenbankEintrag instanceof Aufgabe) {
            array_push($formAdapters, new AufgabeFormAdapter($datenbankEintrag, $this->modus));
        } elseif ($datenbankEintrag instanceof Item) {
            array_push($formAdapters, new ItemFormAdapter($datenbankEintrag, $this->modus));
        } elseif ($datenbankEintrag instanceof Teilaufgabe) {
            array_push($formAdapters, new TeilaufgabeFormAdapter($datenbankEintrag, $this->modus));
        } elseif ($datenbankEintrag instanceof Institut) {
            array_push($formAdapters, new InstitutFormAdapter($datenbankEintrag, $this->modus));
        } elseif ($datenbankEintrag instanceof Kartenelement) {
            $formAdapters = array_merge($formAdapters, $this->erzeugeKartenelementForms($datenbankEintrag));
        }
        return $formAdapters;
    }

    /**
     * @param IKartenelement $kartenelement
     * @return IForm[]
     */
    private function erzeugeKartenelementForms($kartenelement) {
        $formAdapters = [
            new KartenelementFormAdapter(self::pruefeKartenelementArt($kartenelement), $this->modus),
            new AbmessungenFormAdapter($kartenelement->getAbmessungen(), $this->modus)
        ];
        if ($kartenelement instanceof Umwelt) {
            array_push($formAdapters, new UmweltFormAdapter($kartenelement, $this->modus));
        } elseif ($kartenelement instanceof Gebaeude) {
            array_push($formAdapters, new GebaeudeFormAdapter($kartenelement, $this->modus));
            if ($kartenelement instanceof Wohnhaus) {
                array_push($formAdapters, new WohnhausFormAdapter($kartenelement, $this->modus));
            } elseif ($kartenelement instanceof Niederlassung) {
                array_push($formAdapters, new NiederlassungFormAdapter($kartenelement, $this->modus));
            }
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
     * @param IForm[] $teilFormulare
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

