<?php

namespace Model\Prozess;

class Dialog {
    /**
     * @var string
     */
    private $menueText;

    /**
     * @var string
     */
    private $anspracheText;

    /**
     * @var string
     */
    private $antwortText;

    /**
     * @var string
     */
    private $erfuellungsText;

    /**
     * @var string
     */
    private $scheiternText;

    /**
     * Dialog constructor.
     * @param string $menueText
     * @param string $anspracheText
     * @param string $antwortText
     * @param string $erfuellungsText
     * @param string $scheiternText
     */
    public function __construct($menueText = "", $anspracheText = "", $antwortText = "", $erfuellungsText = "", $scheiternText = "") {
        $this->menueText = $menueText;
        $this->anspracheText = $anspracheText;
        $this->antwortText = $antwortText;
        $this->erfuellungsText = $erfuellungsText;
        $this->scheiternText = $scheiternText;
    }

    /**
     * @return string
     */
    public function getMenueText() {
        return $this->menueText;
    }

    /**
     * @return string
     */
    public function getAnspracheText() {
        return $this->anspracheText;
    }

    /**
     * @return string
     */
    public function getAntwortText() {
        return $this->antwortText;
    }

    /**
     * @return string
     */
    public function getErfuellungsText() {
        return $this->erfuellungsText;
    }

    /**
     * @return string
     */
    public function getScheiternText() {
        return $this->scheiternText;
    }
}

