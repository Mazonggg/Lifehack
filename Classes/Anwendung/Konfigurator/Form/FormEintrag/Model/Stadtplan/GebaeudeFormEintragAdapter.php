<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Gebaeude;

class GebaeudeFormEintragAdapter extends OhnePrimaerschluesselFormAdapter {

    /**
     * @var Gebaeude
     */
    protected $datenbankEintrag;

    /**
     * @return IInput[]
     */
    public function getFormInputs() {
        $interieurAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INTERIEUR_AUSSEHEN,
            TabellenName::INTERIEUR_AUSSEHEN . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::URL
        );
        $interieurAussehensInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::AUSWAHLBILD,
            TabellenName::INTERIEUR_AUSSEHEN . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $interieurAussehens,
                SimpleInputFabrik::SELECTED => $this->datenbankEintrag->getInterieurAussehen()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Aussehen des Innenraums']
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
        return TabellenName::GEBAEUDE;
    }
}

