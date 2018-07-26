<?php

namespace Konfigurator\HtmlModul\Popup\PopupEintragAdapter\Model\Einrichtung;

use Konfigurator\HtmlModul\Popup\PopupEintragAdapter\PopupEintrag;
use Model\Einrichtung\Institut;

class InstitutPopupEintrag extends PopupEintrag {
    /**
     * @var Institut
     */
    private $institut;

    /**
     * InstitutPopupListenEintrag constructor.
     * @param Institut $institut
     */
    public function __construct($institut) {
        parent::__construct($institut);
        $this->institut = $institut;
    }

    /**
     * @return string
     */
    protected function getKurzInfo() {
        return $this->institut->getName();
    }
}

