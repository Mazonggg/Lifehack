<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\IKartenelement;

class KartenelementFormAdapter extends MitPrimaerschluesselFormAdapter {

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
     * @return IInput[]
     */
    public function getFormInputs() {
        $kartenelementArtInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::HIDDEN,
            TabellenName::KARTENELEMENT_ART . Keyword::REF,
            [SimpleInputFabrik::INHALT => $this->kartenelement->getKartenelementArt()->getSchluessel(),
                SimpleInputFabrik::ID => '']
        );
        $kartenelementAussehens = DatenbankAbrufHandler::Instance()->findSpalteZuId(
            TabellenName::KARTENELEMENT_AUSSEHEN,
            TabellenName::KARTENELEMENT_AUSSEHEN . "." . TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::URL
        );
        $kartenelementAussehenInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::AUSWAHLBILD,
            TabellenName::KARTENELEMENT_AUSSEHEN . Keyword::REF,
            [SimpleInputFabrik::INHALT => '',
                SimpleInputFabrik::OPTIONEN => $kartenelementAussehens,
                SimpleInputFabrik::SELECTED => $this->kartenelement->getKartenelementAussehen()->getSchluessel(),
                SimpleInputFabrik::LABEL => 'Aussehen des Elements']
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

