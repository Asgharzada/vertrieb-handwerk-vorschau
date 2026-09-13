<?php
/**
 * Haertung und Datenschutz - was WordPress von Haus aus anders macht,
 * als es fuer eine deutsche Unternehmensseite sinnvoll ist.
 *
 * Grundsatz: Die oeffentliche Seite laedt nichts von fremden Servern und
 * setzt keine Cookies. Cookies gibt es nur nach dem Login im Backend.
 */

defined( 'ABSPATH' ) || exit;

/* ---------- Keine Verbindungen zu fremden Servern ---------- */

add_action( 'init', function () {
	// Emoji-Skript und -Styles laden von s.w.org.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );

	// oEmbed: fremde Inhalte einbetten und selbst einbettbar sein.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'embed_oembed_discover', '__return_false' );

	// Verraet nichts ueber die Installation.
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
} );

// Gravatar laedt Bilder von gravatar.com - hier nicht noetig.
add_filter( 'get_avatar', '__return_empty_string' );
add_filter( 'option_show_avatars', '__return_zero' );

/* ---------- Angriffsflaechen schliessen ---------- */

// XML-RPC: alter Fernzugriff, heute vor allem Ziel fuer Passwort-Raten.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', function ( $kopf ) {
	unset( $kopf['X-Pingback'] );
	return $kopf;
} );

// Benutzernamen sind ueber /wp-json/wp/v2/users sonst oeffentlich lesbar.
add_filter( 'rest_endpoints', function ( $endpunkte ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpunkte['/wp/v2/users'], $endpunkte['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpunkte;
} );

// ?author=1 leitet sonst auf /author/name/ um und verraet den Login-Namen.
add_action( 'template_redirect', function () {
	if ( is_author() || ( isset( $_GET['author'] ) && ! is_admin() ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

// Fehlermeldung beim Login nicht verraten, ob der Name existiert.
add_filter( 'login_errors', function () {
	return 'Anmeldung fehlgeschlagen. Bitte pruefen Sie Benutzername und Passwort.';
} );

/* ---------- Kommentare komplett aus ---------- */

add_action( 'init', function () {
	foreach ( get_post_types() as $typ ) {
		remove_post_type_support( $typ, 'comments' );
		remove_post_type_support( $typ, 'trackbacks' );
	}
} );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 20 );
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );
add_action( 'admin_bar_menu', function ( $leiste ) {
	$leiste->remove_node( 'comments' );
}, 999 );

/* ---------- Sicherheits-Header ---------- */

add_action( 'send_headers', function () {
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
} );

/* ---------- Aufgeraeumtes Backend ---------- */

// Das Dashboard soll den Kunden nicht mit WordPress-Nachrichten ueberfrachten.
add_action( 'wp_dashboard_setup', function () {
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
} );
