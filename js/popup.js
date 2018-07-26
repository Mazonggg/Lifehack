const ID = 'id';
const LOESCHEN = 'loeschen';
const AKTUALISIEREN = "aktualisieren";
const POPUP_BODY = 'popup_body';
const POPUP_CONTAINER = 'popup_container';
const DISPLAY_NONE = 'display_none';


class PopupController extends HtmlObjekt {

    popSchliessenCallbackInfo() {
        return {
            modus: this._schliessenCallbackModus.pop(),
            callback: this._schliessenCallbacks.pop(),
            callbackInfo: this._schliessenCallbackInfos.pop()
        };
    }

    addSchliessenCallback(modus, callback, callbackInfo) {
        this._schliessenCallbackModus.push(modus);
        this._schliessenCallbacks.push(callback);
        this._schliessenCallbackInfos.push(callbackInfo);
    }

    schliessenCallbackVorhanden() {
        return this._schliessenCallbackModus.length > 0;
    }

    constructor(objekt) {
        super(objekt);
        this._schliesser = document.getElementById("popup_schliesser");
        this._schliessenCallbackModus = [];
        this._schliessenCallbacks = [];
        this._schliessenCallbackInfos = [];
    }

    initPopup() {
        this.ausOderEinblenden(true);
        this._schliesser.addEventListener('click', function () {
            popup.schliessePopup();
        });
    }

    schliessenCallback() {
        let callback = popup.popSchliessenCallbackInfo();
        AjaxHandler.get(
            callback['modus'],
            (callback['callback'] == null ? popup.setInhalt : callback['callback']),
            callback['callbackInfo']
        );
    }

    versteckePopup(verstecken) {
        if (verstecken) {
            popup.objekt.className += ' ' + DISPLAY_NONE;
        } else {
            popup.objekt.className = popup.objekt.className.replace(' ' + DISPLAY_NONE, '');
        }
        body.fixieren(!verstecken);
        stadtplan.overLayAusOderEinblenden(!verstecken);
    }

    oeffnePopup() {
        popup.leerePopup();
        menue.ausOderEinblenden(true);
        stadtplan.ausOderEinblenden(true);
        stadtplan.overLayAusOderEinblenden(true);
        body.fixieren(true);
        popup.ausOderEinblenden(false);
    }

    schliessePopup() {
        if (!popup.schliessenCallbackVorhanden()) {

            popup.loeschenCallbackModus = [];
            popup.loeschenCallbackInfo = [];

            menue.ausOderEinblenden(false);
            stadtplan.ausOderEinblenden(false);
            stadtplan.overLayAusOderEinblenden(false);
            body.fixieren(false);
            popup.ausOderEinblenden(true);
        } else {
            popup.schliessenCallback();
        }
    }

    leerePopup() {
        if (document.getElementById(POPUP_BODY) != null) {
            document.getElementById(POPUP_BODY).parentElement.removeChild(document.getElementById(POPUP_BODY));
        }
        document.getElementById("popup_titel").innerHTML = "";
    }

    setInhalt(elementInhalt, divInfo) {
        popup.leerePopup();
        let element = document.createElement('div');
        element.id = POPUP_BODY;

        element.innerHTML = elementInhalt;
        document.getElementById(POPUP_CONTAINER).appendChild(element);
        let titelTeile = splitElementIdZuObjekt(divInfo[ID]);
        document.getElementById("popup_titel").innerHTML = ucfirst(titelTeile[TABELLE] + " " + titelTeile[MODUS]);
        popup.initPopupButtons();
    }

    initPopupButtons() {
        popup.initAktualisierenButtons();
        popup.initNeuButton();
    }

    initAktualisierenButtons() {
        let bearbeitenButtons = document.getElementById(POPUP_BODY).querySelectorAll(`button[id*="_${AKTUALISIEREN}-"]`);
        for (let i = 0; i < bearbeitenButtons.length; i++) {
            let buttonId = bearbeitenButtons[i].id;
            bearbeitenButtons[i].addEventListener('click', function () {
                popup.leerePopup();
                AjaxHandler.get(splitElementIdZuObjekt(buttonId), form.setForm, buttonId);
            });
        }
    }

    initNeuButton() {
        let neuButtons = document.getElementById(POPUP_BODY).querySelectorAll(`button[id*="_${ERSTELLEN}"]`);
        if (neuButtons.length > 0) {
            neuButtons[0].addEventListener('click', function () {
                popup.leerePopup();
                AjaxHandler.get(splitElementIdZuObjekt(neuButtons[0].id), form.setForm, "form");
            });
        }
    }
}

