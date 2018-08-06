<?php

namespace Konfigurator\KonfiguratorModul\Form\FormAdapter\Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\IInput;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\InputAdapter\SimpleInputFabrik;
use Konfigurator\KonfiguratorModul\Form\FormAdapter\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\SimpleAbmessungFabrik;

class AbmessungenFormAdapter extends OhnePrimaerschluesselFormAdapter {

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
     * @return IInput[]
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

