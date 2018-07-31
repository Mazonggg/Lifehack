const STADTPLAN = 'stadtplan';
const STADTPLAN_CONTAINER = "stadtplan_container";
const KARTENELEMENT = "kartenelement";
const KACHEL = "kachel";
const AKTIV = "aktiv";

class StadtplanController extends HtmlObjekt {

    get kartenelemente() {
        return this._kartenelemente;
    }

    get menue() {
        return this._menue;
    }

    get aktiv() {
        return this._aktiv;
    }

    get grid_breite() {
        return this._grid_breite;
    }

    get grid_hoehe() {
        return this._grid_hoehe;
    }

    get aktivesKachelement() {
        return this._aktivesKachelement;
    }

    set aktivesKachelement(value) {
        this._aktivesKachelement = value;
        let kachelementName = value.name;
        let kachelementeMitName = document.getElementsByName(kachelementName);
        for (let i = 0; i < kachelementeMitName.length; i++) {
            if (kachelementeMitName[i].className.indexOf(AKTIV) >= 0) {
                kachelementeMitName[i].className = kachelementeMitName[i].className.replace(' ' + AKTIV, '');
            } else {
                kachelementeMitName[i].className += ' ' + AKTIV;
            }
        }
    }

    constructor(objekt) {
        super(objekt);
    }

    set aktiv(value) {
        this._aktiv = value;
        let container = document.getElementById(STADTPLAN_CONTAINER);
        if (container.className.indexOf(AKTIV) < 0) {
            container.className += " " + AKTIV;
        } else {
            container.className = container.className.replace(AKTIV, "");
        }
    }

    overLayAusOderEinblenden(ausblenden) {
        this._overlay.ausOderEinblenden(ausblenden);
        if (ausblenden) {
            this._overlay.objekt.className += " halbtransparent";
        }
    }

    initStadtplan() {
        this._overlay = new HtmlObjekt(document.getElementById("stadtplan_overlay"));
        this._menue = new HtmlObjekt(document.getElementById("stadtplan_menue"));
        this._aktiv = false;
        this._kartenelemente = document.querySelectorAll(`button[class*="${KARTENELEMENT}"]`);
        this._grid_breite = document.getElementById('stadtplan').style.gridTemplateColumns.split("px ").length;
        this._grid_hoehe = document.getElementById('stadtplan').style.gridTemplateRows.split("px ").length;
        if (this.grid_breite <= 1 || this.grid_hoehe <= 1) {
            let columns = document.getElementById('stadtplan').style.gridTemplateColumns.replace('repeat(', '');
            this._grid_breite = columns.substr(0, columns.indexOf(','));
            let rows = document.getElementById('stadtplan').style.gridTemplateRows.replace('repeat(', '');
            this._grid_hoehe = rows.substr(0, rows.indexOf(','));
        }
        this._aktivesKachelement = null;

        for (let i = 0; i < stadtplan.kartenelemente.length; i++) {
            stadtplan.kartenelemente[i].addEventListener('click', function (event) {
                event.preventDefault();
                if (document.getElementById(STADTPLAN_CONTAINER).className.indexOf(AUSGEBLENDET) < 0) {
                    popup.oeffnePopup();
                    popup.addSchliessenCallback({modus: 'stadtplan'}, stadtplan.ladeStadtPlanNeu, '');
                    AjaxHandler.get(splitElementIdZuObjekt(
                        stadtplan.kartenelemente[i].name),
                        stadtplan.initStadtplanForm,
                        [stadtplan.kartenelemente[i].name, false]);
                    stadtplan.aktivesKachelement = stadtplan.kartenelemente[i];
                }
            });
        }
        let hinzuButtons = stadtplan.menue.objekt.querySelectorAll(`button[id$="${ERSTELLEN}"]`);
        for (let j = 0; j < hinzuButtons.length; j++) {
            hinzuButtons[j].addEventListener('click', function (event) {
                event.preventDefault();
                popup.oeffnePopup();
                popup.addSchliessenCallback({modus: 'stadtplan'}, stadtplan.ladeStadtPlanNeu, '');
                AjaxHandler.get(splitElementIdZuObjekt(hinzuButtons[j].id), stadtplan.initStadtplanForm, ["form", true]);
                stadtplan.macheHinzufuegenKachelAktiv();
            });
        }
    }

