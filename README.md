# Vertrieb im Handwerk — Vorschau

Kostenlose, unverbindliche Live-Vorschau der Startseite für **Achim Pressburger
— Vertrieb im Handwerk**. Inhalt vollständig aus der Präsentation
„Vertrieb im Handwerk" (10 Folien) übernommen.

## Drei Entwürfe zur Auswahl

Alle drei liegen in diesem Repository und teilen sich **eine** Stylesheet-Datei,
**ein** Skript und **ein** Impressum. Eine Korrektur wirkt dadurch überall.

| | Pfad | Idee |
|---|---|---|
| 1 | `/` | One-Pager — die vollständige Argumentationskette der Präsentation |
| 2 | `/mehrseitig/` | Vier Seiten, genau wie vom Kunden benannt: Herausforderung, Leistung, Über mich, Kontakt |
| 3 | `/kompakt/` | Kurze Landingpage — halbe Länge, Ziel ist der 30-Minuten-Termin |

Oben auf jeder Seite sitzt eine dunkle Leiste zum Umschalten zwischen den
Entwürfen und zwischen den zwei Farbwelten. **Vor dem Live-Gang entfernen:**
die `<div class="vbar">`-Blöcke, den Abschnitt „Umschalter" in `assets/style.css`
und den Block „Farbwelt umschalten" in `assets/main.js`.

## Zwei Farbwelten

| | Aktiv über | Herkunft |
|---|---|---|
| Oliv/Orange | Standard | die Präsentation, vom Kunden bestätigt |
| Navy/Gold | `<html data-farbe="blau">` | der Logoentwurf „Pressburger Consulting" |

Umgesetzt als reiner Token-Tausch in `assets/style.css` (`:root[data-farbe="blau"]`)
— kein Baustein und kein HTML ändert sich. Die Wahl lässt sich direkt verlinken
(`?farbe=blau` bzw. `?farbe=oliv`) und wird im Browser des Betrachters gemerkt.

## Aufbau

Entwurf 1 als One-Pager mit Sprungmarken in der Kopfzeile:

| Abschnitt | Anker | Quelle (Folie) |
|---|---|---|
| Hero | `#top` | 1 |
| Herausforderung (Problem, Ausreden, falscher Schluss) | `#herausforderung` | 2, 3, 4 |
| Wahre Ursache (4 Schritte des fehlenden Ablaufs) | `#ursache` | 5 |
| Was sich verändert hat (früher / 5 Kaufkriterien) | `#wandel` | 6, 7 |
| Leistung (3 Säulen) | `#leistung` | 8 |
| Ablauf / Vorschlag (30-Minuten-Gespräch) | `#ablauf` | 9 |
| Über mich | `#ueber-mich` | 10 |
| Kontakt | `#kontakt` | — |

Dazu `impressum.html`, `datenschutz.html` und `404.html` — von allen drei
Entwürfen aus verlinkt.

## Technik

Reines HTML, CSS und Vanilla-JavaScript — **kein Build-Schritt**, keine
Abhängigkeiten, kein npm. Die Dateien werden so ausgeliefert, wie sie im
Repository liegen.

- **Keine externen Ressourcen.** Keine Google Fonts, kein CDN, kein Tracking.
  Schriften kommen aus dem System (Serif für Überschriften, Sans für Fließtext).
  Damit entfällt das DSGVO-Problem eingebundener Google-Fonts und es ist kein
  Cookie-Banner nötig.
- **Kontaktformular** baut beim Absenden eine `mailto:`-Nachricht. Ein echter
  Versand (Formspree, Web3Forms oder ein PHP-Skript beim Hoster) kommt erst mit
  der Live-Version.
- **Bewegung** über `IntersectionObserver`; `prefers-reduced-motion` wird
  respektiert.

## Farben und Typografie

Direkt aus der Präsentation übernommen — vom Kunden bestätigt.

| Rolle | Wert |
|---|---|
| Papier / Hintergrund | `#F4F1E8` |
| Karten | `#FFFFFF` |
| Überschriften | `#2E4550` |
| Oliv (Akzentflächen) | `#6E7F4E` |
| Orange (Akzentlinien) | `#D2762C` |

## Offene Punkte

Alles Fehlende ist im Entwurf sichtbar als gestrichelter Kasten markiert
(`.platzhalter` in `assets/style.css`) und lässt sich mit einer Suche nach
`platzhalter` finden.

- [ ] Portraitfoto in Originalauflösung → `bilder/achim-pressburger.jpg`
- [ ] Text für „Über mich" (Werdegang, Stationen, typische Kunden)
- [ ] Leistungsbausteine konkretisieren
- [ ] Kontaktdaten: Telefon, E-Mail, Anschrift
- [ ] Impressum: Firmenname, Anschrift, USt-IdNr. bzw. Kleinunternehmer-Hinweis
- [ ] Logo als Datei (SVG bevorzugt, sonst PNG mit Freistellung) → `bilder/`
- [ ] Entscheidung Farbwelt: Oliv/Orange oder Navy/Gold
- [ ] Entscheidung Name im Kopf: „Achim Pressburger" oder „Pressburger Consulting"
- [ ] Wunschdomain
- [ ] Vor dem Live-Gang: Umschaltleiste entfernen, `robots.txt` und das `noindex`-Meta in `index.html`
      entfernen, `<link rel="canonical">` auf die echte Domain setzen

## Hosting

Die Vorschau läuft auf GitHub Pages. Für die Live-Version eines deutschen
Unternehmens ist ein Hoster in Deutschland (all-inkl, Netcup, IONOS) die
sauberere Wahl: kein US-Transfer der Zugriffs-Logs, und ein serverseitiges
Kontaktformular ist ohne Drittanbieter möglich. Die Datenschutzerklärung ist
dann entsprechend anzupassen.

## Lokal ansehen

Einfach `index.html` im Browser öffnen — es wird kein Server benötigt.
