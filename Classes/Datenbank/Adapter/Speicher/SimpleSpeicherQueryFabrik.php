<?php

namespace Datenbank\Adapter\Speicher;

use Datenbank\Adapter\IQueryAdapter;
use Model\Enum\Keyword;
use Pattern\SingletonPattern;

class SimpleSpeicherQueryFabrik extends SingletonPattern {
    /**
     * @var SimpleSpeicherQueryFabrik|null
     */
    private static $_instance = null;

    /**
     * @return SimpleSpeicherQueryFabrik
     */
    public static function Instance() {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param array $anfrageDaten
     * @return IQueryAdapter[]
     */
    public function erzeugeQueryAdapters($anfrageDaten) {
        $teilQueries = [];
        foreach ($anfrageDaten as $key => $daten) {
            if (is_array($daten)) {
                unset($anfrageDaten[$key]);
                if (is_array($daten[0])) {
                    foreach ($daten as $teilDaten) {
                        array_push($teilQueries, $teilDaten);
                        unset($daten[$key]);
                    }
                }
            }
        }
        $hauptAdapter = $this->baueQueryAdapter($anfrageDaten);
        $adapterArray = [$hauptAdapter];
        foreach ($teilQueries as $teilQuery) {
            array_push($adapterArray, $this->baueQueryAdapter($teilQuery, $hauptAdapter->getTabelle()));
        }
        return $adapterArray;
    }

    /**
     * @param array $queryDaten
     * @param string|null $fremdSchluesselTabelle
     * @return InsertQueryAdapter mixed
     */
    private function baueQueryAdapter($queryDaten, $fremdSchluesselTabelle = null) {
        var_export($queryDaten);
        $modus = $queryDaten[SpeicherKeywords::MODUS];
        $tabelle = explode("_", $modus)[0];
        #$operation = explode("_", $modus)[1];
        unset($queryDaten[SpeicherKeywords::MODUS]);
        if($fremdSchluesselTabelle != null) {
            $queryDaten[$tabelle . "_" . $fremdSchluesselTabelle . Keyword::REF] = SpeicherKeywords::LETZTE_ID;
        }

        return new InsertQueryAdapter($tabelle, $queryDaten);
    }
}

