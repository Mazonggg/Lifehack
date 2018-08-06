<?php

namespace Anwendung\Konfigurator\Popup\EintragAdapter\Model\Einrichtung;

use Anwendung\Konfigurator\Popup\EintragAdapter\EintragAdapter;
use Model\Einrichtung\Institut;

class InstitutEintragAdapter extends EintragAdapter {
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

