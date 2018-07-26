<<<<<<< HEAD
const BEARBEITEN = '_bearbeiten';
const LISTE = '_liste';

=======
const ausgeblendet = " ausgeblendet";
const fixiert = " fixiert";
const form_body = "form_body";

class Konfigurator {
    constructor() {
        this.stadtplan = new StadtplanController(document.getElementById("stadtplan"));
        this.form = new FormController(document.getElementById("form_container"));
        this.body = new HtmlObjekt(document.body);
        this.menue = new MenueController(document.getElementById("menue_container"));
    }

    initFunktion() {
        this.form.initFormController();
        this.menue.initMenue();
    }

    getForm() {
        return this.form;
    }

    getStadtplan() {
        return this.stadtplan;
    }

    getBody() {
        return this.body;
    }

    getMenue() {
        return this.menue;
    }
}

class HtmlObjekt {
    constructor(objekt) {
        this.klassenName = objekt.className;
        this.objekt = objekt;
        this.ausgeblendet = false;
        this.fixiert = false;
    }

    ausblenden() {
        this.ausgeblendet = !this.ausgeblendet;
        this.aktualisiereKlassenname();
    }

    fixieren() {
        this.fixiert = !this.fixiert;
        this.aktualisiereKlassenname();
    }

    aktualisiereKlassenname() {
        this.objekt.className = this.klassenName +
            (this.fixiert ? fixiert : "") +
            (this.ausgeblendet ? ausgeblendet : "");
    }
}

class FormController extends HtmlObjekt {
    constructor(objekt) {
        super(objekt);
    }

    initFormController() {
        let form = this;
        document.getElementById("form_abbrechen").addEventListener('click', function () {
            FormController.schliesseForm();
        });
        document.getElementById("form_submit").addEventListener('click', function (event) {
            event.preventDefault();
            FormController.submitForm();
        });
        form.ausblenden();
    }

    static schliesseForm() {
        FormController.leereForm();
        konfigurator.getForm().ausblenden();
        konfigurator.getMenue().ausblenden();
        konfigurator.getBody().fixieren();
        konfigurator.getStadtplan().ausblenden();
    }

    static leereForm() {
        document.getElementById(form_body).innerHTML = "";
    }

    static submitForm() {
        let formDaten =
            FormController.getFormDaten(
                document.getElementById("form_block_main"),
                document.getElementsByClassName("form_block_teilabschnitt")
            );
        if (FormController.formIstVollstaendig()) {
            AjaxHandler.post("form", FormController.getFormDatenAlsJson(formDaten), FormController.schliesseForm);

        } else {
            FormController.zeigeWarnung("Alle Elemente m&uuml;ssen ausgef&uuml;llt sein!");
        }
    }

    // TODO alles pruefen (rekursiv)
    static formIstVollstaendig() {
        let form = document.getElementById("form");
        let formInputs = form.getElementsByClassName("form_input");
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].value === "") {
                return false;
            }
        }
        return true;
    }

    static getFormDaten(form, teilforms) {
        let formDaten = FormController.getFormWerte(form);
        if (teilforms.length > 0) {
            let teilformsKey = FormController.getFormZiel(teilforms[0]);
            let teilformsDaten = [];
            for (let t = 0; t < teilforms.length; t++) {
                teilformsDaten.push(this.getFormWerte(teilforms[t]));
            }
            formDaten[teilformsKey] = teilformsDaten;
        }
        return formDaten;
    }

    static getFormDatenAlsJson(formDaten) {
        return JSON.stringify(formDaten);
    }

    static getFormZiel(formObjekt) {
        return this.getFormWerte(formObjekt)["modus"].split("_")[0];
    }

    static getFormWerte(formObjekt) {
        let formDaten = {};
        let formInputs = formObjekt.getElementsByClassName("form_input");
        for (let i = 0; i < formInputs.length; i++) {
            formDaten[formInputs[i].name] = formInputs[i].value;
        }
        return formDaten;
    }

    // TODO Warnung einfuegen
    static zeigeWarnung(warnung) {
        alert(warnung);
    }

    static platziereNeuButton() {
        let neuButton = document.getElementsByClassName("form_neu_button");
        if (neuButton.length > 0) {
            document.getElementById(form_body).appendChild(neuButton[0]);
            neuButton[0].addEventListener('click', function () {
                AjaxHandler.get(neuButton[0].id, FormController.fuegeTeilaufgabeEin, form_body);
            })
        }
    }

    static setFormInhalt(formBodyId, formInhalt) {
        let form_body = document.getElementById(formBodyId);
        let element = document.createElement("div");
        element.id = "form_block_main";
        element.className = "form_block";
        element.innerHTML = formInhalt;
        form_body.appendChild(element);

        FormController.platziereNeuButton();
    }

    static fuegeTeilaufgabeEin(teilaufgabeInhalt, args) {
        let element = document.createElement("div");
        element.className = "form_block_teilabschnitt form_block";
        element.innerHTML = teilaufgabeInhalt;
        document.getElementById(args).appendChild(element);
        FormController.platziereNeuButton();
    }
}
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2

