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
    $notices= array(
      'admin.php'=>array(),
      'plugins.php'=>array(),
      'post.php'=>array(),
      'edit.php'=>array(),
    );
    //no need to make any special actionvation for multisite.
    //check if the dependent plugins are active
    if(!is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )){
      exit(__('This plugin requires the Contact Form 7 plugin to be installed first', 'cf7-polylang'));
    }

    if(!is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )){
      /**
      *@since 2.1.0
      */
      $nonce = wp_create_nonce( 'cf7_polylang_notice' );
      $notice = array(
          'nonce'=>$nonce,
          'type'=>'notice-warning',
          'msg'=> __('Contact Form 7 Polylang extension <strong>WARNING</strong>: due to the evolution of Polylang plugin, and non-WP standard coded CF7 plugin, this plugin is now an extension of the <a href="https://wordpress.org/plugins/cf7-grid-layout/">CF7 Smart Grid-layout</a> plugin.<br /> Please install it to get the full functionality of PolyLang in CF7 admin pages. If you choose not to install it, your existing forms will continue to work, but you will not be able to create <em>new translations</em>. More information on the plugin <a href="https://wordpress.org/plugins/cf7-polylang/">page</a>.', 'cf7-polylang')
      );
      $notices['admin.php']['page=wpcf7']=$notice;
      $notices['plugins.php']['any']=$notice;
    }
    //is polylang installed?
    if(!defined ("POLYLANG_VERSION") ){
      exit(__('This plugin requires the Polylang plugin to be installed first','cf7-polylang'));
    }
    //check if we have languages setup.
    $languages= pll_languages_list();
    if( function_exists('pll_languages_list') && empty( $languages ) ){
      $nonce = wp_create_nonce( 'cf7_polylang_notice' );
      $link = admin_url('admin.php?page=mlang');
      $notice = array(
          'nonce'=>$nonce,
          'type'=>'notice-warning',
          'msg'=>sprintf( __('You need to set up your <a href="%s" target="_parent">languages</a> in Polylang first.','cf7-polylang'), $link)
        );

      $notices['admin.php']['polylang']=$notice;
      $notices['edit.php']['polylang']=$notice;
      $notices['post.php']['polylang']=$notice;
      $notices['plugins.php']['polylang']=$notice;

    }
    update_option('cf7-polylang-admin-notices', $notices);
  }

}