    macheHinzufuegenKachelAktiv() {
        let hinzufuegenKachel = document.getElementById(KARTENELEMENT + '_' + HINZUFUEGEN);
        hinzufuegenKachel.className = hinzufuegenKachel.className.replace(AUSGEBLENDET, '');
        stadtplan.aktivesKachelement = hinzufuegenKachel;
    }

    initStadtplanForm(formInhalt, info) {

        form.setForm(formInhalt, info[0]);
        let abmessungButton = document.getElementById('welt_abmessung_auswahl_button');
        let modusInputs = document.getElementsByName(MODUS);
        if (modusInputs.length > 0) {
            let buttonFunktion = function (event) {
                event.preventDefault();
                stadtplan.aktiviereStadtplanModus();
            }
            abmessungButton.addEventListener('click', buttonFunktion);
        }
        let auswahlbildButtons = document.querySelectorAll(`button[id$="${AUSWAHLBILD_BUTTON}"]`);
        for (let i = 0; i < auswahlbildButtons.length; i++) {
            stadtplan.initAuswahlbildButton(auswahlbildButtons[i], i === 0, info[1]);
        }
    }

    initAuswahlbildButton(auswahlbildButton, ruftNeuplatzierungAuf, automatischAusgeloest) {
        auswahlbildButton.addEventListener('click', function (event) {
            event.preventDefault();
            stadtplan.zeigeAuswahlbildMenue(auswahlbildButton.previousElementSibling, ruftNeuplatzierungAuf);
        });
        if (automatischAusgeloest && ruftNeuplatzierungAuf) {
            auswahlbildButton.click();
        }
    }

