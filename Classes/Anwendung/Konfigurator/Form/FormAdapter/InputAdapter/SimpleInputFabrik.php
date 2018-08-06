<?php

namespace Anwendung\Konfigurator\Form\FormAdapter\InputAdapter;


class SimpleInputFabrik {

    const TEXT = "text";
    const NUMBER = "number";
    const TEXTAREA = "textarea";
    const SELECT = "select";
    const BOOLEAN = "boolean";
    const HIDDEN = 'hidden';
    const AUSWAHLBILD = 'auswahlbild';
    const AUSWAHL_BUTTON = 'auswahl_button';
    const WERT = 'wert';


    const INHALT = 'inhalt';
    const OPTIONEN = 'optionen';
    const SELECTED = 'selected';
    const LABEL = 'label';
    const NEUBUTTON = 'button';

    const MIN = 'min';
    const MAX = 'max';
    const ID = 'id';

    /**
     * @param string $type
     * @param string $name
     * @param array $daten
     * @return IInput
     */
    public static function erzeugeFormInput($type, $name, $daten) {
        if ($type == self::NUMBER) {
            $formInput = new NumberInputAdapter($name, $daten[self::INHALT]);
            $formInput->setMin($daten[self::MIN]);
            $formInput->setMax($daten[self::MAX]);
            $formInput->setLabel($daten[self::LABEL]);
        } elseif ($type == self::TEXTAREA) {
            $formInput = new TextareaInputAdapter($name, $daten[self::INHALT]);
        } elseif ($type == self::SELECT) {
            $formInput = new SelectInputAdapter($name, $daten[self::INHALT]);
            $formInput->setOptionen($daten[self::OPTIONEN]);
            $formInput->setSelected($daten[self::SELECTED]);
            $formInput->setLabel($daten[self::LABEL]);
        } elseif ($type == self::AUSWAHLBILD) {
            $formInput = new AuswahlbildInputAdapter($name, $daten[self::INHALT]);
            $formInput->setOptionen($daten[self::OPTIONEN]);
            $formInput->setSelected($daten[self::SELECTED]);
            $formInput->setLabel($daten[self::LABEL]);
        } elseif ($type == self::BOOLEAN) {
            $formInput = new BooleanInputAdapter($name, $daten[self::INHALT]);
            $formInput->setSelected($daten[self::SELECTED]);
            $formInput->setLabel($daten[self::LABEL]);
        } elseif ($type == self::NEUBUTTON) {
            $formInput = new NeuButtonInputAdapter($name, $daten[self::INHALT]);
            $formInput->setId($daten[self::ID]);
        } elseif ($type == self::HIDDEN) {
            $formInput = new HiddenInputAdapter($name, $daten[self::INHALT]);
            $formInput->setId($daten[self::ID]);
        } elseif ($type == self::AUSWAHL_BUTTON) {
            $formInput = new AuswahlButtonInputAdapter($name, $daten[self::INHALT]);
            $formInput->setWert($daten[self::WERT]);
            $formInput->setId($daten[self::ID]);
        } else {
            $formInput = new TextInputAdapter($name, $daten[self::INHALT]);
        }
        return $formInput;
    }
}

