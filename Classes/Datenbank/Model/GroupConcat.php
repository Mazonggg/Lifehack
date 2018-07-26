<?php

namespace Datenbank\Model;

class GroupConcat {

    /**
     * @var string
     */
    private $groupConcat;

    /**
     * @var string
     */
    private $as;

    /**
     * QueryGroupConcat constructor.
     * @param string $groupConcat
     * @param string as
     */
    public function __construct($groupConcat, $as) {
        $this->groupConcat = $groupConcat;
        $this->as = $as;
    }

    /**
     * @return string
     */
    public function getGroupConcat() {
        return $this->groupConcat;
    }

    /**
     * @return string
     */
    public function getAs() {
        return $this->as;
    }
}

