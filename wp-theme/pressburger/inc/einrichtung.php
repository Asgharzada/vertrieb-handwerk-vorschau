<?php
/**
 * Einrichtung: Werkzeuge -> Pressburger einrichten.
 *
 * Legt in einem Durchgang an, was die Seite braucht: Bilder in der
 * Mediathek, Logo und Site-Icon, die beiden Erfolgsgeschichten, das
 * Kontaktformular, die Seiten (Startseite, Blog, Impressum, Datenschutz)
 * und die passenden Einstellungen. Laeuft gefahrlos mehrfach: was schon
 * da ist, wird uebersprungen.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	add_management_page(
		'Pressburger einrichten',
		'Pressburger einrichten',
		'manage_options',
		'pressburger-einrichten',
		'pressburger_einrichtung_seite'
	);
} );

function pressburger_einrichtung_seite() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$protokoll = array();
	if ( isset( $_POST['pressburger_einrichten'] ) && check_admin_referer( 'pressburger_einrichten' ) ) {
		$protokoll = pressburger_einrichten();
	}
	echo '<div class="wrap"><h1>Pressburger einrichten</h1>';
	if ( $protokoll ) {
		echo '<div class="notice notice-success"><ul style="margin:.5em 1em">';
		foreach ( $protokoll as $zeile ) {
			echo '<li>' . esc_html( $zeile ) . '</li>';
		}
		echo '</ul></div>';
	}
	echo '<p>Legt Bilder, Logo, Erfolgsgeschichten, Kontaktformular, Seiten und Einstellungen an. Bereits Vorhandenes bleibt unangetastet.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'pressburger_einrichten' );
	submit_button( 'Jetzt einrichten', 'primary', 'pressburger_einrichten' );
	echo '</form></div>';
}

/* ---------- Bausteine ---------- */

function pressburger_bild_hochladen( $datei, $titel, $unterschrift = '' ) {
	$vorhanden = get_posts( array(
		'post_type'   => 'attachment',
		'meta_key'    => '_pressburger_quelle',
		'meta_value'  => $datei,
		'numberposts' => 1,
		'post_status' => 'any',
	) );
	if ( $vorhanden ) {
		return (int) $vorhanden[0]->ID;
	}
	$quelle = get_theme_file_path( 'assets/bilder/' . $datei );
	if ( ! file_exists( $quelle ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$kopie = wp_tempnam( $datei );
	copy( $quelle, $kopie );
	$upload = array( 'name' => $datei, 'tmp_name' => $kopie );
	$id = media_handle_sideload( $upload, 0, $titel, array(
		'post_excerpt' => $unterschrift,
		'post_title'   => $titel,
	) );
	if ( is_wp_error( $id ) ) {
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $titel );
	update_post_meta( $id, '_pressburger_quelle', $datei );
	return (int) $id;
}

function pressburger_muster( $slug ) {
	$muster = WP_Block_Patterns_Registry::get_instance()->get_registered( 'pressburger/' . $slug );
	return $muster ? $muster['content'] : '';
}

function pressburger_seite_anlegen( $slug, $titel, $inhalt, $extra = array() ) {
	$vorhanden = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $vorhanden ) {
		return (int) $vorhanden->ID;
	}
	return (int) wp_insert_post( array_merge( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_name'    => $slug,
		'post_title'   => $titel,
		'post_content' => $inhalt,
	), $extra ) );
}

function pressburger_erfolg_anlegen( $slug, $titel, $kennzahl, $absaetze, $bild_id, $reihenfolge ) {
	$vorhanden = get_page_by_path( $slug, OBJECT, 'erfolg' );
	if ( $vorhanden ) {
		return (int) $vorhanden->ID;
	}
	$inhalt = '';
	foreach ( $absaetze as $a ) {
		$inhalt .= "<!-- wp:paragraph -->\n<p>" . $a . "</p>\n<!-- /wp:paragraph -->\n\n";
	}
	$id = wp_insert_post( array(
		'post_type'    => 'erfolg',
		'post_status'  => 'publish',
		'post_name'    => $slug,
		'post_title'   => $titel,
		'post_excerpt' => $kennzahl,
		'post_content' => trim( $inhalt ),
		'menu_order'   => $reihenfolge,
	) );
	if ( $id && $bild_id ) {
		set_post_thumbnail( $id, $bild_id );
	}
	return (int) $id;
}