    zeigeAuswahlbildMenue(selectElement, ruftNeuplatzierungAuf) {
        let overlay = document.createElement('div');
        overlay.className = 'overlay';
        let overlayContainer = document.createElement('div');
        overlayContainer.className = 'overlay_container';
        overlay.appendChild(overlayContainer);
        for (let i = 0; i < selectElement.options.length; i++) {
            if (!selectElement.options[i].hasAttribute('hidden')) {
                let img = document.createElement('img');
                let imgUrl = 'img/' + lcfirst(selectElement.options[i].innerHTML.replace(' ', '_'));
                img.src = imgUrl;
                img.id = 'overlay_img_' + selectElement.options[i].value;
                img.className = 'overlay_img';
                let imgBeschreibung = document.createElement('p');
                imgBeschreibung.innerHTML = selectElement.options[i].innerHTML.split('.')[0];
                let imgButton = document.createElement('button');
                imgButton.id = 'overlay_img_button_' + selectElement.options[i].value;
                imgButton.className = 'overlay_img_button hoverbox';
                imgButton.appendChild(img);
                imgButton.appendChild(imgBeschreibung);
                imgButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    for (let j = 0; j < selectElement.options; j++) {
                        selectElement.options[j].selected = false;
                    }
                    selectElement.options[i].selected = true;
                    selectElement.nextElementSibling.firstElementChild.src = imgUrl;
                    document.body.removeChild(overlay);
                    if (ruftNeuplatzierungAuf) {
                        stadtplan.aktualisiereAktivesKartenelement(imgUrl);
                    }
                });
                overlayContainer.appendChild(imgButton);
            }
        }
        document.body.appendChild(overlay);
    }

    aktualisiereAktivesKartenelement(imgUrl) {
        let imgObjekt = new Image();
        imgObjekt.src = imgUrl;
        let gridColumn = stadtplan.aktivesKachelement.style.gridColumn.split(' ')[0] + ' / span ' + imgObjekt.width / 25;
        let gridRow = stadtplan.aktivesKachelement.style.gridRow.split(' ')[0] + ' / span ' + imgObjekt.height / 25;
        stadtplan.aktivesKachelement.style.gridColumn = gridColumn;
        stadtplan.aktivesKachelement.style.gridRow = gridRow;
        stadtplan.aktivesKachelement.style.backgroundImage = 'url(' + imgUrl + ')';
        stadtplan.aktiviereStadtplanModus(this.aktivesKachelement);
    }

    getOverlay() {
        return this._overlay;
    }

    aktiviereStadtplanModus() {
        popup.versteckePopup(true);
        stadtplan.ausOderEinblenden(true);
        stadtplan.aktiv = true;

        stadtplan.platziereElement();
    }

    deaktiviereStadtplanModus() {
        popup.versteckePopup(false);
        stadtplan.ausOderEinblenden(false);
        stadtplan.aktiv = false;
    }

    platziereElement() {
        let zielKachel = stadtplan.aktivesKachelement;
        let column_alt = zielKachel.style.gridColumn.split(' ');
        let row_alt = zielKachel.style.gridRow.split(' ');
        let column_neu = column_alt[0];
        let row_neu = row_alt[0];

        document.body.onmousemove = function (event) {
            if (stadtplan.aktiv) {
                let column = parseInt((document.body.scrollLeft + event.clientX) / 25) + 1;
                let row = parseInt((document.body.scrollTop + event.clientY) / 25) + 1;
                column_neu = stadtplan.berechneElementGrid(column, stadtplan.grid_breite, column_alt[column_alt.length - 1]);
                row_neu = stadtplan.berechneElementGrid(row, stadtplan.grid_hoehe, row_alt[row_alt.length - 1]);
                zielKachel.style.gridColumn = column_neu;
                zielKachel.style.gridRow = row_neu;
            }
        };
        let bestaetigung = function (event) {
            if (!stadtplan.gridBereitsBesetzt(column_neu, row_neu)) {
                event.preventDefault();
                stadtplan.deaktiviereStadtplanModus();
                stadtplan.weiseNeuePletzierungZu(zielKachel);
                zielKachel.removeEventListener('click', bestaetigung);
            } else {
                alert("Die gewählten Kacheln dürfen nicht besetzt sein!");
            }
        };
        zielKachel.addEventListener('click', bestaetigung);
    }

    berechneElementGrid(gridPosition, gridAusmass, gridSpan) {
        if (gridPosition + (gridSpan / 2) > gridAusmass) {
            gridPosition = 1 + gridAusmass - gridSpan;
        } else if (gridPosition - (gridSpan / 2) < 0) {
            gridPosition = 1;
        } else {
            gridPosition -= parseInt((gridSpan - 1) / 2);
        }
        return gridPosition + ' / span ' + gridSpan;
    }

    gridBereitsBesetzt(column_neu, row_neu) {
        let colSplit = column_neu.split(' ');
        let rowSplit = row_neu.split(' ');
        let x = Number(colSplit[0]);
        let width = Number(colSplit[colSplit.length - 1]);
        let y = Number(rowSplit[0]);
        let height = Number(rowSplit[rowSplit.length - 1]);
        for (let i = 0; i < stadtplan.kartenelemente.length; i++) {
            if (stadtplan.kartenelemente[i].className.indexOf(AKTIV) < 0 && stadtplan.kartenelemente[i].className.indexOf(AUSGEBLENDET) < 0) {
                colSplit = stadtplan.kartenelemente[i].style.gridColumn.split(' ');
                rowSplit = stadtplan.kartenelemente[i].style.gridRow.split(' ');
                let kx = Number(colSplit[0]);
                let kwidth = Number(colSplit[colSplit.length - 1]);
                let ky = Number(rowSplit[0]);
                let kheight = Number(rowSplit[rowSplit.length - 1]);
                if ((x + width) > kx &&
                    x < (kx + kwidth) &&
                    (y + height) > ky &&
                    y < (ky + kheight)) {
                    return true;
                }
            }
        }
        return false;
    }

    weiseNeuePletzierungZu(zielKachel) {
        let zielInput = document.getElementById('welt_abmessung_auswahl_input');
        let x = parseInt(zielKachel.style.gridColumnStart);
        let y = parseInt(zielKachel.style.gridRowStart);
        let xMin = parseInt(document.getElementById(STADTPLAN).getAttribute('data-xmin'));
        let yMin = parseInt(document.getElementById(STADTPLAN).getAttribute('data-ymin'));
        zielInput.value =
            (x + xMin - 1) + '/' +
            (y + yMin - 1) + '/' +
            zielKachel.style.gridColumnEnd.replace('span ', '') + '/' +
            zielKachel.style.gridRowEnd.replace('span ', '');
    }

    ladeStadtPlanNeu() {
        window.location.reload();
    }
}

