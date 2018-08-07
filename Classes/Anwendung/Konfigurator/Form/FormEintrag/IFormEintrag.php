<?php

namespace Anwendung\Konfigurator\Form\FormEintrag;

use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\IHtmlClass;
use Anwendung\Konfigurator\IHtmlId;
use Anwendung\Konfigurator\IHtmlTag;
use Anwendung\Konfigurator\IModulEintrag;

interface IFormEintrag extends IModulEintrag, IHtmlClass, IHtmlId, IHtmlTag {

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

