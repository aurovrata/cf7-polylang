<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cf7_Polylang_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($version) {

		$this->plugin_name = 'cf7-polylang';
		$this->version = $version;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cf7_Polylang_Loader. Orchestrates the hooks of the plugin.
	 * - Cf7_Polylang_i18n. Defines internationalization functionality.
	 * - Cf7_Polylang_Admin. Defines all hooks for the admin area.
	 * - Cf7_Polylang_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cf7-polylang-loader.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wordpress-gurus-debug-api.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cf7-polylang-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cf7-polylang-admin.php';
    //contact post table list
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'assets/cf7-admin-table/cf7-admin-table-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cf7-polylang-public.php';

		$this->loader = new Cf7_Polylang_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cf7_Polylang_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Cf7_Polylang_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Cf7_Polylang_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles',20,1 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts',20,1 );

		/**** polylang hook  *****/
		//register the cf7 cpt with polylang
		$this->loader->add_action( 'pll_get_post_types', $plugin_admin, 'polylang_register_cf7_post_type',10,1);
		//modify the link to new translation form page
		$this->loader->add_filter('pll_get_new_post_translation_link', $plugin_admin, 'cf7_new_translation_link',10,3);
		//Polylang new language locale added
		$this->loader->add_action( 'created_term', $plugin_admin, 'new_polylang_locale_added', 10, 3 );
    //stop meta field synch for cf7 posts
    $this->loader->add_filter('pll_copy_post_metas', $plugin_admin,'polylang_meta_fields_sync', 10,3);

		/****   WP hooks  *****/
		//WP hook 'manage_{$screen_id}_columns' to add new column to table list
		//$this->loader->add_filter( 'manage_toplevel_page_wpcf7_columns', $plugin_admin, 'add_cf7_admin_columns',30,1);
    $this->loader->add_action('trash_wpcf7_contact_form', $plugin_admin, 'delete_translations');
		//add some footer script for polylang to run on the client site
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'add_polylang_footer_scripts',10,1);
		//inject some code into the cf7 form edit page to add the polylang langauge metabox
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'polylang_metabox_edit_form',10,1);
		//edit the link to edit form page
		$this->loader->add_filter( 'get_edit_post_link', $plugin_admin, 'set_edit_form_link',10,3);
		//load the CF7 translations
		$this->loader->add_action( 'plugins_loaded',  $plugin_admin, 'get_cf7_translations',20);
    //warn the user to save polylang screen_settings
    $this->loader->add_action( 'admin_notices',$plugin_admin, 'display_polylang_settings_warning');
    //modify the edit page 'add new' button link and add language select
    $this->loader->add_action('admin_print_footer_scripts',$plugin_admin, 'add_language_select_to_table_page',20);
    //catch cf7 delete redirection
    $this->loader->add_filter('wpcf7_post_delete',$plugin_admin, 'delete_post');
    $this->loader->add_action( 'before_delete_post', $plugin_admin, 'delete_post');
    //make sure our dependent plugins exists.
    $this->loader->add_action( 'admin_init', $plugin_admin, 'check_plugin_dependency');
    /**** CF7 Hooks *****/
    $this->loader->add_action( 'wpcf7_save_contact_form', $plugin_admin, 'save_polylang_translations');

    //check to see if the CF7 plugin gets deactivated
    //add_action( 'deactivated_plugin', array(&$this,'deactivate_cf7_polylang'), 10, 2 );
  }


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Cf7_Polylang_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    $this->loader->add_filter( 'cf7_form_shortcode_form_id', $plugin_public, 'translate_form_id', 10,2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cf7_Polylang_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
