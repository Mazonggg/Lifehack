<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Model\Konstanten\AjaxKeywords;
use Model\IDatenbankEintrag;

abstract class Form implements IFormAdapter {
    /**
     * @var IDatenbankEintrag
     */
    private $datenbankEintrag;

    /**
     * @var string
     */
    private $modus;

    /**
     * Form constructor.
     * @param IDatenbankEintrag $datenbankEintrag
     */
    public function __construct($datenbankEintrag) {
        $this->datenbankEintrag = $datenbankEintrag;
    }

    /**
     * @param string $modus
     * @return string
     */
    public function getFormHtml($modus) {
        $this->modus = $modus;
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
            "-" . $this->datenbankEintrag->getId() . '" class="form_body_content">';
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
            '<div id = "form_body_head_' . $this->datenbankEintrag->getTabelle() . "-" . $this->datenbankEintrag->getId() . '" class="form_body_head align_right" > ' .
            '<div class="popup_optionen" > ' .
            '<button id = "form_body_ausblendbutton_' . $this->datenbankEintrag->getTabelle() . "-" . $this->datenbankEintrag->getId() . '" class="wechsel_button form_item oeffnen hoverbox " ></button > ' .
            '<h3 class="form_item form_teilueberschrift" > ' . ucfirst(explode("_", $this->datenbankEintrag->getTabelle())[0]) . '</h3 > ' .
            '</div > ' .
            '<div class="popup_optionen" > ' .
            '<button id="entfernen_button_' . $this->datenbankEintrag->getTabelle() . "-" . $this->datenbankEintrag->getId() . '" class="form_item hoverbox hinweis">l&ouml;schen</button>' .
            '<button id = "loeschen_button_' . $this->datenbankEintrag->getTabelle() . "-" . $this->datenbankEintrag->getId() . '" class="wechsel_button form_item loeschen hoverbox " ></button > ' .
            '</div>' .
            '</div > ';
    }

    /**
     * @return string
     */
    public function getId() {
        return 'form_body_' . $this->datenbankEintrag->getTabelle() . "-" . $this->datenbankEintrag->getId();
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
     * @return IInputAdapter
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
                        $this->datenbankEintrag->getId(),
                    SimpleInputFabrik::ID =>
                        $this->getTabelle() . '_' .
                        AjaxKeywords::MODUS . '-' .
                        $this->datenbankEintrag->getId()
                ]
            );
    }
}

