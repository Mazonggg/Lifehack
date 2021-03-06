<?php

namespace Anwendung\Konfigurator\Form\FormEintrag;

use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\ModulEintragAdapter;
use Model\Konstanten\AjaxKeywords;

abstract class FormEintragAdapter extends ModulEintragAdapter implements IFormEintrag {

    /**
     * @var string
     */
    private $modus = '';

    /**
     * @param string $modus
     */
    public function setModus($modus) {
        $this->modus = $modus;
    }

    /**
     * @return string
     */
    public function getEintragInhalt() {
        $form =
            '<' . $this->getTag() . ' class="';
        if ($this->istTeilForm()) {
            $form .= 'form_body_teilabschnitt ';
        }
        return $form . $this->getClass() . '" id="' . $this->getId() . '">' .
            $this->getFormInhalt() .
            '</' . $this->getTag() . '>';
    }

    /**
     * @return string
     */
    private function getFormInhalt() {
        $form = '';
        if ($this->hatTitelElement()) {
            $form .= $this->getTitelBlock();
        }
        $form .=
            '<div id="form_body_content_' . $this->eintrag->getTabelle() .
            "-" . $this->getDatenbankEintragId() . '" class="form_body_content">';
        $form .= $this->getModusInput()->getInputHtml();
        foreach ($this->getFormInputs() as $input) {
            $form .= $input->getInputHtml();
        }
        return $form . '</div >';
    }

    /**
     * @return string
     */
    private function getTitelBlock() {
        return
            '<div id = "form_body_head_' . $this->eintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="form_body_head align_right" > ' .
            '<div class="popup_optionen" > ' .
            '<button id = "form_body_ausblendbutton_' . $this->eintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="wechsel_button form_item oeffnen hoverbox " ></button > ' .
            '<h3 class="form_item form_teilueberschrift" > ' . ucfirst(explode("_", $this->eintrag->getTabelle())[0]) . '</h3 > ' .
            '</div > ' .
            '<div class="popup_optionen" > ' .
            '<button id="entfernen_button_' . $this->eintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="form_item hoverbox hinweis">l&ouml;schen</button>' .
            '<button id = "loeschen_button_' . $this->eintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="wechsel_button form_item loeschen hoverbox " ></button > ' .
            '</div>' .
            '</div > ';
    }

    /**
     * @return string
     */
    public function getId() {
        return 'form_body_' . $this->eintrag->getTabelle() . "-" . $this->getDatenbankEintragId();
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'form_body';
    }

    /**
     * @return string
     */
    public function getTag() {
        return 'div';
    }

    /**
     * @return IInput
     */
    private function getModusInput() {
        return
            SimpleInputFabrik::erzeugeFormInput(
                SimpleInputFabrik::HIDDEN,
                'modus',
                [
                    SimpleInputFabrik::INHALT =>
                        $this->getTabelle() . '_' .
                        $this->modus . '-' .
                        $this->getDatenbankEintragId(),
                    SimpleInputFabrik::ID =>
                        $this->getTabelle() . '_' .
                        AjaxKeywords::MODUS . '-' .
                        $this->getDatenbankEintragId()
                ]
            );
    }
}

