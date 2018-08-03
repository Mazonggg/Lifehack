const AjaxHandler = {
    get: function (daten, callBack, callbackInfo) {
        let ajaxRequest = 'get.php?';
        for (let key in daten) {
            if (daten.hasOwnProperty(key)) {
                ajaxRequest += key + "=" + daten[key] + "&";
            }
        }
        let requestObjekt = new XMLHttpRequest();
        requestObjekt.open('GET', ajaxRequest);
        requestObjekt.onload = function () {
            let antwort = JSON.parse(requestObjekt.responseText);
            callBack(antwort, callbackInfo);
        };
        requestObjekt.send();
    },

    post: function (data, callback) {
        let requestObjekt = new XMLHttpRequest();
        requestObjekt.open('POST', 'post.php?');

        let formDaten = new FormData();
        formDaten.append("daten", JSON.stringify(data));

        requestObjekt.onload = function () {
            let antwort = requestObjekt.responseText;
            if (antwort.length > 0) {
                console.log(antwort);
            }
            callback(antwort);
        };
        requestObjekt.send(formDaten);
    }
};

class HtmlObjekt {
    constructor(objekt) {
        this.objekt = objekt;
        this.ausgeblendet = false;
        this.fixiert = false;
        this.hidden = false;
        this.display = false;
        this.klassenName = this.objekt.className;
    }

    ausOderEinblenden(ausblenden) {
        this.ausgeblendet = ausblenden;
        this.aktualisiereKlassenname();
    }

    fixieren(fixieren) {
        this.fixiert = fixieren;
        this.aktualisiereKlassenname();
    }

    hide(hidden) {
        this.hidden = hidden;
        this.aktualisiereKlassenname();
    }

    displayNone(none) {
        this.display = none;
        this.aktualisiereKlassenname();
    }

    aktualisiereKlassenname() {
        this.objekt.className = this.klassenName +
            (this.fixiert ? ' ' + FIXIERT : "") +
            (this.ausgeblendet ? ' ' + AUSGEBLENDET : "") +
            (this.hidden ? ' ' + HIDDEN : "") +
            (this.display ? ' ' + DISPLAY : "");
    }
}

let ucfirst = function (zeichenkette) {
    return zeichenkette.substring(0, 1).toUpperCase() + zeichenkette.substring(1, zeichenkette.length);
};

let lcfirst = function (zeichenkette) {
    return zeichenkette.substring(0, 1).toLowerCase() + zeichenkette.substring(1, zeichenkette.length);
};

let letztenTeilDerId = function (id) {
    let teile = id.split("_");
    return teile[teile.length - 1];
};

let splitElementIdZuObjekt = function (elementId) {
    let idTeil = elementId.split(/[_|-]/);
    return {
        tabelle: (idTeil[0] ? idTeil[0] : ""),
        modus: (idTeil[1] ? idTeil[1] : ""),
        id: (idTeil[2] ? idTeil[2] : "")
    };
};

const AUSGEBLENDET = "ausgeblendet";
const FIXIERT = "fixiert";
const HINZUFUEGEN = "hinzufuegen";
const HIDDEN = "hidden";
const DISPLAY = " display_none";


class Konfigurator {
    constructor() {
        popup = new PopupController(document.getElementById("popup_container"));
        stadtplan = new StadtplanController(document.getElementById("stadtplan_container"));
        form = new FormController();
        body = new HtmlObjekt(document.body);
        menue = new MenueController(document.getElementById("menue_container"));
    }

    initFunktion() {
        popup.initPopup();
        stadtplan.initStadtplan();
        menue.initMenue();
    }
}

let konfigurator;
let stadtplan;
let menue;
let popup;
let body;
let form;

window.addEventListener('load', function () {
    konfigurator = new Konfigurator();
    konfigurator.initFunktion();
});

