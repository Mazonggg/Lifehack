<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\KonfiguratorModul\IHtmlClass;
use Konfigurator\KonfiguratorModul\IHtmlId;
use Konfigurator\KonfiguratorModul\IHtmlTag;

interface IFormAdapter extends IHtmlClass, IHtmlId, IHtmlTag {

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
     * @return IInputAdapter[]
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
}

