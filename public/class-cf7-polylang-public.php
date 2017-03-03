<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/public
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-polylang-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cf7-polylang-public.js', array( 'jquery' ), $this->version, false );

	}
  /**
   * Get the translated form id
   * Hooked on 'cf7_form_shortcode_form_id'
   * @since 1.0.0
   * @param      String    $id     id to translate.
   * @param      Array     $atts     form attributes.
   * @return     String     translated id.
  **/
  public function translate_form_id($id, $atts){
    $default_lang = pll_default_language('slug');
    $current_lang = pll_current_language('slug');
    $form_id = pll_get_post($id, $current_lang);
    if(empty($form_id)){ //if a translation does not exists
      $form_id = $id;
    }
    return $form_id;
  }
}
