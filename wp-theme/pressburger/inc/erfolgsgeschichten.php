<?php
/**
 * Inhaltstyp "Erfolgsgeschichte".
 *
 * Titel = Ueberschrift, Textauszug = Kennzahl (die grosse Zeile),
 * Beitragsbild = das Foto, Inhalt = die Absaetze. Der Kunde legt eine
 * neue Geschichte an wie einen Beitrag - kein Plugin, keine Extrafelder.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	register_post_type( 'erfolg', array(
		'labels' => array(
			'name'                  => 'Erfolgsgeschichten',
			'singular_name'         => 'Erfolgsgeschichte',
			'add_new'               => 'Neue Geschichte',
			'add_new_item'          => 'Neue Erfolgsgeschichte',
			'edit_item'             => 'Erfolgsgeschichte bearbeiten',
			'new_item'              => 'Neue Erfolgsgeschichte',
			'view_item'             => 'Erfolgsgeschichte ansehen',
			'search_items'          => 'Erfolgsgeschichten durchsuchen',
			'not_found'             => 'Noch keine Erfolgsgeschichte angelegt.',
			'not_found_in_trash'    => 'Keine im Papierkorb.',
			'all_items'             => 'Alle Geschichten',
			'menu_name'             => 'Erfolgsgeschichten',
			'featured_image'        => 'Foto zur Geschichte',
			'set_featured_image'    => 'Foto festlegen',
			'remove_featured_image' => 'Foto entfernen',
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_position'=> 5,
		'menu_icon'    => 'dashicons-awards',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
		'rewrite'      => array( 'slug' => 'erfolgsgeschichte', 'with_front' => false ),
		'template'     => array(
			array( 'core/paragraph', array( 'placeholder' => 'Ausgangslage: Wo stand der Betrieb?' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'Vorgehen: Was wurde gemeinsam veraendert?' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'Ergebnis: Was ist dabei herausgekommen?' ) ),
		),
	) );
} );

// Platzhalter im Titelfeld, damit klar ist, was hinein soll.
add_filter( 'enter_title_here', function ( $text, $beitrag ) {
	return 'erfolg' === $beitrag->post_type
		? 'z. B. Badsanierung: Abschlüsse verdreifacht'
		: $text;
}, 10, 2 );

// Kurze Anleitung direkt im Bearbeitungsfenster.
add_action( 'add_meta_boxes_erfolg', function () {
	add_meta_box( 'pressburger-hinweis', 'So funktioniert eine Erfolgsgeschichte', function () {
		echo '<p style="margin:.4em 0"><strong>Titel</strong> – die Überschrift, z. B. „Balkonsanierung: 30 % mehr Abschlüsse“.</p>';
		echo '<p style="margin:.4em 0"><strong>Textauszug</strong> (rechts in der Seitenleiste) – die große Kennzahl in einer Zeile, z. B. „+30 % Abschlussquote · aus dem bestehenden Anfragevolumen“.</p>';
		echo '<p style="margin:.4em 0"><strong>Foto zur Geschichte</strong> – Querformat 3:2. Symbolbilder bitte als solche kennzeichnen.</p>';
		echo '<p style="margin:.4em 0"><strong>Reihenfolge</strong> – bestimmt die Position auf der Startseite (1 = oben).</p>';
	}, 'erfolg', 'side', 'high' );
} );
