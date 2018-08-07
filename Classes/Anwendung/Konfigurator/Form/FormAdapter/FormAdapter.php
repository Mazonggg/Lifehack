<?php

namespace Anwendung\Konfigurator\Form\FormAdapter;

use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\IDatenbankEintrag;

abstract class FormAdapter implements IForm {
    /**
     * @var IDatenbankEintrag
     */
    protected $datenbankEintrag;

    /**
     * @var string
     */
    private $modus;

    /**
     * Form constructor.
     * @param string $modus
     * @param IDatenbankEintrag $datenbankEintrag
     */
    public function __construct($datenbankEintrag, $modus) {
        $this->datenbankEintrag = $datenbankEintrag;
        $this->modus = $modus;
    }

    /**
     * @return string
     */
    public function getEintragHtml() {
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
            '<div id="form_body_content_' . $this->datenbankEintrag->getTabelle() .
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
            '<div id = "form_body_head_' . $this->datenbankEintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="form_body_head align_right" > ' .
            '<div class="popup_optionen" > ' .
            '<button id = "form_body_ausblendbutton_' . $this->datenbankEintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="wechsel_button form_item oeffnen hoverbox " ></button > ' .
            '<h3 class="form_item form_teilueberschrift" > ' . ucfirst(explode("_", $this->datenbankEintrag->getTabelle())[0]) . '</h3 > ' .
            '</div > ' .
            '<div class="popup_optionen" > ' .
            '<button id="entfernen_button_' . $this->datenbankEintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="form_item hoverbox hinweis">l&ouml;schen</button>' .
            '<button id = "loeschen_button_' . $this->datenbankEintrag->getTabelle() . "-" . $this->getDatenbankEintragId() . '" class="wechsel_button form_item loeschen hoverbox " ></button > ' .
            '</div>' .
            '</div > ';
    }

    /**
     * @return string
     */
    public function getId() {
        return 'form_body_' . $this->datenbankEintrag->getTabelle() . "-" . $this->getDatenbankEintragId();
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

