<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Input;

use Model\Wertepaar;

abstract class InputAdapter implements IInput {
    /**
     * @var string
     */
    private $inhalt;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * TextInput constructor.
     * @param string $name
     * @param string $inhalt
     */
    public function __construct($name, $inhalt) {
        $this->name = $name;
        $this->inhalt = $inhalt;
    }

    /**
     * @param string $label
     */
    public function setLabel($label) {
        $this->label = $label;
    }


    /**
     * @return string
     */
    public function getInhalt() {
        return $this->inhalt;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClass() {
        return 'form_item hoverbox form_input';
    }

    /**
     * @return string
     */
    public function getPlaceholder() {
        return ucfirst(implode(" ", (explode("_", $this->getName()))));
    }

    /**
     * @return string
     */
    public function getTag() {
        return "input";
    }

    /**
     * @return Wertepaar[]
     */
    public function getAttribute() {
        return [
            new Wertepaar('type', $this->getType()),
            new Wertepaar('class', $this->getClass()),
            new Wertepaar('name', $this->getName()),
            new Wertepaar('placeholder', $this->getPlaceholder()),
            new Wertepaar("required", "true")
        ];
    }

    /**
     * @return string
     */
    public function getInputHtml() {
        $html = '';
        if (!empty($this->label)) {
            $html = '<label class="form_label">' . $this->label . '</label>';
        }
        $html .= '<' . $this->getTag();
        foreach ($this->getAttribute() as $attribut) {
            if (!empty($attribut->getSchluessel()) && !empty($attribut->getWert())) {
                $html .= ' ' . $attribut->getSchluessel() . '="' . $attribut->getWert() . '" ';
            }
        }
        if (!empty($this->getId())) {
            $html .= ' id="' . $this->getId() . '" ';
        }
        if ($this->getTag() === 'input') {
            $html .= ' value="' . $this->getInhalt() . '"';
        }
        $html .= '>';
        if ($this->getTag() !== 'input') {
            $html .= $this->getInhalt() . '</' . $this->getTag() . '>';
        }
        return $html;
    }

    /**
     * @return string
     */
    public function getId() {
        return '';
    }
}

