<?php

namespace Konfigurator\HtmlGenerator\Menue;

use Datenbank\Adapter\Speicher\SpeicherKeywords;
use Konfigurator\IHtmlObjekt;
use Model\Aufgabe\Aufgabe;
use Model\Aufgabe\Item;
use Model\Enum\AjaxKeywords;
use Model\Enum\TabellenName;
use Model\Institut\Institut;
use Pattern\SingletonPattern;

class MenueGenerator extends SingletonPattern implements IHtmlObjekt {
    /**
     * @var MenueGenerator|null
     */
    private static $_instance = null;

    /**
     * @param Item[] $items
     * @param Institut[]
     * @param Aufgabe[] $aufgaben
     * @return MenueGenerator
     */
    public static function Instance($items = [], $institute = [], $aufgaben = []) {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->itemSammlung = $items;
            self::$_instance->institutSammlung = $institute;
            self::$_instance->aufgabenSammlung = $aufgaben;
        }
        return self::$_instance;
    }

    /**
     * @var Item[]
     */
    private $itemSammlung = [];
    /**
     * @var Institut[]
     */
    private $institutSammlung = [];
    /**
     * @var Aufgabe[]
     */

    private $aufgabenSammlung = [];

    /**
     * @return string
     */
    public function getCssUrl() {
        return 'css/menue.css';
    }

    /**
     * @return string
     */
    public function getJavaScriptUrl() {
        return 'js/menue.js';
    }

    /**
     * @return string
     */
    public function getHtml() {
        return
            str_replace('\\', '', $this->getMenue() .
                $this->getFormBody());
    }

    /**
     * @return string
     */
    private function getMenue() {
        return
            '<div id="menue_container" class="menue_container">' .
            '<div id=\"logo_container\" class=\"logo_container\"><p id=\"logo\" class=\"logo\">Lifehack</p></div>' .
            '<div id="menue" class="menue">' .
            $this->getMenueButton(TabellenName::AUFGABE . SpeicherKeywords::SPEICHERN, TabellenName::AUFGABE) .
            $this->getMenueButton(TabellenName::INSTITUT . SpeicherKeywords::SPEICHERN, TabellenName::INSTITUT) .
            $this->getMenueButton(TabellenName::ITEM . SpeicherKeywords::SPEICHERN, TabellenName::ITEM) .
            '</div></div>';
    }

    /**
     * @param int $buttonId
     * @param string $buttonImage
     * @return string
     */
    private function getMenueButton($buttonId, $name) {
        return '<p id="' . $buttonId . '" class="menue_button hoverbox">' . $name . '</p>';
    }

    /**
     * @return string
     */
    private function getFormBody() {
        return
            '<div id="form_container" class="form_container">' .
            '<form id="form" class="form" action="index.php?modus=form" method="post">' .
            '<div id="form_body_wrapper" class="form_body_wrapper">' .
            '<div id="form_body" class="form_body"></div>' .
            '</div>' . $this->getFormOptionen() . '</form></div>';
    }

    /**
     * @param string $modus
     * @param array $inputDaten
     * @return string
     */
    public function getForm($modus, $titel, $inputDaten) {

        $form = $this->getInputNachTyp(AjaxKeywords::TITEL, [AjaxKeywords::NAME => $titel]) .
            '<div class="form_block_content">' .
            $this->getFormTextInput(AjaxKeywords::MODUS, $modus, false);
        foreach ($inputDaten as $input) {
            $form .= $this->getInputNachTyp($input[AjaxKeywords::TYP], $input[AjaxKeywords::INPUT_DATEN]);
        }
        return $form . '</div></div>';
    }

    /**
     * @param string $modus
     * @param string $titel
     * @param array $inputDaten
     * @return string
     */
    public function getTeilabschnittForm($modus, $titel, $inputDaten) {
        // TODO Button zum Loeschen
        $form = $this->getInputNachTyp(AjaxKeywords::TITEL, [AjaxKeywords::NAME => $titel]) .
            '<div class="form_block_content">';
        $form .= $this->getFormTextInput(AjaxKeywords::MODUS, $modus, false);
        foreach ($inputDaten as $input) {
            $form .= $this->getInputNachTyp($input[AjaxKeywords::TYP], $input[AjaxKeywords::INPUT_DATEN]);
        }
        return $form . '</div>';
    }

    private function getFormOptionen() {
        return
            '<div class="form_optionen">' .
            '<button ' .
            'type="button" ' .
            'class="hoverbox form_abbrechen" ' .
            'id="form_abbrechen">Abbrechen</button>' .
            $this->getFormSubmit() .
            '</div>';
    }

    private function getInputNachTyp($typ, $inputDaten) {
        $input = '';
        $name = $inputDaten[AjaxKeywords::NAME];
        if ($typ == AjaxKeywords::TEXT) {
            $input = $this->getFormTextInput($name);
        } elseif ($typ == AjaxKeywords::NUMBER) {
            $input = $this->getFormNumberInput($name, $inputDaten[AjaxKeywords::MAX]);
        } elseif ($typ == AjaxKeywords::TEXTAREA) {
            $input = $this->getFormTextarea($name);
        } elseif ($typ == AjaxKeywords::SELECT) {
            $input = $this->getFormSelect($name, $inputDaten[AjaxKeywords::LABEL], $inputDaten[AjaxKeywords::OPTIONEN]);
        } elseif ($typ == AjaxKeywords::CHILD_FORM) {
            $input = $this->getAddChildForm($name);
        } elseif ($typ == AjaxKeywords::TITEL) {
            $input = $this->getTitel($name);
        }
        return $input;
    }

    /**
     * @param string $name
     * @param string $wert
     * @param bool $visible
     * @return string
     */
    private function getFormTextInput($name, $wert = '', $visible = true) {
        $input = '<input class="form_item hoverbox form_input';
        if (!$visible) {
            $input .= ' hidden';
        }
        return $input .
            '" name="' . $name . '" ' .
            'type="text" ' .
            'required placeholder="' .
            $this->macheStringAusNamen($name) .
            '" value="' . $wert . '"/>';
    }

    /**
     * @param string $name
     * @param int $max
     * @return string
     */
    private function getFormNumberInput($name, $max) {
        return '<input ' .
            'class="form_item hoverbox  form_input" ' .
            'name="' . $name . '" ' .
            'type="number" ' .
            'min="1" ' .
            'max="' . $max . '" ' .
            'required ' .
            'placeholder="' .
            $this->macheStringAusNamen($name) .
            '"/>';
    }

    /**
     * @param string $name
     * @return string
     */
    private function getFormTextarea($name) {
        return '<textarea ' .
            'class="form_item hoverbox form_input" ' .
            'name="' . $name . '" ' .
            'required ' .
            'placeholder = "' . $this->macheStringAusNamen($name) . '" ' .
            'rows="5"></textarea>';
    }

    /**
     * @param string $name
     * @param string $label
     * @param string[] $optionen
     * @return string
     */
    private function getFormSelect($name, $label, $optionen) {
        $optionElemente = [];
        foreach ($optionen as $key => $option) {
            array_push(
                $optionElemente,
                '<option value="' . $key . '">' . $option . '</option>');
        }
        return
            '<label class="form_item form_label">' . $label . '</label>' .
            '<select class="form_item form_input hoverbox form_select" name="' . $name . '" required>' .
            implode('', $optionElemente) .
            '</select>';
    }

    /**
     * @return string
     */
    private function getFormSubmit() {
        return '<input ' .
            'id="form_submit" ' .
            'class="form_item hoverbox form_submit" ' .
            'type="submit" ' .
            'value="Speichern">';
    }

    /**
     * @param string $id
     * @return string
     */
    private function getAddChildForm($id) {
        return
            '<div class="form_block_neu">' .
            '<button ' .
            'type="button" ' .
            'class="form_item hoverbox form_neu_button" ' .
            'id="' . $id . '">' .
            $this->macheStringAusNamen($id) .
            '</button>' .
            '</div>';
    }

    /**
     * @param string $name
     * @return string
     */
    private function getTitel($name) {
        return
            '<div class="form_block_head">' .
            '<h3 class="form_item form_teilueberschrift">' . $name . '</h3>' .
            '<button class="form_block_ausblender form_item hoverbox">&#45;</button>' .
            '</div>';
    }

    /**
     * @param string $name
     * @return string
     */
    private function macheStringAusNamen($name) {
        return implode(' ', explode('_', ucfirst($name)));
    }
}

