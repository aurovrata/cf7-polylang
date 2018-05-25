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
    if(!is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )){
      /**
      *@since 2.1.0
      */
      $nonce = wp_create_nonce( 'cf7_polylang_notice' );
      $notice = array(
          'nonce'=>$nonce,
          'type'=>'notice-warning',
          'msg'=> __('<strong>WARNING</strong>: due to the evolution of PolyLang plugin, and non-WP standard coded CF7 plugin, this plugin is now an extension of the <a href="https://wordpress.org/plugins/cf7-grid-layout/">CF7 Smart Grid-layout</a> plugin.<br /> Please install it to get the full functionality of PolyLang in CF7 admin pages. If you choose not to install it, your existing forms will continue to work, but you will not be able to create new translations. More information on the plugin <a href="https://wordpress.org/plugins/cf7-polylang/">page</a>.', 'cf7-polylang')
      );
      $notices=array(
          'admin.php'=>array(
              'page=wpcf7'=>$notice,
          ),
          'plugins.php'=>array(
              'any'=>$notice
          )
      );
      update_option('cf7-polylang-admin-notices', $notices);
    }else{
      $notices = get_option('cf7-polylang-admin-notices', array());
      if(isset($notices['admin.php'])) unset($notices['admin.php']);
      if(isset($notices['plugins.php'])) unset($notices['plugins.php']);
      update_option('cf7-polylang-admin-notices', $notices);
    }
    if(!defined ("POLYLANG_VERSION") ){
      exit('This plugin requires the Polylang plugin to be installed first');
    }
    $languages= pll_languages_list();
    if( function_exists('pll_languages_list') && empty( $languages ) ){
      $msg = 'You need to set up your <a href="'.admin_url('admin.php?page=mlang_settings').'" target="_parent">languages</a> in Polylang first.';
      exit($msg);
    }
	}

}
