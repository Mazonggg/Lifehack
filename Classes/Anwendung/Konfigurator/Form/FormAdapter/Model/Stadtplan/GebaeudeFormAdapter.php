<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\IInput;
use Anwendung\Konfigurator\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormAdapter\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Gebaeude;

class GebaeudeFormAdapter extends OhnePrimaerschluesselFormAdapter {

    /**
     * @var Gebaeude
     */
    private $gebaeude;

    /**
     * GebaeudeFormAdapter constructor.
     * @param Gebaeude $gebaeude
     */
    public function __construct($gebaeude) {
        parent::__construct($gebaeude);
        $this->gebaeude = $gebaeude;
    }

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
                SimpleInputFabrik::SELECTED => $this->gebaeude->getInterieurAussehen()->getSchluessel(),
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

