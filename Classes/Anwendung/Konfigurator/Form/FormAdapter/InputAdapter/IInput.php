<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\InputAdapter;

use Anwendung\Konfigurator\IHtmlClass;

interface IInput extends IHtmlClass {

    /**
     * @return string
     */
    public function getInputHtml();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getPlaceholder();
}

