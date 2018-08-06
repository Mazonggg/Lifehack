<?php

namespace Datenbank;

use Datenbank\Adapter\IQuery;
use Model\Singleton\ISingleton;
use mysqli;
use mysqli_result;

class DatenbankHandler implements ISingleton {
    /**
     * @var DatenbankHandler|null
     */
    protected static $_instance = null;

    /**
     * @return DatenbankHandler
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->db = new mysqli('127.0.0.1', 'dgsql18', '!2e=WyMpl3', 'dgsql18');
        }
        return self::$_instance;
    }

    /**
     * @var mysqli
     */
    protected $db = null;

    /**
     * @param mysqli_result $result
     * @return array
     */
    protected function mysqliResultToArray($result) {
        $array = [];
        while ($reihe = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($array, array_filter($reihe));
        }
        return $array;
    }

    /**
     * @param IQuery $adapter
     * @return array|bool
     */
    protected function getResult($adapter) {
        $result = $this->db->query(htmlentities($adapter->getQuery()));
        if ($result instanceof mysqli_result) {
            return $this->mysqliResultToArray($result);
        } else {
            return $result;
        }
    }

    /**
     * @param IQuery $adapter
     * @return array|bool
     */
    public function fuehreQueryAus($adapter) {
        return $this->getResult($adapter);
    }

    /**
     * @return string
     */
    public function getLetzteInsertId() {
        return $this->db->insert_id;
    }

    /**
     * @return string
     */
    public function getFehler() {
        return $this->db->error;
    }
}

