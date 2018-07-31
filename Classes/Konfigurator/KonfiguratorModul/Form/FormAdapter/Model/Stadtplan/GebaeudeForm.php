<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselForm;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Gebaeude;

class GebaeudeForm extends OhnePrimaerschluesselForm {

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
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $interieurAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::INTERIEUR_AUSSEHEN,
            TabellenName::INTERIEUR_AUSSEHEN . "." . TabellenName::INTERIEUR_AUSSEHEN . Keyword::URL
        );
        $interieurAussehensInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::AUSWAHLBILD,
            TabellenName::INTERIEUR_AUSSEHEN . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $interieurAussehens,
                SimpleFormInputFabrik::SELECTED => $this->gebaeude->getInterieurAussehen()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Aussehen des Innenraums']
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

