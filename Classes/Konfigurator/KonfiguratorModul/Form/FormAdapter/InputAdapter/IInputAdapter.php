<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter;

use Konfigurator\KonfiguratorModul\IHtmlClass;

interface IInputAdapter extends IHtmlClass {

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

