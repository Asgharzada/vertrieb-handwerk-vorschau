<?php
/**
 * wp-config.php fuer Strato - Vorlage.
 *
 * Diese Datei wird EINMAL von Hand auf den Server kopiert und dort
 * ausgefuellt. Sie liegt nie in Git und wird nie vom Deploy angefasst.
 *
 * Auszufuellen: die vier DB_-Werte aus dem Strato-Kundenlogin (Datenbanken)
 * und die acht Schluessel von https://api.wordpress.org/secret-key/1.1/salt/
 */

define( 'DB_NAME',     'HIER_DATENBANKNAME' );
define( 'DB_USER',     'HIER_BENUTZER' );
define( 'DB_PASSWORD', 'HIER_PASSWORT' );
define( 'DB_HOST',     'HIER_HOST' );          // bei Strato meist rdbms.strato.de
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

/* Acht Schluessel - komplett ersetzen durch die Ausgabe von
   https://api.wordpress.org/secret-key/1.1/salt/ */
define( 'AUTH_KEY',         'HIER_ERSETZEN' );
define( 'SECURE_AUTH_KEY',  'HIER_ERSETZEN' );
define( 'LOGGED_IN_KEY',    'HIER_ERSETZEN' );
define( 'NONCE_KEY',        'HIER_ERSETZEN' );
define( 'AUTH_SALT',        'HIER_ERSETZEN' );
define( 'SECURE_AUTH_SALT', 'HIER_ERSETZEN' );
define( 'LOGGED_IN_SALT',   'HIER_ERSETZEN' );
define( 'NONCE_SALT',       'HIER_ERSETZEN' );

/* Eigenes Tabellenpraefix statt wp_ - erschwert automatisierte Angriffe. */
$table_prefix = 'pc_';

/* ---------- Haertung ---------- */

// Kein Bearbeiten von Theme-/Plugin-Dateien im Backend: Aenderungen
// kommen ueber Git, nicht ueber den Browser.
define( 'DISALLOW_FILE_EDIT', true );

// Automatische Updates: Core-Sicherheits- und Nebenversionen laufen von
// selbst. Plugins werden im Backend einzeln auf "automatisch" gestellt.
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// Revisionen begrenzen, Papierkorb nach 14 Tagen leeren.
define( 'WP_POST_REVISIONS', 10 );
define( 'EMPTY_TRASH_DAYS', 14 );

// Hinter Strato-TLS: WordPress soll HTTPS als gegeben nehmen.
define( 'FORCE_SSL_ADMIN', true );
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}

// Adresse fest verdrahten - dann kann sie niemand im Backend verstellen.
define( 'WP_HOME',    'https://www.pressburger-consulting.de' );
define( 'WP_SITEURL', 'https://www.pressburger-consulting.de' );

// Fehler nie im Browser zeigen; ins Log schreiben.
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_ENVIRONMENT_TYPE', 'production' );

// WP-Cron bleibt an: UpdraftPlus und automatische Updates haengen daran.
// (Nur abschalten, wenn bei Strato ein echter Cronjob auf wp-cron.php zeigt.)

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
