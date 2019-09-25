<?php
/**
 * Plugin Name: Salcode Current Temp Shortcode
 * Plugin URI: https://github.com/salcode/fe-current-temp-shortcode
 * Description: Add shortcode [fe_current_temp] to display the current temperature at the Latitude and Longitude using the Dark Sky API and WordPress transients.
 * Version: 0.1.0
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
