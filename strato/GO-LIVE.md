# Go-live auf Strato — Ablauf

Alles Vorbereitete liegt bereit; die Reihenfolge zählt. **(M)** = Mahmood im Strato-Panel / Browser, **(C)** = Claude.

## 0. Vorab prüfen (M) — 5 Min.

Im Strato-Kundenlogin nachsehen, bevor irgendetwas gemacht wird:

- [ ] **Datenbanken** vorhanden? (Menüpunkt „Datenbanken“ / „MySQL“). Ohne MySQL kein WordPress → Paket-Upgrade nötig.
- [ ] **PHP-Version** einstellbar auf 8.2 oder 8.3 (Menü „PHP-Version“ o. ä.).
- [ ] **SSL** aktivierbar für die Domain („SSL“ / „Sicherheit“).
- [ ] **E-Mail-Postfach** anlegbar (`achim@pressburger-consulting.de`).
- [ ] **FTP-Zugang** sichtbar (Server, Benutzer, Passwort).

Wenn einer der Punkte fehlt: melden, bevor weitergemacht wird.

## 1. Strato einrichten (M) — 15 Min.

1. **PHP** auf 8.2/8.3 stellen.
2. **Datenbank anlegen**: Name, Benutzer, Passwort, Host notieren (Host ist bei Strato meist `rdbms.strato.de`). Diese vier Werte kommen nur in `wp-config.php` auf dem Server — nirgendwo sonst.
3. **SSL** für `pressburger-consulting.de` und `www.pressburger-consulting.de` aktivieren.
4. **Postfach** `achim@pressburger-consulting.de` anlegen.
5. **Domain-Ziel** prüfen: auf welchen Ordner zeigt die Domain? (z. B. `/pressburger-consulting.de/` oder `/htdocs/`). Diesen Pfad merken — er heißt unten `WEBROOT`.
6. **FTP**: Zugangsdaten bereitlegen. Passwort niemals in den Chat.

## 2. WordPress hochladen (M mit C) — 15 Min.

1. Ordner `E:\Shopify\wp-pressburger\htdocs\` per FTP-Programm (z. B. FileZilla, FTPS/TLS) **komplett** nach `WEBROOT` hochladen — **außer** `wp-config.php` und `login-lokal.php`.
2. `strato/wp-config.strato.php` lokal kopieren, ausfüllen (DB-Werte + Salze von https://api.wordpress.org/secret-key/1.1/salt/), als `wp-config.php` nach `WEBROOT` hochladen.
3. `strato/htaccess.txt` als `.htaccess` nach `WEBROOT` hochladen.
4. Im Browser `https://www.pressburger-consulting.de/wp-admin/install.php` öffnen → Installationsassistent: Titel „Pressburger Consulting“, Benutzername **nicht** `admin` (z. B. `apressburger`), starkes Passwort, E-Mail achim@…, Sichtbarkeit für Suchmaschinen **noch aus**.

## 3. Aktivieren und einrichten (M) — 10 Min.

1. **Design → Themes** → „Pressburger Consulting“ aktivieren.
2. **Plugins** → alle drei aktivieren (Contact Form 7, UpdraftPlus, Limit Login Attempts Reloaded).
3. **Werkzeuge → Pressburger einrichten** → „Jetzt einrichten“. Legt Bilder, Logo, Erfolgsgeschichten, Formular, Seiten, Einstellungen an.
4. **Einstellungen → Permalinks** einmal öffnen und „Änderungen speichern“ (schreibt den WordPress-Block in die `.htaccess`).
5. **Plugins → Installierte Plugins** → bei allen drei „Automatische Aktualisierungen aktivieren“.
6. **UpdraftPlus → Einstellungen**: Dateien und Datenbank wöchentlich, 4 Sicherungen behalten. Speicherort: E-Mail ist zu klein — Google Drive oder Dropbox des Kunden verbinden, oder vorerst „lokal“ und monatlich herunterladen.
7. **Limit Login Attempts**: Standard reicht (4 Versuche, 20 Min. Sperre).

## 4. Prüfen (C) — 15 Min.

- [ ] Startseite, Impressum, Datenschutz, Blog, eine Erfolgsgeschichte einzeln — je 200, Layout wie lokal.
- [ ] Kontaktformular absenden → Mail kommt bei achim@… an (Absender-Domain = eigene Domain, sonst Spam).
- [ ] Mobil (390 px) durchscrollen, Menü öffnen/schließen.
- [ ] `https://` erzwungen, `http://` und ohne `www` leiten um.
- [ ] Keine externen Requests (Netzwerk-Tab: nur eigene Domain).
- [ ] `/xmlrpc.php` → 403, `/wp-json/wp/v2/users` → 401/404.
- [ ] Site-Icon im Tab, Logo im Kopf, Bilder mit „Symbolbild“.

## 5. Deploy-Automatik (M) — 5 Min.

Im GitHub-Repo → Settings → Secrets and variables → Actions → vier Secrets:

| Secret | Wert |
|---|---|
| `STRATO_FTP_SERVER` | FTP-Server aus dem Strato-Login |
| `STRATO_FTP_USER` | FTP-Benutzer |
| `STRATO_FTP_PASSWORD` | FTP-Passwort |
| `STRATO_THEME_DIR` | `WEBROOT/wp-content/themes/pressburger/` — mit Schrägstrich am Ende |

Danach lädt jeder Push, der `wp-theme/pressburger/` berührt, das Theme automatisch hoch. WordPress, Plugins, Uploads und `wp-config.php` werden nie angefasst.

## 6. Live schalten (M) — 5 Min.

1. **Einstellungen → Lesen** → „Suchmaschinen davon abhalten, diese Website zu indexieren“ **abhaken**.
2. Kunde: Passwort **telefonisch** übergeben, nicht per Mail.
3. Kunde auf **Anleitung** (linke Leiste, ganz oben) hinweisen.

## 7. Aufräumen (C)

- [ ] GitHub Pages im Repo `vertrieb-handwerk-vorschau` abschalten, Repo auf **privat**.
- [ ] `login-lokal.php`, `aktivieren.php`, `einrichten.php`, `pruefen.php` sind nur lokal — nie hochladen.
- [ ] Google-Unternehmensprofil mit dem Kunden anlegen (separater Termin).

## Was danach noch offen ist

- USt-IdNr. im Impressum (Kunde).
- „wir“ vs. „ich“ im Text (Kunde).
- Logo als SVG (Grafiker des Kunden) — dann `mix-blend-mode` im Theme überflüssig.
- Cookie-Banner + Datenschutz-Ergänzung, **sobald** Meta-Pixel/Instagram-Anzeigen kommen.
