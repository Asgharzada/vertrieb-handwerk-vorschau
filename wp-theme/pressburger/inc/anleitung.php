<?php
/**
 * Anleitung fuer den Kunden - direkt im Backend, damit sie nicht verloren geht.
 * Menuepunkt "Anleitung" ganz oben in der linken Leiste.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	add_menu_page( 'Anleitung', 'Anleitung', 'edit_posts', 'pressburger-anleitung', 'pressburger_anleitung_seite', 'dashicons-book', 2 );
} );

function pressburger_anleitung_seite() {
	$start = get_option( 'page_on_front' );
	$start_link = $start ? admin_url( 'post.php?post=' . (int) $start . '&action=edit' ) : admin_url( 'edit.php?post_type=page' );
	?>
	<div class="wrap" style="max-width:52rem">
		<h1>So pflegen Sie Ihre Website</h1>
		<p style="font-size:1.05em">Alles, was Sie regelmäßig brauchen, in vier Schritten. Was hier nicht steht, machen Sie am besten nicht – oder schreiben kurz eine Nachricht.</p>

		<h2>1. Einen Text auf der Startseite ändern</h2>
		<ol>
			<li>Links auf <strong>Seiten → Alle Seiten → Startseite</strong> klicken – oder direkt <a href="<?php echo esc_url( $start_link ); ?>">hier</a>.</li>
			<li>In den Text klicken, den Sie ändern möchten, und einfach tippen. Absätze verhalten sich wie in Word.</li>
			<li>Oben rechts auf <strong>Aktualisieren</strong> klicken. Fertig – die Änderung ist sofort online.</li>
		</ol>
		<p><em>Die Abschnitte selbst (Kopfbereich, Leistung, Erfolgsgeschichten …) sind fest verankert. Sie können sie nicht versehentlich löschen oder verschieben. Der Text darin ist frei.</em></p>

		<h2>2. Eine Erfolgsgeschichte hinzufügen</h2>
		<ol>
			<li>Links auf <strong>Erfolgsgeschichten → Neue Geschichte</strong>.</li>
			<li><strong>Titel</strong> eingeben, z. B. „Dachsanierung: Angebotsquote verdoppelt“.</li>
			<li>Die drei Absätze schreiben: Ausgangslage, Vorgehen, Ergebnis.</li>
			<li>Rechts in der Seitenleiste unter <strong>Textauszug</strong> die Kennzahl eintragen – eine Zeile, der Punkt „·“ trennt groß und klein: <code>Angebotsquote verdoppelt · innerhalb von sechs Monaten</code></li>
			<li>Rechts unter <strong>Foto zur Geschichte</strong> ein Bild im Querformat wählen oder hochladen. Bei Symbolbildern in der Mediathek als Beschriftung „Symbolbild“ eintragen.</li>
			<li>Rechts unter <strong>Reihenfolge</strong> eine Zahl setzen: 1 steht ganz oben.</li>
			<li><strong>Veröffentlichen</strong>. Die Geschichte erscheint automatisch auf der Startseite.</li>
		</ol>

		<h2>3. Einen Blogbeitrag schreiben</h2>
		<ol>
			<li>Links auf <strong>Beiträge → Erstellen</strong>.</li>
			<li>Titel, Text, bei Bedarf rechts ein <strong>Beitragsbild</strong>.</li>
			<li><strong>Veröffentlichen</strong>. Der Beitrag erscheint unter <code>/blog/</code>. Wenn Sie den Blog im Menü verlinken möchten, sagen Sie kurz Bescheid.</li>
		</ol>

		<h2>4. Kontaktdaten, Impressum, Datenschutz</h2>
		<ul>
			<li>Telefon, E-Mail und Anschrift stehen auf der <strong>Startseite</strong> im Abschnitt Kontakt – dort wie unter 1. ändern.</li>
			<li><strong>Impressum</strong> und <strong>Datenschutzerklärung</strong> finden Sie unter Seiten → Alle Seiten.</li>
			<li>Anfragen aus dem Kontaktformular kommen als E-Mail an achim@pressburger-consulting.de. Absender und Empfänger stehen unter <strong>Formulare → Kontakt → E-Mail</strong>.</li>
		</ul>

		<h2>Was Sie nicht tun müssen</h2>
		<ul>
			<li><strong>Updates:</strong> laufen automatisch. Wenn oben eine Zahl bei „Aktualisierungen“ steht, dürfen Sie sie anklicken und ausführen – oder liegen lassen.</li>
			<li><strong>Sicherungen:</strong> UpdraftPlus sichert wöchentlich von selbst.</li>
			<li><strong>Design → Website-Editor:</strong> dort lässt sich das Aussehen der Seite verstellen. Bitte nur nach Absprache.</li>
			<li><strong>Plugins installieren:</strong> bitte nicht ohne Rücksprache – jedes Plugin ist ein Sicherheitsrisiko und braucht Pflege.</li>
		</ul>

		<h2>Wenn etwas schiefgeht</h2>
		<p>Jede Änderung lässt sich zurücknehmen: Im Editor oben links der Pfeil <strong>Rückgängig</strong>, oder rechts in der Seitenleiste unter <strong>Revisionen</strong> eine frühere Fassung wiederherstellen.</p>
		<p>Bei allem anderen: <a href="mailto:asgharzada85@gmail.com">asgharzada85@gmail.com</a> – die technische Betreuung ist in Ihrem Paket enthalten.</p>
	</div>
	<?php
}
