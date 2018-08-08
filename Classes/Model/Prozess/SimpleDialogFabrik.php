<?php

namespace Model\Prozess;

final class SimpleDialogFabrik {

    /**
     * @param string $abmessungDaten
     * @param string $kartenelementId
     * @return Dialog
     */
    public static function erzeugeAbmessung($menueText, $anspracheText, $antwortText, $erfuellungsText, $scheiternText) {
        $dialog = new Dialog();
        $dialog->setMenueText($menueText);
        $dialog->setAnspracheText($anspracheText);
        $dialog->setAntwortText($antwortText);
        $dialog->setErfuellungsText($erfuellungsText);
        $dialog->setScheiternText($scheiternText);
        return $dialog;
    }
}

