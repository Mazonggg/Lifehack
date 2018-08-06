<?php

namespace Anwendung\Konfigurator\Form\FormAdapter;

use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IHtmlId;
use Anwendung\Konfigurator\IHtmlTag;

interface IForm extends IHtmlClass, IHtmlId, IHtmlTag {

    /**
     * @param string $modus
     * @return string
     */
    public function getFormHtml($modus);

    /**
     * @return string
     */
    public function getTabelle();

    /**
     * @return IInput[]
     */
    public function getFormInputs();

    /**
     * @return bool
     */
    public function istTeilForm();

    /**
     * @return bool
     */
    public function hatTitelElement();

    /**
     * @return string
     */
    public function getDatenbankEintragId();
}

