<?php

namespace Anwendung\Konfigurator\Form\FormEintrag\Model\Stadtplan;

use Austauschformat\AustauschKonstanten;
use Anwendung\Konfigurator\Form\FormEintrag\Input\IInput;
use Anwendung\Konfigurator\Form\FormEintrag\Input\SimpleInputFabrik;
use Anwendung\Konfigurator\Form\FormEintrag\OhnePrimaerschluesselFormAdapter;
use Model\Konstanten\TabellenName;
use Model\Konstanten\TabellenSpalten;
use Model\Stadtplan\Abmessung;
use Model\Stadtplan\SimpleAbmessungFabrik;

class AbmessungenFormEintragAdapter extends OhnePrimaerschluesselFormAdapter {

    /**
     * @var Abmessung[]
     */
    private $abmessungen;

    /**
     * AbmessungenForm constructor.
     * @param Abmessung[] $abmessungen
     * @param string $modus
     */
    public function __construct($abmessungen, $modus) {
        if (empty($abmessungen)) {
            $abmessungen = [SimpleAbmessungFabrik::erzeugeAbmessung(
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER .
                0 . AustauschKonstanten::ABMESSUNG_TRENNER
            )];
        }
        parent::__construct($abmessungen[0], $modus);
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

