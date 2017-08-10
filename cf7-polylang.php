<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://syllogic.in
 * @since             1.0.0
 * @package           Cf7_Polylang
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 Polylang extension
 * Plugin URI:        http://wordpress.syllogic.in
 * Description:       This plugin extends <a target="_blank" href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> plugin to manage multiple language forms using the <a target="_blank" href="https://wordpress.org/plugins/polylang/">PolyLang</a> plugin. It Requires both plugins to be active first.
 * Version:           1.4.5
 * Author:            Aurovrata V.
 * Author URI:        http://syllogic.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-polylang
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'CF7_POLYLANG_PATH', plugin_dir_path( __FILE__ ) );
define( 'CF7_POLYLANG_VERSION', '1.4.5' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf7-polylang-activator.php
 */
function activate_cf7_polylang() {
	require_once CF7_POLYLANG_PATH . 'includes/class-cf7-polylang-activator.php';
	Cf7_Polylang_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf7-polylang-deactivator.php
 */
function deactivate_cf7_polylang() {
	require_once CF7_POLYLANG_PATH . 'includes/class-cf7-polylang-deactivator.php';
	Cf7_Polylang_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cf7_polylang' );
register_deactivation_hook( __FILE__, 'deactivate_cf7_polylang' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require CF7_POLYLANG_PATH . 'includes/class-cf7-polylang.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf7_polylang() {

	$plugin = new Cf7_Polylang(CF7_POLYLANG_VERSION);
	$plugin->run();

}
run_cf7_polylang();
