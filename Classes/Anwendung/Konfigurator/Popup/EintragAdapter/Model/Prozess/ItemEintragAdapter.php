<?php

namespace Anwendung\Konfigurator\Popup\EintragAdapter\Model\Prozess;

use Anwendung\Konfigurator\Popup\EintragAdapter\EintragAdapter;
use Model\Prozess\Item;

class ItemEintragAdapter extends EintragAdapter {

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

