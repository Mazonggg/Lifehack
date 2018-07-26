<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan;

use Datenbank\DatenbankAbrufHandler;
use Konfigurator\HtmlModul\Form\FormAdapter\Form;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Model\Konstanten\Keyword;
use Model\Konstanten\TabellenName;
use Model\Stadtplan\Gebaeude;

class GebaeudeForm extends Form {

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
     * @return IInputAdapter[]
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

