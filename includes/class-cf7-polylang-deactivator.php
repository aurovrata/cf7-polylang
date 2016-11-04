<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
    //remove the CF7 custom post for polylang post types.
    if( is_plugin_active("contact-form-7/wp-contact-form-7.php") && defined ("POLYLANG_VERSION") ){
      $options = get_option('polylang',false);
      if( $options && in_array(WPCF7_ContactForm::post_type, $options['post_types']) ){
        $options['post_types'] = array_diff( $options['post_types'], array(WPCF7_ContactForm::post_type) );
        update_option('polylang',$options);
      }
    }
	}

}
