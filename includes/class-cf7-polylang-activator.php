<?php

/**
 * Fired during plugin activation
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang_Activator {

	/**
	 * Activation validation.
	 *
	 * Checks if Polylang and Contact Form 7 are installed before activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    //no need to make any special actionvation for multisite.
    //check if the dependent plugins are active
    if(!is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )){
      exit('This plugin requires the Contact Form 7 plugin to be installed first');
    }
    if(!is_plugin_active( 'polylang/polylang.php' )){
      exit('This plugin requires the Polylang plugin to be installed first');
    }
	}

}
