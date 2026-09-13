<?php
/**
 * Title: Erfolgsgeschichten
 * Slug: pressburger/erfolgsgeschichten
 * Categories: pressburger
 * Description: Listet alle Erfolgsgeschichten (eigener Inhaltstyp) abwechselnd links/rechts.
 */
?>
<!-- wp:group {"tagName":"section","anchor":"erfolge","className":"section","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<section class="wp-block-group section" id="erfolge">
<!-- wp:group {"className":"wrap","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<div class="wp-block-group wrap">
<!-- wp:group {"className":"section-head reveal","layout":{"type":"default"}} -->
<div class="wp-block-group section-head reveal">
<!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Aus der Praxis</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Erfolgsgeschichten</h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":2,"query":{"perPage":12,"pages":0,"offset":0,"postType":"erfolg","order":"asc","orderBy":"menu_order","author":"","search":"","exclude":[],"sticky":"","inherit":false},"lock":{"move":true,"remove":true}} -->
<div class="wp-block-query">
<!-- wp:post-template {"className":"erfolge-liste"} -->
<!-- wp:post-featured-image {"className":"erfolg-bild","sizeSlug":"erfolg"} /-->
<!-- wp:group {"className":"erfolg-text","layout":{"type":"default"}} -->
<div class="wp-block-group erfolg-text">
<!-- wp:post-excerpt {"className":"kennzahl"} /-->
<!-- wp:post-title {"level":3,"isLink":true} /-->
<!-- wp:post-content /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Die erste Erfolgsgeschichte folgt in Kürze.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
