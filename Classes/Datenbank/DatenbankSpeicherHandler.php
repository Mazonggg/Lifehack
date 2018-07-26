<?php

namespace Datenbank;

use Datenbank\Adapter\IQueryAdapter;
use mysqli;

final class DatenbankSpeicherHandler extends DatenbankHandler {
    /**
     * @var DatenbankSpeicherHandler|null
     */
    protected static $_instance = null;

    /**
     * @return DatenbankSpeicherHandler
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            $con = parse_ini_file('con.ini');
            self::$_instance->db = new mysqli(
                $con['host'],
                $con['usr'],
                $con['pwd'],
                $con['name']);
        }
        return self::$_instance;
    }

    /**
     * @param IQueryAdapter $adapter
     * @return array|bool
     */
    public function fuehreQueryAus($adapter) {
        echo "<h1>fuehreQueryAus</h1>";
        echo "<p>" . $adapter->getQuery($this->db->insert_id) . "</p>";
        return $this->getResult($adapter);
    }
}

