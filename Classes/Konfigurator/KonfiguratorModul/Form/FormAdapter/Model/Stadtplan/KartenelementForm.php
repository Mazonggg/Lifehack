<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\IKartenelement;

class KartenelementForm extends Form {

    /**
     * @var IKartenelement
     */
    private $kartenelement;

    /**
     * KartenelementForm constructor.
     * @param IKartenelement $kartenelement
     */
    public function __construct($kartenelement) {
        parent::__construct($kartenelement);
        $this->kartenelement = $kartenelement;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $kartenelementArtInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::HIDDEN,
            TabellenName::KARTENELEMENT_ART . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => $this->kartenelement->getKartenelementArt()->getSchluessel(),
                SimpleFormInputFabrik::ID => '']
        );
        $kartenelementAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::KARTENELEMENT_AUSSEHEN,
            TabellenName::KARTENELEMENT_AUSSEHEN . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::URL
        );
        $kartenelementAussehenInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::AUSWAHLBILD,
            TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::REF,
            [SimpleFormInputFabrik::INHALT => '',
                SimpleFormInputFabrik::OPTIONEN => $kartenelementAussehens,
                SimpleFormInputFabrik::SELECTED => $this->kartenelement->getKartenelementAussehen()->getSchluessel(),
                SimpleFormInputFabrik::LABEL => 'Aussehen des Elements']
        );
        return [
            $kartenelementArtInput,
            $kartenelementAussehenInput
        ];
    }

    /**
     * @return bool
     */
    public function istTeilForm() {
        return false;
    }

    /**
     * @return bool
     */
    public function hatTitelElement() {
        return true;
    }

    /**
     * @return string
     */
    public function getTabelle() {
        return TabellenName::KARTENELEMENT;
    }
}

