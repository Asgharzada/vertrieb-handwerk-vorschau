<?php
/**
 * Title: Kopfbereich
 * Slug: pressburger/hero
 * Categories: pressburger
 * Description: Grosse Ueberschrift, Kernaussage, zwei Knoepfe.
 */
$deko = file_get_contents( get_theme_file_path( 'inc/inhalte/hero-deko.svg' ) );
?>
<!-- wp:group {"tagName":"section","anchor":"top","className":"hero","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<section class="wp-block-group hero" id="top">
<!-- wp:html {"lock":{"move":true,"remove":true}} -->
<?php echo $deko; ?>
<!-- /wp:html -->

<!-- wp:group {"className":"wrap hero-inner","lock":{"move":true,"remove":true},"layout":{"type":"default"}} -->
<div class="wp-block-group wrap hero-inner">
<!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow">Vertriebscoaching für Handwerksbetriebe</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Vertrieb im Handwerk</h1>
<!-- /wp:heading -->

<!-- wp:separator {"className":"rule","lock":{"move":true,"remove":true}} -->
<hr class="wp-block-separator rule"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"className":"claim"} -->
<p class="claim">Gute Anfragen allein reichen <em>nicht</em> aus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"lead"} -->
<p class="lead">Entscheidend ist, was Ihr Betrieb daraus macht: Werden potenzielle Kunden schnell erreicht, richtig qualifiziert, professionell beraten und konsequent bis zum Abschluss begleitet? Genau hier unterstützen wir Handwerksbetriebe dabei, aus bestehenden Anfragen mehr lukrative Aufträge zu gewinnen.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"hero-actions"} -->
<div class="wp-block-buttons hero-actions">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/#kontakt">Kostenloses Orientierungsgespräch</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/#erfolge">Erfolgsgeschichten ansehen</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"hero-anruf"} -->
<p class="hero-anruf">Oder direkt anrufen: <a href="tel:+491758521935">0175 852 19 35</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"hero-meta"} -->
<p class="hero-meta">30 Jahre Vertrieb · Abschlüsse verdreifacht · +30 % Abschlussquote</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
