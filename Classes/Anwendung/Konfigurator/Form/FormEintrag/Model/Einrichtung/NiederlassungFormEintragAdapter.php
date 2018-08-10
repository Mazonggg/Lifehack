<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Niederlassung;

class NiederlassungFormEintragAdapter extends OhnePrimaerschluesselFormAdapter {

    /**
     * @var Niederlassung
     */
    protected $datenbankEintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $interieurAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INSTITUT,
            TabellenName::INSTITUT . "." . TabellenName::INSTITUT . Keyword::NAME
        );
        $interieurAussehensInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::SELECT,
            TabellenName::NIEDERLASSUNG . '_' . TabellenName::INSTITUT . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $interieurAussehens,
                SimpleInputFabrik::SELECTED => $this->datenbankEintrag->getInstitut()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Geh&ouml;rt zu Einrichtung']
        );
        return [$interieurAussehensInput];
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
        return TabellenName::NIEDERLASSUNG;
    }
}

