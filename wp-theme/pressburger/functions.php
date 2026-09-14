<?php
/**
 * Pressburger Consulting - Theme-Funktionen.
 *
 * Bewusst klein gehalten: Assets, Inhaltstyp "Erfolgsgeschichte",
 * Haertung, Einrichtung. Alles, was ein Plugin waere, steht hier -
 * damit es keine Plugins braucht.
 */

defined( 'ABSPATH' ) || exit;

define( 'PRESSBURGER_VERSION', '1.0.3' );

require_once get_theme_file_path( 'inc/erfolgsgeschichten.php' );
require_once get_theme_file_path( 'inc/haertung.php' );
require_once get_theme_file_path( 'inc/darstellung.php' );
require_once get_theme_file_path( 'inc/einrichtung.php' );
require_once get_theme_file_path( 'inc/anleitung.php' );

/* ---------- Theme-Unterstuetzung ---------- */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/style.css' );

	// Die mitgelieferten Core-Muster wuerden den Kunden nur ablenken.
	remove_theme_support( 'core-block-patterns' );

	// Bildgroessen fuer die Erfolgsgeschichten (3:2) und das Portrait.
	add_image_size( 'erfolg', 1264, 843, true );
	add_image_size( 'erfolg-klein', 800, 533, true );
	set_post_thumbnail_size( 1264, 843, true );
} );

/* ---------- Stylesheet und Skript ---------- */

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'pressburger',
		get_theme_file_uri( 'assets/style.css' ),
		array(),
		PRESSBURGER_VERSION
	);
	wp_enqueue_script(
		'pressburger',
		get_theme_file_uri( 'assets/main.js' ),
		array(),
		PRESSBURGER_VERSION,
		array( 'in_footer' => true )
	);
	// Ohne JavaScript ist alles sofort sichtbar; mit JS wird eingeblendet.
	wp_add_inline_script( 'pressburger', 'document.documentElement.className += " js";', 'before' );
} );

/* Das Inline-Skript muss vor dem Rendern laufen, sonst blitzt der Inhalt. */
add_action( 'wp_head', function () {
	echo '<script>document.documentElement.className += " js";</script>' . "\n";
}, 1 );

/* ---------- Vorschaubild fuer Messenger/LinkedIn und strukturierte Daten ---------- */

add_action( 'wp_head', function () {
	$titel = is_front_page() ? get_bloginfo( 'name' ) . ' – ' . get_bloginfo( 'description' ) : wp_get_document_title();
	$bild  = get_theme_file_uri( 'assets/bilder/og-bild.jpg' );
	$url   = is_front_page() ? home_url( '/' ) : get_permalink();
	$text  = 'Gute Anfragen allein reichen nicht aus. Entscheidend ist, was Ihr Betrieb daraus macht.';
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:locale" content="de_DE">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $titel ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $text ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $bild ) . '">' . "\n";
	echo '<meta property="og:image:width" content="1200"><meta property="og:image:height" content="630">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	if ( ! is_front_page() ) {
		return;
	}
	$daten = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'ProfessionalService',
		'name'          => 'Pressburger Consulting',
		'alternateName' => 'Vertrieb im Handwerk',
		'description'   => 'Vertriebscoaching für Handwerksbetriebe: aus bestehenden Anfragen mehr lukrative Aufträge gewinnen.',
		'url'           => home_url( '/' ),
		'telephone'     => '+49 175 8521935',
		'email'         => 'achim@pressburger-consulting.de',
		'founder'       => array( '@type' => 'Person', 'name' => 'Achim Pressburger' ),
		'address'       => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Barbarossastr. 68',
			'postalCode'      => '73732',
			'addressLocality' => 'Esslingen',
			'addressCountry'  => 'DE',
		),
		'areaServed'    => 'DE',
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $daten, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

/* ---------- Muster-Kategorie ---------- */

add_action( 'init', function () {
	register_block_pattern_category( 'pressburger', array(
		'label' => 'Pressburger Consulting',
	) );
} );

/* ---------- Kleinigkeiten ---------- */

// Menue-Knopf und Sprungmarken: der Kopf ist 88 px hoch.
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'pressburger';
	return $classes;
} );

// Der Textauszug einer Erfolgsgeschichte ist die Kennzahl - ohne "[...]".
add_filter( 'excerpt_more', '__return_empty_string' );
add_filter( 'excerpt_length', function () { return 40; } );
