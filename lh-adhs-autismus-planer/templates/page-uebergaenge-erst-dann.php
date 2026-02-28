<?php
/** @var array<string,mixed> $context */
?>
<section class="lh-print-page <?php echo esc_attr( 'color' === $context['color'] ? 'is-color' : 'is-bw' ); ?>">
	<h2>Übergänge / Erst-Dann Karten</h2>
	<div class="lh-cards">
		<?php for ( $i = 0; $i < 6; $i++ ) : ?>
			<div class="lh-card">
				<strong>ERST</strong>
				<div class="lh-card-space"></div>
				<strong>DANN</strong>
				<div class="lh-card-space"></div>
			</div>
		<?php endfor; ?>
	</div>
</section>
