<?php
/** @var array<string,mixed> $context */
$selection = $context['selection'];
?>
<section class="lh-print-page <?php echo esc_attr( 'color' === $context['color'] ? 'is-color' : 'is-bw' ); ?>">
	<h2>Tagesstruktur</h2>
	<p>Feste Reihenfolge mit klaren Zeitblöcken.</p>
	<table class="lh-grid-table">
		<thead><tr><th>Zeit</th><th>Aufgabe</th><th>Hilfen</th><th>Erledigt</th></tr></thead>
		<tbody>
		<?php for ( $i = 0; $i < 8; $i++ ) : ?>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td><?php echo $context['icons'] ? '☐ Visual' : '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td><td>☐</td></tr>
		<?php endfor; ?>
		</tbody>
	</table>
	<p class="lh-page-note">Setting: <?php echo esc_html( $selection['setting'] ); ?> · Zielgruppe: <?php echo esc_html( $selection['target_group'] ); ?></p>
</section>
