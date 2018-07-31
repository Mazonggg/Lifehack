<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter;

use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
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
     * @return IFormInputAdapter[]
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

