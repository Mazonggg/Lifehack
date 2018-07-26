<?php

namespace Konfigurator\HtmlModul\Popup\PopupEintragAdapter\Model\Prozess;

use Konfigurator\HtmlModul\Popup\PopupEintragAdapter\PopupEintrag;
use Model\Prozess\Item;

class ItemPopupEintrag extends PopupEintrag {

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

