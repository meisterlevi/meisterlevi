<?php
/**
 * Plugin Name: LH ADHS/Autismus Planer
 * Plugin URI: https://lh-ergotherapie.de
 * Description: Multi-Step Frontend-Generator für druckbare ADHS/Autismus-Planer (ohne Datenspeicherung).
 * Version: 1.0.1
 * Author: LH Ergotherapie
 * License: GPL-2.0-or-later
 * Text Domain: lh-adhs-autismus-planer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LH_PLANER_VERSION', '1.0.1' );
define( 'LH_PLANER_PATH', plugin_dir_path( __FILE__ ) );
define( 'LH_PLANER_URL', plugin_dir_url( __FILE__ ) );

require_once LH_PLANER_PATH . 'includes/class-lh-planer-form.php';
require_once LH_PLANER_PATH . 'includes/class-lh-planer-rule-engine.php';

/**
 * Main plugin bootstrap.
 */
class LH_ADHS_Autismus_Planer {

	/**
	 * Init hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_shortcode( 'lh_planer', array( __CLASS__, 'render_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
	}

	/**
	 * Register assets.
	 *
	 * @return void
	 */
	public static function register_assets() {
		wp_register_style(
			'lh-planer-style',
			LH_PLANER_URL . 'assets/css/lh-planer.css',
			array(),
			LH_PLANER_VERSION
		);

		wp_register_script(
			'lh-planer-script',
			LH_PLANER_URL . 'assets/js/lh-planer.js',
			array(),
			LH_PLANER_VERSION,
			true
		);
	}

