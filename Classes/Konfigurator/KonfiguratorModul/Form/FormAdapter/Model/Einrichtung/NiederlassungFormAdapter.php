<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Einrichtung;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Einrichtung\Niederlassung;

class NiederlassungFormAdapter extends OhnePrimaerschluesselFormAdapter {
    /**
     * @var Niederlassung
     */
    private $niederlassung;

    /**
     * NiederlassungFormAdapter constructor.
     * @param Niederlassung $niederlassung
     */
    public function __construct($niederlassung) {
        parent::__construct($niederlassung);
        $this->niederlassung = $niederlassung;
    }

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
                SimpleInputFabrik::SELECTED => $this->niederlassung->getInstitut()->getSchluessel(),
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

