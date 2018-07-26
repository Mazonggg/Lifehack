const BEARBEITEN = '_bearbeiten';
const LISTE = '_liste';


class MenueController extends HtmlObjekt {
    constructor(objekt) {
        super(objekt);
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
            });
        }
    }

    static oeffneListe(modus, callbackInfo) {
        popup.oeffnePopup(null);
        popup.addSchliessenCallback(modus, null, callbackInfo);
        AjaxHandler.get(modus, popup.setInhalt, callbackInfo);
    }
}

