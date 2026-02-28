<?php
/**
 * Rule engine for planner pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve templates from form selections.
 */
class LH_Planer_Rule_Engine {

	/**
	 * Determine template pages.
	 *
	 * @param array<string,mixed> $selection user selection.
	 * @return array<int,string>
	 */
	public static function resolve_pages( $selection ) {
		$pages = array(
			'page-tagesstruktur',
			'page-wochenplan',
			'page-uebergaenge-erst-dann',
			'page-aufgaben-breaker',
		);

		$problem_fields = isset( $selection['problem_fields'] ) ? (array) $selection['problem_fields'] : array();
		$focus          = isset( $selection['focus'] ) ? sanitize_key( $selection['focus'] ) : '';

		$needs_rewards = in_array( $focus, array( 'adhs', 'beides' ), true )
			|| in_array( 'aufgaben_beginnen', $problem_fields, true )
			|| in_array( 'hausaufgaben_lernen', $problem_fields, true );

		if ( $needs_rewards ) {
			$pages[] = 'page-belohnungssystem';
		}

		$needs_sensory = in_array( $focus, array( 'autismus', 'beides' ), true )
			|| in_array( 'reizueberflutung', $problem_fields, true );

		if ( $needs_sensory ) {
			$pages[] = 'page-sensorik-pausenkarte';
			$pages[] = 'page-eskalationsplan';
		}

		return $pages;
	}
}
