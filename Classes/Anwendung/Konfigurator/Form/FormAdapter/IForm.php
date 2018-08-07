<?php

namespace Anwendung\Konfigurator\Form\FormAdapter;

use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IHtmlId;
use Anwendung\Konfigurator\IHtmlTag;
use Anwendung\Konfigurator\IModulEintrag;

interface IForm extends IModulEintrag, IHtmlClass, IHtmlId, IHtmlTag {

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

