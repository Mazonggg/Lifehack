<?php

namespace Datenbank\Adapter\Select;

use Model\Konstanten\Keyword;

class GroupConcatLeftJoinQuery extends LeftJoinQuery {

    /**
     * @return string
     */
    public function getQuery() {
        return $this->verketteQueryElemente($this->getGroupConcatParts());
    }

    /**
     * @return string[]
     */
    private function getGroupConcatParts() {
        $parts = $this->getJoinQueryParts();
        $insertIndex = array_search(Keyword::FROM, $parts);
        $newParts = [];
        foreach ($this->tabelle->getGroupConcats() as $groupConcat) {
            $newParts = array_merge($newParts, [
                ",",
                Keyword::GROUP_CONCAT . "(",
                $groupConcat->getGroupConcat(),
                ")",
                Keyword::AS_,
                $groupConcat->getAs()
            ]);
        }
        array_splice($parts, $insertIndex, 0, $newParts);
        return array_merge(
            $parts,
            $this->getGroupByParts()
        );
    }

    /**
     * @return string[]
     */
    private function getGroupByParts() {
        return [
            Keyword::GROUP_BY,
            $this->tabelle->getPrimaerschluessel()
        ];
    }
}