function pressburger_formular_anlegen() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 'Contact Form 7 ist nicht aktiv - Formular uebersprungen.';
	}
	$vorhanden = get_posts( array( 'post_type' => 'wpcf7_contact_form', 'title' => 'Kontakt', 'numberposts' => 1, 'post_status' => 'any' ) );
	if ( $vorhanden ) {
		return 'Kontaktformular vorhanden.';
	}
	$formular = <<<'FORM'
<label>Name
[text* ihr-name autocomplete:name]</label>

<label>Betrieb
[text betrieb autocomplete:organization]</label>

<label>E-Mail
[email* ihre-email autocomplete:email]</label>

<label>Telefon
[tel telefon autocomplete:tel]</label>

<label>Ihre Nachricht
[textarea nachricht placeholder "Wie sieht Ihr aktueller Ablauf von der Anfrage bis zum Auftrag aus?"]</label>

[submit "Anfrage senden"]
FORM;

	$mail = array(
		'subject'            => 'Anfrage über die Website – [ihr-name]',
		'sender'             => 'Website <achim@pressburger-consulting.de>',
		'recipient'          => 'achim@pressburger-consulting.de',
		'body'               => "Name: [ihr-name]\nBetrieb: [betrieb]\nE-Mail: [ihre-email]\nTelefon: [telefon]\n\nNachricht:\n[nachricht]\n\n--\nGesendet über das Kontaktformular auf pressburger-consulting.de",
		'additional_headers' => 'Reply-To: [ihre-email]',
		'attachments'        => '',
		'use_html'           => 0,
		'exclude_blank'      => 0,
	);

	$kontaktformular = WPCF7_ContactForm::get_template( array( 'title' => 'Kontakt' ) );
	$kontaktformular->set_properties( array(
		'form' => $formular,
		'mail' => $mail,
		'messages' => array_merge( $kontaktformular->prop( 'messages' ) ?: array(), array(
			'mail_sent_ok' => 'Vielen Dank – Ihre Nachricht ist angekommen. Ich melde mich in Kürze bei Ihnen.',
		) ),
	) );
	$kontaktformular->save();
	return 'Kontaktformular "Kontakt" angelegt.';
}

/* ---------- Der Durchlauf ---------- */

