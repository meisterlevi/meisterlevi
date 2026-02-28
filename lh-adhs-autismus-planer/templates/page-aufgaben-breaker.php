<?php
/** @var array<string,mixed> $context */
?>
<section class="lh-print-page <?php echo esc_attr( 'color' === $context['color'] ? 'is-color' : 'is-bw' ); ?>">
	<h2>Aufgaben-Breaker</h2>
	<ol class="lh-breaker-list">
		<li>Aufgabe benennen</li>
		<li>Mini-Schritt 1 (2–5 Minuten)</li>
		<li>Kurzpause</li>
		<li>Mini-Schritt 2</li>
		<li>Review: Was hat funktioniert?</li>
	</ol>
	<table class="lh-grid-table"><tbody>
		<?php for ( $i = 0; $i < 8; $i++ ) : ?>
		<tr><td>Schritt</td><td>&nbsp;</td><td>Dauer</td><td>&nbsp;</td><td>Pause</td><td>&nbsp;</td></tr>
		<?php endfor; ?>
	</tbody></table>
</section>
