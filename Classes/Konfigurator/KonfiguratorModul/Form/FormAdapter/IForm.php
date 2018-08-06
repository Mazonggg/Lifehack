<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\IHtmlClass;
use Konfigurator\KonfiguratorModul\IHtmlId;
use Konfigurator\KonfiguratorModul\IHtmlTag;

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

