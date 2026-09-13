<?php
/**
 * Pressburger Consulting - Theme-Funktionen.
 *
 * Bewusst klein gehalten: Assets, Inhaltstyp "Erfolgsgeschichte",
 * Haertung, Einrichtung. Alles, was ein Plugin waere, steht hier -
 * damit es keine Plugins braucht.
 */

defined( 'ABSPATH' ) || exit;

define( 'PRESSBURGER_VERSION', '1.0.0' );

require_once get_theme_file_path( 'inc/erfolgsgeschichten.php' );
require_once get_theme_file_path( 'inc/haertung.php' );
require_once get_theme_file_path( 'inc/einrichtung.php' );

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
