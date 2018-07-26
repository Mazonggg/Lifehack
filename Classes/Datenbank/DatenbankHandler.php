<?php

namespace Datenbank;

use Datenbank\Adapter\IQueryAdapter;
use mysqli;
use mysqli_result;
use Pattern\SingletonPattern;

<<<<<<< HEAD
class DatenbankHandler extends SingletonPattern {
    /**
     * @var DatenbankHandler|null
     */
    protected static $_instance = null;
=======
abstract class DatenbankHandler extends SingletonPattern {
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2

    /**
     * @return DatenbankHandler
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            self::$_instance->db = self::$_instance->getConnection();
        }
        return self::$_instance;
    }

    /**
     * @var mysqli
     */
    protected $db = null;

    protected function getConnection() {
        return new mysqli('127.0.0.1', 'dgsql18', '!2e=WyMpl3', 'dgsql18');
    }

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
     * @param IQueryAdapter $adapter
     * @return array|bool
     */
    protected function getResult($adapter) {
        $result = $this->db->query($adapter->getQuery());
        if ($result instanceof mysqli_result) {
            return $this->mysqliResultToArray($result);
        } else {
            return $result;
        }
<<<<<<< HEAD
    }

    /**
     * @param IQueryAdapter $adapter
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
=======
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
    }
}

