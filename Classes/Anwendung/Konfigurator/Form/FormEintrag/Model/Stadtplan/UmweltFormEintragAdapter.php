<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan;

use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Umwelt;

class UmweltFormEintragAdapter extends OhnePrimaerschluesselFormAdapter {

    /**
     * @var Umwelt $eintrag
     */
    protected $eintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $begehbarInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::BOOLEAN,
            TabellenSpalten::UMWELT_BEGEHBAR,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::SELECTED => $this->eintrag->isBegehbar(),
                SimpleInputFabrik::LABEL => 'Ist das Element begehbar?']
        );
        $bezeichnungInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::TEXT,
            TabellenSpalten::UMWELT_BEZEICHUNG,
            [SimpleInputFabrik::INHALT => $this->eintrag->getBezeichnung(),
                SimpleInputFabrik::LABEL => 'Bezeichnung des Elements']
        );
        return [$begehbarInput, $bezeichnungInput];
    }

    /**
     * @return bool
     */
    public function istTeilForm() {
        return true;
    }

    /**
     * @return bool
     */
    public function hatTitelElement() {
        return false;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::UMWELT;
    }
}

