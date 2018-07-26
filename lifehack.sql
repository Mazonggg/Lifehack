# Recreate the database
USE dgsql18;

DROP TABLE IF EXISTS
teilaufgabe,
aufgabe,
item,
vertreter,
niederlassung,
wohnhaus,
gebaeude,
umwelt,
abmessung,
kartenelement,
institut,
vertreter_aussehen,
interieur_aussehen,
kartenelement_aussehen,
teilaufgabe_art,
item_art,
institut_art,
kartenelement_art;

# Alle verschiedenen Arten von Kartenelementen.
CREATE TABLE kartenelement_art (
  kartenelement_art_id   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  kartenelement_art_name VARCHAR(25)                    NOT NULL
);

# Referenzeintraege fuer Enums im Softwaremodell.
CREATE TABLE institut_art (
  institut_art_id   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  institut_art_name VARCHAR(25)                    NOT NULL
);

CREATE TABLE item_art (
  item_art_id   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  item_art_name VARCHAR(25)                    NOT NULL
);

CREATE TABLE teilaufgabe_art (
  teilaufgabe_art_id   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  teilaufgabe_art_name VARCHAR(25)                    NOT NULL
);

# Referenzeintraege fuer verwendete Grafiken in Spiel/Configurator.
CREATE TABLE kartenelement_aussehen (
  kartenelement_aussehen_id  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  kartenelement_aussehen_url VARCHAR(255)                   NOT NULL
);

CREATE TABLE interieur_aussehen (
  interieur_aussehen_id  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  interieur_aussehen_url VARCHAR(255)                   NOT NULL
);

CREATE TABLE vertreter_aussehen (
  vertreter_aussehen_id  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  vertreter_aussehen_url VARCHAR(255)                   NOT NULL
);

# Auf Institute bezogene Objekte
CREATE TABLE institut (
  institut_id      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  institut_name    VARCHAR(25)                    NOT NULL,
  beschreibung     VARCHAR(255)                   NOT NULL,
  institut_art_ref INT                            NOT NULL,
  FOREIGN KEY (institut_art_ref) REFERENCES institut_art (institut_art_id)
);

# Sammlung aller abgebildeten Objekte in der Spielwelt
CREATE TABLE kartenelement (
  kartenelement_id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  kartenelement_art_ref      INT                            NOT NULL,
  FOREIGN KEY (kartenelement_art_ref) REFERENCES kartenelement_art (kartenelement_art_id),
  kartenelement_aussehen_ref INT                            NOT NULL,
  FOREIGN KEY (kartenelement_aussehen_ref) REFERENCES kartenelement_aussehen (kartenelement_aussehen_id)
);

