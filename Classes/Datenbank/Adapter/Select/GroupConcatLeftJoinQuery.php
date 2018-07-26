<?php

namespace Datenbank\Adapter\Select;

<<<<<<< HEAD:Classes/Datenbank/Adapter/Select/GroupConcatLeftJoinQuery.php
use Model\Konstanten\Keyword;

class GroupConcatLeftJoinQuery extends LeftJoinQuery {

    /**
=======
use Model\Enum\Keyword;

class GroupConcatLeftJoinQueryAdapter extends LeftJoinQueryAdapter {

    /**
     * @param int|bool $letzteId
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2:Classes/Datenbank/Adapter/Select/GroupConcatLeftJoinQueryAdapter.php
     * @return string
     */
    public function getQuery($letzteId = false) {
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

