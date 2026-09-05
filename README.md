# Vertrieb im Handwerk — Vorschau

Kostenlose, unverbindliche Live-Vorschau der Startseite für **Achim Pressburger
— Vertrieb im Handwerk**. Inhalt vollständig aus der Präsentation
„Vertrieb im Handwerk" (10 Folien) übernommen.

## Aufbau

Ein One-Pager mit Sprungmarken in der Kopfzeile:

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

Dazu `impressum.html`, `datenschutz.html` und `404.html`.

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
- [ ] Logo, falls vorhanden
- [ ] Wunschdomain

## Hosting

Die Vorschau läuft auf GitHub Pages. Für die Live-Version eines deutschen
Unternehmens ist ein Hoster in Deutschland (all-inkl, Netcup, IONOS) die
sauberere Wahl: kein US-Transfer der Zugriffs-Logs, und ein serverseitiges
Kontaktformular ist ohne Drittanbieter möglich. Die Datenschutzerklärung ist
dann entsprechend anzupassen.

## Lokal ansehen

Einfach `index.html` im Browser öffnen — es wird kein Server benötigt.
