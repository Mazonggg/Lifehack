const FORM_BODY_WRAPPER = "form_body_wrapper";
const FORM_BODY = "form_body";
const FORM_BODY_TEILABSCHNITT = "form_body_teilabschnitt";
const FORM_BODY_AUSBLENDBUTTON = "form_body_ausblendbutton";
const LOESCHEN_BUTTON = "loeschen_button";
const ENTFERNEN_BUTTON = "entfernen_button";
const FORM_BODY_CONTENT = "form_body_content";
const GELOESCHT = "geloescht";
const ERSTELLEN = "erstellen";
const AUSWAHLBILD_BUTTON = 'auswahlbild_button';

const MODUS = "modus";
const TABELLE = "tabelle";

let teilschirttZaehler = 0;

let neuButtonFunktion = function (event) {
    event.preventDefault();
    AjaxHandler.get({
        tabelle: document.getElementById("form_neu_button").name,
        modus: ERSTELLEN,
        id: teilschirttZaehler
    }, FormController.fuegeTeilschrittEin, [FORM_BODY_WRAPPER, teilschirttZaehler++]);
};

class FormController {

    constructor() {
    }

    submitForm() {
        let formDaten =
            FormController.getFormDaten(
                document.getElementsByClassName(FORM_BODY)[0],
                document.getElementsByClassName(FORM_BODY_TEILABSCHNITT)
            );
        if (FormController.istFormVollstaendig()) {
            AjaxHandler.post(
                formDaten,
                popup.schliessePopup);
        } else {
            this._formWarnung.ausOderEinblenden(false);
        }
    }

