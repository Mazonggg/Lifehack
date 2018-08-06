<?php

namespace Model;

abstract class DatenbankEintrag implements IDatenbankEintrag {

    /**
     * @var string
     */
    private $id = "";

    /**
     * DatenbankObjekt constructor.
     */
    public function __construct() { }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
}

