<?php
/**
 * Title: Über mich
 * Slug: pressburger/ueber-mich
 * Categories: pressburger
 * Description: Portrait und Werdegang.
 */
// Das Portrait aus der Mediathek (bei der Einrichtung hochgeladen); solange es
// fehlt, die Datei aus dem Theme - dann ist das Muster auch im Einfuegen-Dialog gueltig.
$gefunden = get_posts( array(
	'post_type'   => 'attachment',
	'meta_key'    => '_pressburger_quelle',
	'meta_value'  => 'achim-pressburger.webp',
	'numberposts' => 1,
	'post_status' => 'any',
) );
$bild_id  = $gefunden ? (int) $gefunden[0]->ID : 0;
$bild_url = $bild_id ? wp_get_attachment_image_url( $bild_id, 'full' ) : get_theme_file_uri( 'assets/bilder/achim-pressburger.webp' );
?>
<!-- wp:group {"tagName":"section","anchor":"ueber-mich","className":"section","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<section class="wp-block-group section" id="ueber-mich">
<!-- wp:group {"className":"wrap","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<div class="wp-block-group wrap">
<!-- wp:group {"className":"section-head reveal","layout":{"type":"default"}} -->
<div class="wp-block-group section-head reveal">
<!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Über mich</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Achim Pressburger</h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"about reveal","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<div class="wp-block-group about reveal">
<!-- wp:image {"id":<?php echo $bild_id; ?>,"sizeSlug":"full","className":"portrait","lock":{"move":true,"remove":true}} -->
<figure class="wp-block-image size-full portrait"><img src="<?php echo $bild_url; ?>" alt="Achim Pressburger" class="wp-image-<?php echo $bild_id; ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"prosa","layout":{"type":"default"}} -->
<div class="wp-block-group prosa">
<!-- wp:paragraph {"className":"role"} -->
<p class="role">Mein Werdegang</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Seit über 30 Jahren bin ich mit Leidenschaft in unterschiedlichen Branchen und Vertriebsumfeldern tätig. Dabei habe ich umfassende praktische Erfahrungen gesammelt – vom operativen Tagesgeschäft bis zur strategischen Geschäftsentwicklung.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Mein beruflicher Weg hat mich gelehrt, worauf es im Verkauf wirklich ankommt: Menschen verstehen, Vertrauen aufbauen, Chancen konsequent nutzen und aus klaren Prozessen nachhaltiges Wachstum entwickeln. Dabei verbinde ich praxisnahe Vertriebserfahrung mit einem ausgeprägten Gespür für wirtschaftliche Zusammenhänge, Kundenbedürfnisse und erfolgreiche Geschäftsentwicklung.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Seit drei Jahren bringe ich dieses Wissen gezielt im Vertriebscoaching ein. Ich unterstütze hauptsächlich Handwerksbetriebe dabei, ihre Stärken besser zu nutzen, ihre Verkaufsaktivitäten wirksamer zu strukturieren und neue Kundenpotenziale erfolgreich zu erschließen. Mein Anspruch ist es, auf Ihr Geschäft zugeschnittene umsetzbare Lösungen zu entwickeln, die im Arbeitsalltag den erwünschten Erfolg erzielen.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
