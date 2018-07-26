<?php

namespace Konfigurator\HtmlModul\Form\FormAdapter\Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Konfigurator\HtmlModul\Form\FormAdapter\Form;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\IInputAdapter;
use Konfigurator\HtmlModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\SimpleAbmessungFabrik;

class AbmessungenForm extends Form {

    /**
     * @var Abmessung[]
     */
    private $abmessungen;

    /**
     * AbmessungenForm constructor.
     * @param Abmessung[] $abmessungen
     */
    public function __construct($abmessungen) {
        if (empty($abmessungen)) {
            $abmessungen = [SimpleAbmessungFabrik::erzeugeAbmessung(
                0 . AustauschKonstanten::POSITIONS_TRENNER .
                0 . AustauschKonstanten::POSITIONS_TRENNER .
                0 . AustauschKonstanten::POSITIONS_TRENNER .
                0 . AustauschKonstanten::POSITIONS_TRENNER
            )];
        }
        parent::__construct($abmessungen[0]);
        $this->abmessungen = $abmessungen;
    }

    /**
     * @return IInputAdapter[]
     */
    public function getFormInputs() {
        $positionAuswahlInput = SimpleInputFabrik::erzeugeFormInput(
            SimpleInputFabrik::AUSWAHL_BUTTON,
            TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG,
            [SimpleInputFabrik::INHALT => 'Position ausw&auml;hlen',
                SimpleInputFabrik::ID => TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG,
                SimpleInputFabrik::WERT => $this->abmessungen[0]]
        );
        return [$positionAuswahlInput];
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
        return TabellenName::ABMESSUNG;
    }

    public function getId() {
        return 'form_body_' . TabellenName::KARTENELEMENT . "-" . $this->abmessungen[0]->getKartenelementId();
    }
}

