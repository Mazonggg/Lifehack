<?php

namespace Model\Stadtplan;

use Model\IDatenbankEintrag;
use Model\Wertepaar;

interface IKartenelement extends IDatenbankEintrag {

    /**
     * @return Abmessung[]
     */
    public function getAbmessungen();

    /**
     * @return Wertepaar
     */
    public function getKartenelementAussehen();

    /**
     * @return Wertepaar
     */
    public function getKartenelementArt();
}

