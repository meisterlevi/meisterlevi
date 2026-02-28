<?php
/** @var array<string,mixed> $context */
?>
<section class="lh-print-page <?php echo esc_attr( 'color' === $context['color'] ? 'is-color' : 'is-bw' ); ?>">
	<h2>Wochenplan</h2>
	<table class="lh-grid-table lh-week">
		<thead><tr><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><th>Samstag</th><th>Sonntag</th></tr></thead>
		<tbody>
			<?php for ( $i = 0; $i < 6; $i++ ) : ?>
				<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
			<?php endfor; ?>
		</tbody>
	</table>
</section>
