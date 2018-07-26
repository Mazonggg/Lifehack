<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter;

use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\HtmlModul\IHtmlClass;
use Konfigurator\HtmlModul\IHtmlId;
use Konfigurator\HtmlModul\IHtmlTag;

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