CREATE TABLE abmessung (
  welt_abmessung              VARCHAR(25) NOT NULL,
  abmessung_kartenelement_ref INT         NOT NULL,
  FOREIGN KEY (abmessung_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE
);

CREATE TABLE umwelt (
  bezeichnung              VARCHAR(25) NOT NULL,
  begehbar                 TINYINT     NOT NULL,
  umwelt_kartenelement_ref INT         NOT NULL,
  FOREIGN KEY (umwelt_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE
);

CREATE TABLE gebaeude (
  gebaeude_kartenelement_ref INT NOT NULL,
  FOREIGN KEY (gebaeude_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE,
  interieur_aussehen_ref     INT NOT NULL,
  FOREIGN KEY (interieur_aussehen_ref) REFERENCES interieur_aussehen (interieur_aussehen_id)
);

CREATE TABLE wohnhaus (
  wohneinheiten              INT NOT NULL,
  wohnhaus_kartenelement_ref INT NOT NULL,
  FOREIGN KEY (wohnhaus_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE
);

CREATE TABLE niederlassung (

  niederlassung_kartenelement_ref INT NOT NULL,
  FOREIGN KEY (niederlassung_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE,
  niederlassung_institut_ref      INT NOT NULL,
  FOREIGN KEY (niederlassung_institut_ref) REFERENCES institut (institut_id)
);

CREATE TABLE vertreter (
  vertreter_id                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  vorname                     VARCHAR(25)                    NOT NULL,
  nachname                    VARCHAR(25)                    NOT NULL,
  geschlecht                  TINYINT                        NOT NULL,
  vertreter_kartenelement_ref INT                            NOT NULL,
  FOREIGN KEY (vertreter_kartenelement_ref) REFERENCES kartenelement (kartenelement_id)
    ON DELETE CASCADE,
  gebaeude_position           VARCHAR(25),
  vertreter_aussehen_ref      INT                            NOT NULL,
  FOREIGN KEY (vertreter_aussehen_ref) REFERENCES vertreter_aussehen (vertreter_aussehen_id)
);

# Direkt aufgabenbezogene Objekte
CREATE TABLE item (
<<<<<<< HEAD
  item_id       INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  item_name     VARCHAR(25)                    NOT NULL,
  gewicht       INT                            NOT NULL,
  konfiguration VARCHAR(255)                   NOT NULL,
  item_art_ref  INT                            NOT NULL,
=======
  item_id      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  item_name         VARCHAR(25)                    NOT NULL,
  gewicht      INT                            NOT NULL,
  konfiguration       VARCHAR(255)                   NOT NULL,
  item_art_ref INT                            NOT NULL,
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2
  FOREIGN KEY (item_art_ref) REFERENCES item_art (item_art_id)
);

CREATE TABLE aufgabe (
  aufgabe_id        INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  bezeichnung       VARCHAR(127)                   NOT NULL,
  gesetzesgrundlage VARCHAR(255)                   NOT NULL
);

CREATE TABLE teilaufgabe (
  teilaufgabe_id          INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  menue_text              VARCHAR(255)                   NOT NULL,
  ansprache_text          VARCHAR(255)                   NOT NULL,
  antwort_text            VARCHAR(255)                   NOT NULL,
  erfuellungs_text        VARCHAR(255)                   NOT NULL,
  scheitern_text          VARCHAR(255)                   NOT NULL,
  teilaufgabe_aufgabe_ref INT                            NOT NULL,
  FOREIGN KEY (teilaufgabe_aufgabe_ref) REFERENCES aufgabe (aufgabe_id)
    ON DELETE CASCADE,
  bedingung_item_ref      INT                            NOT NULL,
  FOREIGN KEY (bedingung_item_ref) REFERENCES item (item_id),
  institut_art_ref        INT                            NOT NULL,
  FOREIGN KEY (institut_art_ref) REFERENCES institut_art (institut_art_id),
  teilaufgabe_art_ref     INT                            NOT NULL,
  FOREIGN KEY (teilaufgabe_art_ref) REFERENCES teilaufgabe_art (teilaufgabe_art_id),
  belohnung_item_ref      INT                            NOT NULL,
  FOREIGN KEY (belohnung_item_ref) REFERENCES item (item_id)
);

# Fixe Daten fuer Arten von Kartenelementen
INSERT INTO kartenelement_art (kartenelement_art_name) VALUES ('umwelt');
INSERT INTO kartenelement_art (kartenelement_art_name) VALUES ('gebaeude');
INSERT INTO kartenelement_art (kartenelement_art_name) VALUES ('wohnhaus');
INSERT INTO kartenelement_art (kartenelement_art_name) VALUES ('niederlassung');

# Fixe Daten fuer Enums und identifizierbare Objekte anlegen
INSERT INTO institut_art (institut_art_name) VALUES ('wohnhaus');
INSERT INTO institut_art (institut_art_name) VALUES ('bank');
INSERT INTO institut_art (institut_art_name) VALUES ('stadtteilbuero');
INSERT INTO institut_art (institut_art_name) VALUES ('schule');
INSERT INTO institut_art (institut_art_name) VALUES ('versicherung');
INSERT INTO institut_art (institut_art_name) VALUES ('einzelhaendler');

INSERT INTO item_art (item_art_name) VALUES ('gegenstand');
INSERT INTO item_art (item_art_name) VALUES ('dokument');
INSERT INTO item_art (item_art_name) VALUES ('vertrag');
INSERT INTO item_art (item_art_name) VALUES ('formular');
INSERT INTO item_art (item_art_name) VALUES ('bankKonto');
INSERT INTO item_art (item_art_name) VALUES ('chipkarte');

INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('rasen.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('sandweg.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('asphalt.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('rathaus.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('laden.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('bank.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('wohnhaus_schwarz.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('wohnhaus_gruen.png');
INSERT INTO kartenelement_aussehen (kartenelement_aussehen_url) VALUES ('wohnhaus_grau.png');

INSERT INTO interieur_aussehen (interieur_aussehen_url) VALUES ('wohnhaus_innen.png');

<<<<<<< HEAD
INSERT INTO teilaufgabe_art (teilaufgabe_art_name) VALUES ('item_wird_abgegeben');
INSERT INTO teilaufgabe_art (teilaufgabe_art_name) VALUES ('item_wird_behalten');
=======
INSERT INTO teilaufgabe_art (teilaufgabe_art_name) VALUES ('Item wird abgegeben');
INSERT INTO teilaufgabe_art (teilaufgabe_art_name) VALUES ('Item wird behalten');
>>>>>>> 917146c0a81e0c5823069c51430b96dc0fb1eed2

# Erste Stammdaten anlegen

#################################################
############          Umwelt         ############
#################################################

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'umwelt'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'sandweg.png'));

INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-19/0/37/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-19/-1/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-1/-1/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('16/-1/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-15/1/1/10',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('14/1/1/10',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-21/10/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-10/10/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-1/10/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('8/10/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('19/10/2/1',
   LAST_INSERT_ID());
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-21/11/42/1',
   LAST_INSERT_ID());

INSERT INTO umwelt
VALUES
  ('sandweg',
   1,
   (SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'umwelt'));

# Institute
INSERT INTO institut
(institut_name, beschreibung, institut_art_ref)
VALUES
  ('Wohnhaus', 'Wohnraum jeglicher Art',
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'wohnhaus'));
INSERT INTO institut
(institut_name, beschreibung, institut_art_ref)
VALUES
  ('Dorfbank', 'Es ist die &auml;lteste Bank im Dorf und hat damit das Vertrauen aller Einwohner.',
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'bank'));
INSERT INTO institut
(institut_name, beschreibung, institut_art_ref)
VALUES
  ('Rathaus', 'Der Ort f&uuml;r alle Amtsg&auml;nge in diesem Dorf.',
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'stadtteilbuero'));
INSERT INTO institut
(institut_name, beschreibung, institut_art_ref)
VALUES
  ('CentyMarkt', 'Frisch und Frostig.',
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'einzelhaendler'));

#################################################
############     Niederlassungen     ############
#################################################

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'niederlassung'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'laden.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-23/-9/13/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO niederlassung
(niederlassung_kartenelement_ref, niederlassung_institut_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT institut_id
    FROM institut
    WHERE institut_name = 'CentyMarkt'));

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'niederlassung'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'rathaus.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-6/-11/12/10',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO niederlassung
(niederlassung_kartenelement_ref, niederlassung_institut_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT institut_id
    FROM institut
    WHERE institut_name = 'Rathaus'));


INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'niederlassung'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'bank.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('11/-8/14/7',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO niederlassung
(niederlassung_kartenelement_ref, niederlassung_institut_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT institut_id
    FROM institut
    WHERE institut_name = 'Dorfbank'));

#################################################
############       Wohnhaeuser       ############
#################################################

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'wohnhaus'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'wohnhaus_schwarz.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-24/2/8/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO wohnhaus
(wohneinheiten, wohnhaus_kartenelement_ref)
VALUES
  (2,
   LAST_INSERT_ID());

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'wohnhaus'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'wohnhaus_grau.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-4/2/8/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO wohnhaus
(wohneinheiten, wohnhaus_kartenelement_ref)
VALUES
  (4,
   LAST_INSERT_ID());

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'wohnhaus'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'wohnhaus_gruen.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('-13/2/8/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO wohnhaus
(wohneinheiten, wohnhaus_kartenelement_ref)
VALUES
  (1,
   LAST_INSERT_ID());

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'wohnhaus'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'wohnhaus_schwarz.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('5/2/8/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO wohnhaus
(wohneinheiten, wohnhaus_kartenelement_ref)
VALUES
  (4,
   LAST_INSERT_ID());

INSERT INTO kartenelement
(kartenelement_art_ref, kartenelement_aussehen_ref)
VALUES
  ((SELECT kartenelement_art_id
    FROM kartenelement_art
    WHERE kartenelement_art_name = 'wohnhaus'),
   (SELECT kartenelement_aussehen_id
    from kartenelement_aussehen
    WHERE kartenelement_aussehen_url = 'wohnhaus_schwarz.png'));
INSERT INTO abmessung
(welt_abmessung, abmessung_kartenelement_ref)
VALUES
  ('16/2/8/8',
   LAST_INSERT_ID());
INSERT INTO gebaeude
(gebaeude_kartenelement_ref, interieur_aussehen_ref)
VALUES
  (LAST_INSERT_ID(),
   (SELECT interieur_aussehen_id
    FROM interieur_aussehen
    WHERE interieur_aussehen_url = 'wohnhaus_innen.png'));
INSERT INTO wohnhaus
(wohneinheiten, wohnhaus_kartenelement_ref)
VALUES
  (2,
   LAST_INSERT_ID());

#################################################
############          Item           ############
#################################################

INSERT INTO item
(item_name, gewicht, konfiguration, item_art_ref)
VALUES
  ('Personalausweis',
   '1',
   'ITEMEIGENSCHAFTEN',
   (SELECT item_art_id
    FROM item_art
    WHERE item_art_name = 'Dokument'));

INSERT INTO item
(item_name, gewicht, konfiguration, item_art_ref)
VALUES
  ('Bankkonto',
   '1',
   'ITEMEIGENSCHAFTEN',
   (SELECT item_art_id
    FROM item_art
    WHERE item_art_name = 'BankKonto'));
INSERT INTO item
(item_name, gewicht, konfiguration, item_art_ref)
VALUES
  ('Kontoantrag',
   '1',
   'ITEMEIGENSCHAFTEN',
   (SELECT item_art_id
    FROM item_art
    WHERE item_art_name = 'Formular'));

#################################################
############         Aufgabe         ############
#################################################

INSERT INTO aufgabe
(bezeichnung, gesetzesgrundlage)
VALUES
  ('Richte Dein erstes Bankkonto ein',
   '&sect; 0815\n
Bargeldloser Geldverkehr:
Der gr&ouml;szte Teil des Geldverkehrs verl&auml;uft heutzutage &uuml;ber Bankgesch&auml;fte. Hierf&uuml;r ben&ouml;tigst Du ein Girokonto bei einer Bank usw.');

INSERT INTO teilaufgabe
(menue_text,
 ansprache_text,
 antwort_text,
 erfuellungs_text,
 scheitern_text,
 teilaufgabe_aufgabe_ref,
 bedingung_item_ref,
 institut_art_ref,
 teilaufgabe_art_ref,
 belohnung_item_ref)
VALUES
  ('Der Bankangestellte ben&ouml;tigt deinen Personalausweis,
  um dir dein Bankkonto erstellen zu k&ouml;nnen',
   'Guten Tag! Ich moechte ein Konto er&ouml;ffnen.',
   'Guten Tag!\n
  Sehr gerne, daf&uuml;r brauche ich Ihren Personalausweis, um Ihre Daten aufzunehmen.',
   'Sehr gut, als n&auml;chstes m&uuml;ssen Sie
   ein Formular mit Ihren individuellen Anspr&uuml;chen ausf&uuml;llen.',
   'Tut mir leid,
   leider kann ich ohne Ihren g&uuml;ltigen Personalausweis
   kein Konto f&uuml;r Sie er&ouml;ffnen.',
   (SELECT aufgabe_id
    FROM aufgabe
    WHERE bezeichnung = 'Richte Dein erstes Bankkonto ein'),
   (SELECT item_id
    FROM item
    WHERE item.item_name = 'Personalausweis'),
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'Bank'),
   (SELECT teilaufgabe_art_id
    FROM teilaufgabe_art
    WHERE teilaufgabe_art_name = 'item_wird_behalten'),
   (SELECT item.item_id
    FROM item
    WHERE item.item_name = 'Kontoantrag'));

INSERT INTO teilaufgabe
(menue_text,
 ansprache_text,
 antwort_text,
 erfuellungs_text,
 scheitern_text,
 teilaufgabe_aufgabe_ref,
 bedingung_item_ref,
 institut_art_ref,
 teilaufgabe_art_ref,
 belohnung_item_ref)
VALUES
  ('Geb das ausgef&uuml;llte Formular ab, damit das Konto
  deinen Anspr&uuml;chen entspricht',
   '-',
   'Haben Sie das Formular ausgef&uuml;llt?',
   'Bittesehr. Zu Ihrer Freude erhalten Sie im Rahmen einer Werbungsaktion 100,00&euro; Startguthaben.',
   'Tut mir leid,
   leider kann ich ohne Sie m&uuml;ssen mir das ausgef&uuml;llte Formular geben,
   damit ich fortfahren kann.',
   (SELECT aufgabe_id
    FROM aufgabe
    WHERE bezeichnung = 'Richte Dein erstes Bankkonto ein'),
   (SELECT item_id
    FROM item
    WHERE item.item_name = 'Kontoantrag'),
   (SELECT institut_art_id
    FROM institut_art
    WHERE institut_art_name = 'Bank'),
   (SELECT teilaufgabe_art_id
    FROM teilaufgabe_art
    WHERE teilaufgabe_art_name = 'item_wird_abgegeben'),
   (SELECT item_id
    FROM item
    WHERE item.item_name = 'Bankkonto'));

