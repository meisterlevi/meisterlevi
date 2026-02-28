<?php
/**
 * Form handling for planner.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Form helper class.
 */
class LH_Planer_Form {

	/**
	 * Field options.
	 *
	 * @return array<string,array<string,string>>
	 */
	public static function get_options() {
		return array(
			'target_group'   => array(
				'kind_4_7'       => 'Kind 4–7',
				'kind_8_12'      => 'Kind 8–12',
				'teen_13_17'     => 'Teen 13–17',
				'erwachsen'      => 'Erwachsen',
			),
			'setting'        => array(
				'zuhause'        => 'Zuhause',
				'schule'         => 'Schule',
				'arbeit'         => 'Arbeit',
				'gemischt'       => 'gemischt',
			),
			'focus'          => array(
				'adhs'           => 'ADHS',
				'autismus'       => 'Autismus',
				'beides'         => 'beides',
			),
			'problem_fields' => array(
				'morgenroutine'          => 'Morgenroutine',
				'hausaufgaben_lernen'    => 'Hausaufgaben/Lernen',
				'aufgaben_beginnen'      => 'Aufgaben anfangen/zu Ende bringen',
				'uebergaenge_wechsel'    => 'Übergänge/Wechsel',
				'reizueberflutung'       => 'Reizüberflutung/Überforderung',
				'impulsivitaet_streit'   => 'Impulsivität/Streit',
				'schlaf_abendroutine'    => 'Schlaf/Abendroutine',
				'vergessen_organisation' => 'Vergessen/Organisation',
			),
			'color_mode'     => array(
				'blackwhite'     => 'Schwarzweiß',
				'color'          => 'Farbig',
			),
			'icons'          => array(
				'yes'            => 'Icons ja',
				'no'             => 'Icons nein',
			),
		);
	}

	/**
	 * Get default/persisted form state in request.
	 *
	 * @return array<string,mixed>
	 */
	public static function get_form_state() {
		return array(
			'target_group'   => '',
			'setting'        => '',
			'focus'          => '',
			'problem_fields' => array(),
			'color_mode'     => 'blackwhite',
			'icons'          => 'yes',
		);
	}

	/**
	 * Check if this is plugin form submission.
	 *
	 * @return bool
	 */
	public static function is_submission() {
		$action = isset( $_POST['lh_planer_action'] ) ? sanitize_key( wp_unslash( $_POST['lh_planer_action'] ) ) : '';
		return 'generate_planer' === $action;
	}

	/**
	 * Process submit.
	 *
	 * @return array{errors:array<int,string>,selection:array<string,mixed>,form_state:array<string,mixed>}
	 */
	public static function process_submission() {
		$errors  = array();
		$options = self::get_options();
		$state   = self::get_form_state();

		$nonce = isset( $_POST['lh_planer_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['lh_planer_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'lh_planer_generate' ) ) {
			$errors[] = __( 'Sicherheitsprüfung fehlgeschlagen. Bitte Formular erneut senden.', 'lh-adhs-autismus-planer' );
			return array(
				'errors'    => $errors,
				'selection' => array(),
				'form_state' => $state,
			);
		}

		$state['target_group'] = self::sanitize_single_choice( 'target_group', $options );
		$state['setting']      = self::sanitize_single_choice( 'setting', $options );
		$state['focus']        = self::sanitize_single_choice( 'focus', $options );
		$state['color_mode']   = self::sanitize_single_choice( 'color_mode', $options, 'blackwhite' );
		$state['icons']        = self::sanitize_single_choice( 'icons', $options, 'yes' );
		$state['problem_fields'] = self::sanitize_multi_choice( 'problem_fields', $options );

		if ( '' === $state['target_group'] || '' === $state['setting'] || '' === $state['focus'] ) {
			$errors[] = __( 'Bitte alle Pflichtfelder in den Schritten 1–3 ausfüllen.', 'lh-adhs-autismus-planer' );
		}

		$problem_count = count( $state['problem_fields'] );
		if ( $problem_count < 3 || $problem_count > 5 ) {
			$errors[] = __( 'Bitte 3 bis 5 Problemfelder auswählen.', 'lh-adhs-autismus-planer' );
		}

		return array(
			'errors'     => $errors,
			'selection'  => empty( $errors ) ? $state : array(),
			'form_state' => $state,
		);
	}

	/**
	 * Sanitize single choice field.
	 *
	 * @param string                             $field field name.
	 * @param array<string,array<string,string>> $options options map.
	 * @param string                             $fallback fallback value.
	 * @return string
	 */
	private static function sanitize_single_choice( $field, $options, $fallback = '' ) {
		$value = isset( $_POST[ $field ] ) ? sanitize_key( wp_unslash( $_POST[ $field ] ) ) : '';
		if ( isset( $options[ $field ][ $value ] ) ) {
			return $value;
		}
		return $fallback;
	}

	/**
	 * Sanitize checkbox group.
	 *
	 * @param string                             $field field name.
	 * @param array<string,array<string,string>> $options options map.
	 * @return array<int,string>
	 */
	private static function sanitize_multi_choice( $field, $options ) {
		$raw = isset( $_POST[ $field ] ) ? (array) wp_unslash( $_POST[ $field ] ) : array();

		$items = array();
		foreach ( $raw as $item ) {
			$key = sanitize_key( $item );
			if ( isset( $options[ $field ][ $key ] ) ) {
				$items[] = $key;
			}
		}

		$items = array_values( array_unique( $items ) );
		return $items;
	}
}
