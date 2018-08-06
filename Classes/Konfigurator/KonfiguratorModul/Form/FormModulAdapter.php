<?php

namespace Konfigurator\KonfiguratorModul\Form;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\IForm;
use Konfigurator\KonfiguratorModul\HtmlModulAdapter;

class FormModulAdapter extends HtmlModulAdapter {
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
     * @param string $modus
     * @param IForm[] $teilFormulare
     * @return string
     */
    protected function getInhalt($modus = '', $teilFormulare = []) {
        if (empty($modus) || empty($teilFormulare)) {
            return '';
        } else {
            $form = '';
            foreach ($teilFormulare as $teilFormular) {
                $form .= '<div>' . $teilFormular->getFormHtml($modus) . '</div>';
            }
            return $form;
        }
    }

    /**
     * @param string $modus
     * @param IForm[] $teilFormulare
     * @return string
     */
    public function getModulHtml($modus = '', $teilFormulare = []) {
        if (empty($modus) || empty($teilFormulare)) {
            return '';
        } else {
            if ($this->enthaeltHauptformular($teilFormulare)) {
                return '<form id="form" class="form">' .
                    '<p id="form_warnung" class="form_warnung">F&uuml;llen Sie alle Felder aus!</p>' .
                    parent::getModulHtml($this->getInhalt($modus, $teilFormulare)) .
                    $this->getSubmit() . '</form>';
            } else {
                return $this->getInhalt($modus, $teilFormulare);
            }
        }
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
}

