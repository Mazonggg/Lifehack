<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\Form;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IFormInputAdapter;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleFormInputFabrik;
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
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER
            )];
        }
        parent::__construct($abmessungen[0]);
        $this->abmessungen = $abmessungen;
    }

    /**
     * @return IFormInputAdapter[]
     */
    public function getFormInputs() {
        $positionAuswahlInput = SimpleFormInputFabrik::erzeugeFormInput(
            SimpleFormInputFabrik::AUSWAHL_BUTTON,
            TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG,
            [SimpleFormInputFabrik::INHALT => 'Position ausw&auml;hlen',
                SimpleFormInputFabrik::ID => TabellenSpalten::ABMESSUNG_WELT_ABMESSUNG,
                SimpleFormInputFabrik::WERT => $this->abmessungen[0]]
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

