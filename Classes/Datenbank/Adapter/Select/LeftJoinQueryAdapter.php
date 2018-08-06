<?php

namespace Datenbank\Adapter\Select;

use Model\Konstanten\Keyword;

class LeftJoinQueryAdapter extends SelectQueryAdapter {

    /**
     * @return string
     */
    public function getQuery() {
        return $this->verketteQueryElemente($this->getJoinQueryParts());
    }

    /**
     * @return string[]
     */
    protected function getJoinQueryParts() {
        return array_merge(
            $this->getSelectQueryParts(),
            $this->getJoinConditions(),
            (!empty($this->tabelle->getPrimaerschluessel()->getWert()) ? $this->getBedingungQueryParts() : [])
        );
    }

    /**
     * @return string[]
     */
    private function getJoinConditions() {
        $joinConditions = [];
        foreach ($this->tabelle->getRelationen() as $relation) {
            array_push(
                $joinConditions,
                Keyword::LEFT_JOIN,
                $relation->getTabellenname(),
                Keyword::ON,
                $relation->getPrimaerschluessel(),
                Keyword::EQUALS,
                $relation->getFremdschluessel()
            );
        }
        return $joinConditions;
    }
}