function pressburger_einrichten() {
	$log = array();

	// 1) Bilder
	$logo     = pressburger_bild_hochladen( 'logo.png', 'Pressburger Consulting' );
	$icon     = pressburger_bild_hochladen( 'site-icon-512.png', 'Site-Icon' );
	$portrait = pressburger_bild_hochladen( 'achim-pressburger.webp', 'Achim Pressburger' );
	$bad      = pressburger_bild_hochladen( 'erfolg-badsanierung.webp', 'Modern saniertes Bad', 'Symbolbild' );
	$balkon   = pressburger_bild_hochladen( 'erfolg-balkonsanierung.webp', 'Neu sanierte Terrasse', 'Symbolbild' );
	$log[] = sprintf( 'Bilder: Logo %d, Icon %d, Portrait %d, Bad %d, Terrasse %d', $logo, $icon, $portrait, $bad, $balkon );

	if ( $logo ) { set_theme_mod( 'custom_logo', $logo ); }
	if ( $icon ) { update_option( 'site_icon', $icon ); }

	// 2) Erfolgsgeschichten
	pressburger_erfolg_anlegen(
		'badsanierung',
		'Badsanierung: Neuer Geschäftsbereich etabliert',
		'Abschlüsse verdreifacht · Ø Auftragswert rund 30.000 €',
		array(
			'Aus einer klaren Idee wurde ein erfolgreicher, eigenständiger Geschäftsbereich: Badsanierung. Gemeinsam wurde das neue Angebot im Betrieb aufgebaut, strukturiert positioniert und mit einem lukrativen, kundenorientierten Verkaufsablauf verbunden.',
			'Zu Beginn war die Zahl der Abschlüsse noch überschaubar. Das Potenzial war jedoch deutlich vorhanden: hochwertige Leistungen, interessante Auftragswerte und eine wachsende Nachfrage. Entscheidend war, aus einzelnen Anfragen einen klar geführten Verkaufsprozess zu machen – von der ersten Bedarfsanalyse über die überzeugende Präsentation bis zum verbindlichen Abschluss und konsequenten Nachfassen.',
			'Durch regelmäßiges Vertriebscoaching, praxisnahe Trainings und einen verbindlichen Verkaufsablauf konnte die Zahl der Abschlüsse zwischenzeitlich verdreifacht werden. Bei einem durchschnittlichen Auftragswert von rund 30.000 Euro zeigt dieses Beispiel eindrucksvoll, welches Umsatzpotenzial in einem professionell aufgebauten Vertriebsprozess steckt.',
		),
		$bad, 1
	);
	pressburger_erfolg_anlegen(
		'balkonsanierung',
		'Balkonsanierung: 30 % mehr Abschlüsse',
		'+30 % Abschlussquote · aus dem bestehenden Anfragevolumen',
		array(
			'Bei einem Handwerksbetrieb, der unter anderem Balkonsanierungen anbot, lag das Potenzial vor allem im Zusammenspiel zwischen Kalkulation, Angebot und Verkauf. Kalkulationsprozesse waren zu wenig auf eine überzeugende Angebots- und Abschlussstrategie ausgerichtet. Zudem hatte der Bauleiter regelmäßig direkten Kundenkontakt, nutzte diese Rolle aber noch nicht konsequent für die Verkaufsführung.',
			'Wir haben den Kalkulationsprozess geschärft, Angebote verständlicher und wertorientierter aufgebaut und den Bauleiter gezielt im Kunden- und Abschlussgespräch gecoacht. So wurde aus einer überwiegend technischen Funktion eine aktive Schnittstelle zwischen Projekt, Kunde und Vertrieb.',
			'Das Ergebnis: Die Abschlussquote stieg um 30 %. Der Betrieb gewann dadurch mehr Aufträge aus dem bestehenden Anfragevolumen und verbesserte zugleich die Zusammenarbeit zwischen Technik, Kalkulation und Vertrieb.',
		),
		$balkon, 2
	);
	$log[] = 'Erfolgsgeschichten: Badsanierung, Balkonsanierung.';

	// 3) Kontaktformular
	$log[] = pressburger_formular_anlegen();

	// 4) Seiten
	$startseite = '';
	foreach ( array( 'hero', 'leistung', 'erfolgsgeschichten', 'ansatz', 'gespraech', 'ueber-mich', 'kontakt' ) as $slug ) {
		$startseite .= pressburger_muster( $slug ) . "\n\n";
	}
	$start_id = pressburger_seite_anlegen( 'startseite', 'Startseite', $startseite );
	$blog_id  = pressburger_seite_anlegen( 'blog', 'Blog', '' );
	pressburger_seite_anlegen( 'impressum', 'Impressum', file_get_contents( get_theme_file_path( 'inc/inhalte/impressum.html' ) ) );
	pressburger_seite_anlegen( 'datenschutz', 'Datenschutzerklärung', file_get_contents( get_theme_file_path( 'inc/inhalte/datenschutz.html' ) ) );
	$log[] = 'Seiten: Startseite, Blog, Impressum, Datenschutz.';

	// Die mitgelieferte Beispielseite und den Beispielbeitrag entsorgen
	foreach ( array( 'beispiel-seite', 'sample-page' ) as $s ) {
		$b = get_page_by_path( $s, OBJECT, 'page' );
		if ( $b ) { wp_delete_post( $b->ID, true ); }
	}
	$hallo = get_page_by_path( 'hallo-welt', OBJECT, 'post' );
	if ( $hallo ) { wp_delete_post( $hallo->ID, true ); }

	// 5) Einstellungen
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $start_id );
	update_option( 'page_for_posts', $blog_id );
	update_option( 'blogname', 'Pressburger Consulting' );
	update_option( 'blogdescription', 'Vertrieb im Handwerk' );
	update_option( 'timezone_string', 'Europe/Berlin' );
	update_option( 'date_format', 'j. F Y' );
	update_option( 'time_format', 'H:i' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'users_can_register', 0 );
	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'posts_per_page', 10 );
	flush_rewrite_rules();
	$log[] = 'Einstellungen: statische Startseite, Blog-Seite, Zeitzone, Permalinks.';

	return $log;
}