    static istFormVollstaendig() {
        let formInputs = document.getElementsByClassName("form_input");
        let vollstaendig = true;
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].value === "") {
                vollstaendig = false;
                formInputs[i].className += " warnung";
            } else {
                formInputs[i].className = formInputs[i].className.replace(" warnung", "");
            }
        }
        return vollstaendig;
    }

    static getFormDaten(form, teilforms) {
        let formDaten = FormController.getFormWerte(form);
        if (teilforms.length > 0) {
            let teilformDaten = [];
            for (let t = 0; t < teilforms.length; t++) {
                let teilFormWerte = FormController.getFormWerte(teilforms[t]);
                teilformDaten.push(teilFormWerte);
            }
            formDaten["teilforms"] = teilformDaten;
        }
        return formDaten;
    }

    static getFormWerte(formObjekt) {
        let modusInput = formObjekt.querySelectorAll(`input[name^="${MODUS}"]`)[0];
        let formDaten = splitElementIdZuObjekt(modusInput.value);
        let formInputs = formObjekt.getElementsByClassName("form_input");
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].name.indexOf(MODUS) < 0) {
                formDaten[formInputs[i].name] = formInputs[i].value;
            }
        }
        return formDaten;
    }

    setForm(formInhalt, formBodyId) {
        popup.setInhalt(formInhalt, {
            id: formBodyId,
            class: "form",
            tag_name: "form"
        });
        form.setFormWarnung();
        form._formWarnung.ausOderEinblenden(true);
        FormController.platziereNeuButton();
        document.getElementById("form_submit").addEventListener('click', function (event) {
            event.preventDefault();
            form.submitForm();
        });
        let ausblendButtons = document.querySelectorAll(`button[id^="${FORM_BODY_AUSBLENDBUTTON}"]`);
        for (let i = 0; i < ausblendButtons.length; i++) {
            form.initWechselButton(ausblendButtons[i], AUSGEBLENDET, FORM_BODY_CONTENT);
            if (i > 0) {
                ausblendButtons[i].click();
            }
        }
        let loeschenButtons = document.querySelectorAll(`button[id^="${LOESCHEN_BUTTON}"]`);
        for (let i = 0; i < loeschenButtons.length; i++) {
            form.initWechselButton(loeschenButtons[i], GELOESCHT, FORM_BODY);
        }
        let endgueltigLoeschenButtons = document.querySelectorAll(`button[id^="${ENTFERNEN_BUTTON}"]`);
        for (let i = 0; i < endgueltigLoeschenButtons.length; i++) {
            form.initEndgueltigLoeschenButton(endgueltigLoeschenButtons[i], GELOESCHT, FORM_BODY);
        }

    }

    setFormWarnung() {
        this._formWarnung = new HtmlObjekt(document.getElementById("form_warnung"));
    }

    static fuegeTeilschrittEin(teilaufgabeInhalt, daten) {
        let element = document.createElement("div");
        element.innerHTML = teilaufgabeInhalt;

        document.getElementById(daten[0]).appendChild(element);
        FormController.platziereNeuButton();

        let ausblendButtons = document.querySelectorAll(`button[id^="${FORM_BODY_AUSBLENDBUTTON}"]`);
        form.initWechselButton(ausblendButtons[ausblendButtons.length - 1], AUSGEBLENDET, FORM_BODY_CONTENT);
        let loeschenButtons = document.querySelectorAll(`button[id^="${LOESCHEN_BUTTON}"]`);
        form.initWechselButton(loeschenButtons[loeschenButtons.length - 1], GELOESCHT, FORM_BODY);
        let endgueltigLoeschenButtons = document.querySelectorAll(`button[id^="${ENTFERNEN_BUTTON}"]`);
        form.initEndgueltigLoeschenButton(endgueltigLoeschenButtons[endgueltigLoeschenButtons.length - 1]);
    }

    static platziereNeuButton() {
        let neuButton = document.getElementById("form_neu_button");
        if (neuButton != null) {
            neuButton.removeEventListener('click', neuButtonFunktion);
            neuButton.addEventListener('click', neuButtonFunktion);
            document.getElementById(FORM_BODY_WRAPPER).appendChild(neuButton.parentElement);
        }
    }

    initWechselButton(ausblendButton, wechselKlasse, zielObjektSchluessel) {
        let formBodyContentId = zielObjektSchluessel + "_" + letztenTeilDerId(ausblendButton.id);
        let formBodyContent = document.getElementById(formBodyContentId);
        ausblendButton.addEventListener('click', function (event) {
            event.preventDefault();
            if (formBodyContent.className.indexOf(wechselKlasse) === -1) {
                formBodyContent.className += ' ' + wechselKlasse;
                ausblendButton.className += ' ' + wechselKlasse
            } else {
                formBodyContent.className = formBodyContent.className.replace(` ${wechselKlasse}`, '');
                ausblendButton.className = ausblendButton.className.replace(` ${wechselKlasse}`, '');
            }
        });
    }

    initEndgueltigLoeschenButton(endgueltigLoeschenButton) {
        endgueltigLoeschenButton.addEventListener('click', function (event) {
            event.preventDefault();
            let teilschrittId = letztenTeilDerId(endgueltigLoeschenButton.id);
            let formBody = document.getElementById(FORM_BODY + "_" + teilschrittId);
            console.log(formBody);
            console.log(teilschrittId);
            if (formBody.className.indexOf(FORM_BODY_TEILABSCHNITT) < 0) {
                let modusIdObjekt = splitElementIdZuObjekt(document.getElementsByName(MODUS)[0].id);
                AjaxHandler.post({
                        tabelle: modusIdObjekt[TABELLE],
                        modus: LOESCHEN,
                        id: modusIdObjekt[ID]
                    },
                    popup.schliessePopup);
            } else if (FormController.istNeuerTeilschritt(teilschrittId)) {
                let formBodyWrapper = document.getElementById(FORM_BODY_WRAPPER);
                formBodyWrapper.removeChild(formBody);
            } else {
                let formBodyContent = document.getElementById(FORM_BODY_CONTENT + "_" + teilschrittId);
                let idTeile = teilschrittId.split("-");
                let modusInput = document.getElementById(idTeile[0] + "_" + MODUS + "-" + idTeile[1]);
                FormController.entferneInhalt(formBodyContent);
                modusInput.value = idTeile[0] + "_" + LOESCHEN + "-" + idTeile[1];
                formBodyContent.appendChild(modusInput);
                formBody.className += " " + HIDDEN;
            }
        });
    }

    static istNeuerTeilschritt(teilschrittId) {
        return teilschrittId.split("-")[1] === HINZUFUEGEN;
    }

    static entferneInhalt(formBodyContent) {
        while (formBodyContent.firstChild) {
            formBodyContent.removeChild(formBodyContent.firstChild);
        }
    }
}

