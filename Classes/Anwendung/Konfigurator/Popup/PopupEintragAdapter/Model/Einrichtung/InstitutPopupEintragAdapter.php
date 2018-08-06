<?php

namespace Anwendung\Konfigurator\Popup\PopupEintragAdapter\Model\Einrichtung;

use Anwendung\Konfigurator\Popup\PopupEintragAdapter\PopupEintragAdapter;
use Model\Einrichtung\Institut;

class InstitutPopupEintragAdapter extends PopupEintragAdapter {
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

