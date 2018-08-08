<?php

namespace Model\Prozess;

class Dialog {
    /**
     * @var string
     */
    private $menueText = '';

    /**
     * @var string
     */
    private $anspracheText = '';

    /**
     * @var string
     */
    private $antwortText = '';

    /**
     * @var string
     */
    private $erfuellungsText = '';

    /**
     * @var string
     */
    private $scheiternText = '';

    /**
     * Dialog constructor.
     */
    public function __construct() {
    }

    /**
     * @return string
     */
    public function getMenueText() {
        return $this->menueText;
    }

    /**
     * @param string $menueText
     */
    public function setMenueText($menueText) {
        $this->menueText = $menueText;
    }

    /**
     * @return string
     */
    public function getAnspracheText() {
        return $this->anspracheText;
    }

    /**
     * @param string $anspracheText
     */
    public function setAnspracheText($anspracheText) {
        $this->anspracheText = $anspracheText;
    }

    /**
     * @return string
     */
    public function getAntwortText() {
        return $this->antwortText;
    }

    /**
     * @param string $antwortText
     */
    public function setAntwortText($antwortText) {
        $this->antwortText = $antwortText;
    }

    /**
     * @return string
     */
    public function getErfuellungsText() {
        return $this->erfuellungsText;
    }

    /**
     * @param string $erfuellungsText
     */
    public function setErfuellungsText($erfuellungsText) {
        $this->erfuellungsText = $erfuellungsText;
    }

    /**
     * @return string
     */
    public function getScheiternText() {
        return $this->scheiternText;
    }

    /**
     * @param string $scheiternText
     */
    public function setScheiternText($scheiternText) {
        $this->scheiternText = $scheiternText;
    }
}

