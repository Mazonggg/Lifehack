<?php

namespace Model\Prozess;

final class SimpleDialogFabrik {

    /**
     * @param string $menueText
     * @param string $anspracheText
     * @param string $antwortText
     * @param string $erfuellungsText
     * @param string $scheiternText
     * @return Dialog
     */
    public static function erzeugeDialog($menueText, $anspracheText, $antwortText, $erfuellungsText, $scheiternText) {
        $dialog = new Dialog();
        $dialog->setMenueText($menueText);
        $dialog->setAnspracheText($anspracheText);
        $dialog->setAntwortText($antwortText);
        $dialog->setErfuellungsText($erfuellungsText);
        $dialog->setScheiternText($scheiternText);
        return $dialog;
    }
}