	/**
	 * Render shortcode output.
	 *
	 * @return string
	 */
	public static function render_shortcode() {
		wp_enqueue_style( 'lh-planer-style' );
		wp_enqueue_script( 'lh-planer-script' );

		$form_state = LH_Planer_Form::get_form_state();
		$selection  = array();
		$errors     = array();

		if ( LH_Planer_Form::is_submission() ) {
			$result = LH_Planer_Form::process_submission();
			$errors = $result['errors'];

			if ( empty( $errors ) ) {
				$selection = $result['selection'];
			}

			$form_state = $result['form_state'];
		}

		ob_start();
		?>
		<div class="lh-planer" data-lh-planer>
			<?php if ( ! empty( $errors ) ) : ?>
				<div class="lh-planer__errors" role="alert" aria-live="assertive">
					<ul>
						<?php foreach ( $errors as $error ) : ?>
							<li><?php echo esc_html( $error ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php self::render_form( $form_state ); ?>

			<?php if ( ! empty( $selection ) ) : ?>
				<?php self::render_result( $selection ); ?>
			<?php endif; ?>
		</div>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Render multistep form.
	 *
	 * @param array<string,mixed> $form_state form state.
	 * @return void
	 */
	private static function render_form( $form_state ) {
		$options = LH_Planer_Form::get_options();
		?>
		<form method="post" class="lh-planer__form" data-lh-planer-form>
			<?php wp_nonce_field( 'lh_planer_generate', 'lh_planer_nonce' ); ?>
			<input type="hidden" name="lh_planer_action" value="generate_planer" />

			<div class="lh-stepper" aria-live="polite">
				<div class="lh-stepper__status">
					<?php echo esc_html__( 'Schritt', 'lh-adhs-autismus-planer' ); ?>
					<span data-lh-step-current>1</span>/5
				</div>

				<section class="lh-step is-active" data-lh-step="1">
					<h3><?php echo esc_html__( '1) Zielgruppe', 'lh-adhs-autismus-planer' ); ?></h3>
					<?php self::render_radio_group( 'target_group', $options['target_group'], $form_state['target_group'] ); ?>
				</section>

				<section class="lh-step" data-lh-step="2">
					<h3><?php echo esc_html__( '2) Setting', 'lh-adhs-autismus-planer' ); ?></h3>
					<?php self::render_radio_group( 'setting', $options['setting'], $form_state['setting'] ); ?>
				</section>

				<section class="lh-step" data-lh-step="3">
					<h3><?php echo esc_html__( '3) Schwerpunkt', 'lh-adhs-autismus-planer' ); ?></h3>
					<?php self::render_radio_group( 'focus', $options['focus'], $form_state['focus'] ); ?>
				</section>

				<section class="lh-step" data-lh-step="4">
					<h3><?php echo esc_html__( '4) Problemfelder (3–5 wählen)', 'lh-adhs-autismus-planer' ); ?></h3>
					<?php self::render_checkbox_group( 'problem_fields', $options['problem_fields'], $form_state['problem_fields'] ); ?>
				</section>

				<section class="lh-step" data-lh-step="5">
					<h3><?php echo esc_html__( '5) Layout', 'lh-adhs-autismus-planer' ); ?></h3>
					<?php self::render_radio_group( 'color_mode', $options['color_mode'], $form_state['color_mode'] ); ?>
					<?php self::render_radio_group( 'icons', $options['icons'], $form_state['icons'] ); ?>
				</section>
			</div>

			<div class="lh-planer__controls no-print">
				<button type="button" class="lh-button" data-lh-prev>
					<?php echo esc_html__( 'Zurück', 'lh-adhs-autismus-planer' ); ?>
				</button>
				<button type="button" class="lh-button lh-button--primary" data-lh-next>
					<?php echo esc_html__( 'Weiter', 'lh-adhs-autismus-planer' ); ?>
				</button>
				<button type="submit" class="lh-button lh-button--primary" data-lh-submit>
					<?php echo esc_html__( 'Planer erstellen', 'lh-adhs-autismus-planer' ); ?>
				</button>
			</div>
		</form>
		<?php
	}

	/**
	 * Render result and print view.
	 *
	 * @param array<string,mixed> $selection sanitized data.
	 * @return void
	 */
	private static function render_result( $selection ) {
		$pages = LH_Planer_Rule_Engine::resolve_pages( $selection );
		$options = LH_Planer_Form::get_options();

		$problem_labels = array();
		foreach ( $selection['problem_fields'] as $problem_key ) {
			if ( isset( $options['problem_fields'][ $problem_key ] ) ) {
				$problem_labels[] = $options['problem_fields'][ $problem_key ];
			}
		}

		$meta_html = sprintf(
			'<strong>Zielgruppe:</strong> %1$s · <strong>Setting:</strong> %2$s · <strong>Schwerpunkt:</strong> %3$s<br /><strong>Problemfelder:</strong> %4$s',
			esc_html( $options['target_group'][ $selection['target_group'] ] ),
			esc_html( $options['setting'][ $selection['setting'] ] ),
			esc_html( $options['focus'][ $selection['focus'] ] ),
			esc_html( implode( ', ', $problem_labels ) )
		);
		?>
		<div class="lh-planer__result" id="lh-planer-result">
			<div class="no-print lh-planer__toolbar">
				<button type="button" class="lh-button lh-button--primary" onclick="window.print();">
					<?php echo esc_html__( 'Drucken / als PDF speichern', 'lh-adhs-autismus-planer' ); ?>
				</button>
			</div>

			<p class="lh-planer__disclaimer">
				<?php echo esc_html__( 'Strukturhilfe, kein medizinischer Rat. Keine Diagnose. Bei Krisen bitte an Notruf bzw. lokale Krisendienste wenden.', 'lh-adhs-autismus-planer' ); ?>
			</p>

			<div class="lh-planer__meta">
				<?php echo wp_kses_post( $meta_html ); ?>
			</div>

			<div class="lh-print-package">
				<?php foreach ( $pages as $template ) : ?>
					<?php self::render_template_page( $template, $selection ); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render radio options.
	 *
	 * @param string               $name field name.
	 * @param array<string,string> $choices field choices.
	 * @param string               $selected selected value.
	 * @return void
	 */
	private static function render_radio_group( $name, $choices, $selected ) {
		foreach ( $choices as $value => $label ) {
			$field_id = $name . '-' . $value;
			?>
			<label for="<?php echo esc_attr( $field_id ); ?>" class="lh-choice">
				<input
					type="radio"
					id="<?php echo esc_attr( $field_id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					<?php checked( $selected, $value ); ?>
					required
				/>
				<span><?php echo esc_html( $label ); ?></span>
			</label>
			<?php
		}
	}

	/**
	 * Render checkbox options.
	 *
	 * @param string               $name field name.
	 * @param array<string,string> $choices field choices.
	 * @param array<int,string>    $selected selected values.
	 * @return void
	 */
	private static function render_checkbox_group( $name, $choices, $selected ) {
		foreach ( $choices as $value => $label ) {
			$field_id = $name . '-' . $value;
			?>
			<label for="<?php echo esc_attr( $field_id ); ?>" class="lh-choice">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $field_id ); ?>"
					name="<?php echo esc_attr( $name ); ?>[]"
					value="<?php echo esc_attr( $value ); ?>"
					<?php checked( in_array( $value, $selected, true ) ); ?>
				/>
				<span><?php echo esc_html( $label ); ?></span>
			</label>
			<?php
		}
	}

	/**
	 * Render a template page.
	 *
	 * @param string               $template template slug.
	 * @param array<string,mixed> $selection sanitized user data.
	 * @return void
	 */
	private static function render_template_page( $template, $selection ) {
		$file = LH_PLANER_PATH . 'templates/' . sanitize_file_name( $template ) . '.php';

		if ( ! file_exists( $file ) ) {
			return;
		}

		$context = array(
			'selection' => $selection,
			'icons'     => 'yes' === $selection['icons'],
			'color'     => $selection['color_mode'],
		);

		include $file;
	}
}

LH_ADHS_Autismus_Planer::init();