class MenueController extends HtmlObjekt {
    constructor(objekt) {
        super(objekt);
<<<<<<< HEAD
        this._menueButtons = document.querySelectorAll(`button[id$="${BEARBEITEN}"]`);
    }

    initMenue() {
        for (let i = 0; i < this._menueButtons.length; i++) {
            menue._menueButtons[i].addEventListener('click', function () {
                MenueController.oeffneListe(
                    splitElementIdZuObjekt(menue._menueButtons[i].id),
                    {
                        id: menue._menueButtons[i].id + LISTE,
                        class:
                        "popup" + LISTE,
                        tag_name:
                            "div"
                    }
                );
=======
        this.menueButtons = [
            document.getElementById("aufgabe_speichern"),
            document.getElementById("institut_speichern"),
            document.getElementById("item_speichern")
        ];
    }

    initMenue() {
        for (let i = 0; i < this.menueButtons.length; i++) {
            let menue = this;
            konfigurator.getMenue().menueButtons[i].addEventListener('click', function () {
                konfigurator.getMenue().ausblenden();
                konfigurator.getStadtplan().ausblenden();
                konfigurator.getBody().fixieren();
                konfigurator.getForm().ausblenden();

                MenueController.ladeFormular(menue.menueButtons[i].id, form_body);
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
            });
        }
    }

<<<<<<< HEAD
    static oeffneListe(modus, callbackInfo) {
        popup.oeffnePopup(null);
        popup.addSchliessenCallback(modus, null, callbackInfo);
        AjaxHandler.get(modus, popup.setInhalt, callbackInfo);
    }
}

=======
    static ladeFormular(modus, callbackInfo) {
        AjaxHandler.get(modus, MenueController.setFormular, callbackInfo);
    }

    static setFormular(formInhalt, formBodyId) {
        FormController.setFormInhalt(formBodyId, formInhalt);
    }
}

class StadtplanController extends HtmlObjekt {
    constructor(objekt) {
        super(objekt);
    }
}

const AjaxHandler = {
    get: function (modus, callBack, callbackInfo) {
        let ajaxRequest = 'get.php?modus=' + modus;
        let requestObjekt = new XMLHttpRequest();
        requestObjekt.open('GET', ajaxRequest);
        requestObjekt.onload = function () {
            let antwort = JSON.parse(requestObjekt.responseText);
            callBack(antwort, callbackInfo);
        };
        requestObjekt.send();
    },

    post: function (modus, data, callback) {
        let requestObjekt = new XMLHttpRequest();
        requestObjekt.open('POST', 'post.php?modus=' + modus);

        let formDaten = new FormData();
        formDaten.append("modus", modus);
        formDaten.append("daten", data);

        requestObjekt.onload = function () {
            let antwort = requestObjekt.responseText;
            console.log("POST", antwort);
            callback();
        };
        requestObjekt.send(formDaten);
    }
};

let konfigurator;

window.addEventListener('load', function () {
        konfigurator = new Konfigurator();
        konfigurator.initFunktion();
    }
);

>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
