<?php
/**
 * Kleine Darstellungshelfer fuer Core-Bloecke.
 */

defined( 'ABSPATH' ) || exit;

/*
 * Textauszug einer Erfolgsgeschichte = Kennzahl. Der Kunde schreibt eine Zeile,
 * z. B. "Abschluesse verdreifacht · Ø Auftragswert rund 30.000 €". Vor dem
 * Punkt steht die grosse Zeile, dahinter die kleine.
 */
add_filter( 'render_block_core/post-excerpt', function ( $html, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'kennzahl' ) ) {
		return $html;
	}
	$id = isset( $block['context']['postId'] ) ? (int) $block['context']['postId'] : get_the_ID();
	if ( ! $id || 'erfolg' !== get_post_type( $id ) ) {
		return $html;
	}
	$text = trim( wp_strip_all_tags( get_the_excerpt( $id ) ) );
	if ( '' === $text ) {
		return '';
	}
	$teile = array_map( 'trim', explode( '·', $text, 2 ) );
	$gross = esc_html( $teile[0] );
	$klein = isset( $teile[1] ) ? '<span>' . esc_html( $teile[1] ) . '</span>' : '';
	return '<div class="wp-block-post-excerpt kennzahl"><p class="wp-block-post-excerpt__excerpt"><strong>' . $gross . '</strong>' . $klein . '</p></div>';
}, 10, 2 );

/*
 * Beitragsbild mit Bildunterschrift aus der Mediathek ("Symbolbild").
 * Der Kunde pflegt den Hinweis am Bild, nicht im Text.
 */
add_filter( 'render_block_core/post-featured-image', function ( $html, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'erfolg-bild' ) ) {
		return $html;
	}
	$id = isset( $block['context']['postId'] ) ? (int) $block['context']['postId'] : get_the_ID();
	$bild = $id ? get_post_thumbnail_id( $id ) : 0;
	$unterschrift = $bild ? trim( wp_get_attachment_caption( $bild ) ) : '';
	if ( '' === $unterschrift || false === strpos( $html, '</figure>' ) ) {
		return $html;
	}
	return str_replace( '</figure>', '<figcaption>' . esc_html( $unterschrift ) . '</figcaption></figure>', $html );
}, 10, 2 );
