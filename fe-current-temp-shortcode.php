<?php
/**
 * Plugin Name: Salcode Current Temp Shortcode
 * Plugin URI: https://github.com/salcode/fe-current-temp-shortcode
 * Description: Add shortcode [fe_current_temp] to display the current temperature at the Latitude and Longitude (defined in variables $fe_lat, $fe_lng) using the Dark Sky API and WordPress transients.
 * Version: 1.0.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * License: Apache-2.0
 * License URI: https://spdx.org/licenses/Apache-2.0.html
 * Text Domain: fe-current-temp-shortcode
 * Domain Path: /languages
 *
 * @package fe-current-temp-shortcode
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$fe_lat = '40.32';
$fe_lng = '-76.00';

/**
 * Get the current outdoor temperature.
 *
 * This value returns a cached value. The value is updated
 * at least once every 30 minutes.
 *
 * @return string The current temperature in degrees F, defaults to '?' if
 *                 no value returned.
 */
function fe_get_wp_temp_f() {
	$temp = get_transient( 'fe_wp_temp' );
	if ( false !== $temp ) {
		// We got a value from the transient, we're done.
		return $temp;
	}
	// We do NOT have a value in the transient, make the API call.
	$temp = fe_get_wp_temp_api_call();

	$max_transient_time = 30 * MINUTE_IN_SECONDS;

	if ( '?' === $temp ) {
		// No value was returned by the API call.
		// Only store this value for 30 seconds (instead of 30 minutes).
		$max_transient_time = 30;
	}

	// Cache the temperature for future use.
	set_transient(
		'fe_wp_temp',       // Transient key.
		$temp,              // Value to store.
		$max_transient_time // Max time to keep transient.
	);

	return $temp;
}

/**
 * Get current temperature via an API call.
 *
 * Uses global variables: $fe_lat, and $fe_lng.
 *
 * Note: This function is SLOW because it makes an remote request.
 *
 * @return string The current temperature in degrees F, defaults to '?' if
 *                 no value returned.
 */
function fe_get_wp_temp_api_call() {
	global $fe_lat, $fe_lng;
	try {
		$url = sprintf(
			'https://api.darksky.net/forecast/%1$s/%2$s,%3$s',
			FE_DARK_SKY_API, // My Secret DarkSky API key set in wp-config.php.
			$fe_lat,
			$fe_lng
		);

		$response = wp_remote_get( esc_url( $url ) );
		$body     = wp_remote_retrieve_body( $response );
		$weather  = json_decode( $body );
		$temp     = $weather->currently->temperature;
	} catch ( Exception $e ) {
		// Looking up the current temperature failed.
		return '?';
	}
	return $temp;
}

/**
 * [fe_current_temp]
 *
 * Display the current temperature for the Latitude and Longitude defined
 * in variables $fe_lat, $fe_lng
 *
 * The temperature is provided by the function fe_get_wp_temp_f().
 */
add_shortcode(
	'fe_current_temp',
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	function() {
		$temp_f = fe_get_wp_temp_f();

		return sprintf(
			sprintf(
				'<div class="alert alert-primary">%s<br><a href="https://darksky.net/poweredby/">Powered by Dark Sky</a></div>',
				sprintf(
					/* translators: %s is the temperature in degrees Fahrenheit. */
					esc_html__(
						'The current temperature is %s&deg; F',
						'fe-current-temp-shortcode'
					),
					esc_html( $temp_f )
				)
			)
		);
	}
);
