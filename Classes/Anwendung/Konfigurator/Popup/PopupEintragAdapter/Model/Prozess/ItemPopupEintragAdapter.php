<?php

namespace Anwendung\Konfigurator\Popup\PopupEintragAdapter\Model\Prozess;

use Anwendung\Konfigurator\Popup\PopupEintragAdapter\PopupEintragAdapter;
use Model\Prozess\Item;

class ItemPopupEintragAdapter extends PopupEintragAdapter {

    /**
     * @var Item
     */
    private $item;

    /**
     * ItemPopupListenEintrag constructor.
     * @param Item $item
     */
    public function __construct($item) {
        parent::__construct($item);
        $this->item = $item;
    }

    /**
     * @return string
     */
    protected function getKurzInfo() {
        return $this->item->getName();
    }
}

