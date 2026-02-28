<?php
/** @var array<string,mixed> $context */
?>
<section class="lh-print-page <?php echo esc_attr( 'color' === $context['color'] ? 'is-color' : 'is-bw' ); ?>">
	<h2>Belohnungssystem</h2>
	<p>Klare Ziele, wenige Tokens, sofortige Rückmeldung.</p>
	<table class="lh-grid-table">
		<thead><tr><th>Ziel</th><th>Token pro Erfolg</th><th>Heute erreicht</th></tr></thead>
		<tbody>
		<?php for ( $i = 0; $i < 10; $i++ ) : ?>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td>☐</td></tr>
		<?php endfor; ?>
		</tbody>
	</table>
</section>
