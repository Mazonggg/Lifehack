<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\MitPrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\IKartenelement;

class KartenelementFormEintragAdapter extends MitPrimaerschluesselFormAdapter {

    /**
     * @var IKartenelement
     */
    private $kartenelement;

    /**
     * KartenelementForm constructor.
     * @param IKartenelement $kartenelement
     * @param string $modus
     */
    public function __construct($kartenelement, $modus) {
        parent::__construct($kartenelement, $modus);
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
