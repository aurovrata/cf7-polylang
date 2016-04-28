<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/admin
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		//let's check if this is a cf7 admin page
		if( !($action = $this->is_cf7_admin_page()) ){
			return;
		}
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-polylang-admin.css', array('contact-form-7-admin'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//let's check if this is a cf7 admin page
		if( !($action = $this->is_cf7_admin_page()) ){
			return;
		}
		//enqueue de polylang scripts needed for this to work
		global $polylang;
		$polylang->admin_enqueue_scripts();
		
		switch($action){
			case 'edit':
			case 'new':
				//lets force loading of polylang script
				wp_enqueue_script( 'pll_post', POLYLANG_URL .'/js/post.min.js', array( 'jquery', 'wp-ajax-response', 'post', 'jquery-ui-autocomplete' ), POLYLANG_VERSION, true );
			break;
		}

	}
	
	/**
	 * Load the Polylang footer scripts.
	 *
	 * Required by Polylang to enable polylang edit and setting links, and hooked on 'admin_print_footer_scripts'
	 *
	 * @since    1.0.0
	 */
	public function add_polylang_footer_scripts() {
		if( !$this->is_cf7_admin_page() ){
			return;
		}
		global $polylang;
		//file: polylang/admin/admin-base.php
		$polylang->admin_print_footer_scripts();
	}
	/**
	 * check if this is a cf7 admin page.
	 *
	 * @since    1.0.0
	 * @return    string    Type of action, none for table list, edit for edit form page, new for new form page. Returns false if not a CF7 admin page
	 */
	public function is_cf7_admin_page(){
		//check if cf7 page
		if(!isset($_GET['page']) || false === strpos($_GET['page'],'wpcf7') ){
			return false;
		}
		global $post_ID;
		$post_ID='';
		$action = 'none';
		
		if( 'wpcf7-new' == $_GET['page'] ) $action = 'new';
		
		if(isset($_GET['action'])) $action = $_GET['action'];
		
		if(isset( $_GET['post'] ) && false != $_GET['post']){
			$action = 'edit';
			$post_ID = $_GET['post']; //set the global post_ID
		}
		error_log("CF7 admin page action :".$action.", screen ".get_current_screen()->id);
		return $action;
	}
	
	/**
	 * Force polylang to register the CF7 cpt.
	 *
	 * Called by the Polylang hook 'pll_get_post_types'
	 *
	 * @since    1.0.0 
	 * @param		array		$types  an array containing existing post types registered with polylang plugin
	 * @return 	array		array of types 
	 */
	public function polylang_register_cf7_post_type($types) {
		//CF7 cpt post type
		$post_type = WPCF7_ContactForm::post_type;
		
		$types =  array_merge($types, array($post_type => $post_type));
		
		return $types;
	}
	
	/**
	 * Add extra column to CF7 admin table.
	 *
	 * Called by the WP hook 'manage_{$screen_id}_columns'
	 *
	 * @since    1.0.0 
	 * @param		array		$columns  an array containing existing columns titles
	 * @return 	array		array of columns with the extra columns added
	 */
	public function add_cf7_admin_columns($columns){
		error_log("CF7 Admin page: adding column");
		global $polylang;
		//call the polylang function that normally does this with std WP hooks
		//File: polylang/admin/admin-filters-columns.php
		return $polylang->filters_columns->add_post_column($columns);
	}
	/**
	 * Fill cell of extra column in CF7 admin table.
	 *
	 * Called by the CF7 hook 'manage_cf7_custom_column', but this requires currently a hack of the CF7 plugin
	 * as it has not been designed using WP std code practice, as a result the CF7 WP_Table_List class extension implementation of the
	 * abstract function column_default( $item, $column_name ) return an empty string.  It should at least apply a filtered result.  Therefore
	 * the file contact-form-7/admin/include/class-contact-forms-list-table.php on line 88 should change the function to read,
	 * function column_default( $item, $column_name ) {
	 *   return apply_filters( "manage_cf7_custom_column", $column_name, $item->id() );
	 * }
	 *
	 * @since    1.0.0 
	 * @param		string	$column  string tag for the extra column
	 * @param		string	$post_id  the post ID for the current row
	 * @return 	string	string value of column cell for the row with give post ID
	 */
	public function polylang_cf7_column_value( $column, $post_id ) {
		global $polylang;
		ob_start();
		//capture the echo value (WP std way to print directly the row value implemented by polylang)
		$polylang->filters_columns->post_column( $column, $post_id );
		$column_value = ob_get_contents();
		ob_end_clean();
		
		return $column_value;
	}
	/**
	 * Add polylang metabox to form edit page.
	 *
	 * Hooks the 'admin_footer' WP action and inject html/jquery code that adds the metabox
	 * to the sidebar once the page is loaded in the client browser
	 * 
	 * @since    1.0.0 
	 */
	public function polylang_metabox_edit_form(){
		if( !($action = $this->is_cf7_admin_page()) ){
			return;
		}
		
		switch($action){
			case 'edit':
			case 'new':
				// get polylang metabox
				include( plugin_dir_path( __FILE__ ) . 'partials/cf7-polylang-edit-metabox.php');
				break;
			case 'none': //assume admin table page
				?>
				<script type="text/javascript">
					( function( $ ) {
						$(document).ready( function(){
							var originalURL = $('.add-new-h2').attr('href');
							//$('.add-new-h2').attr('href',originalURL+'&post_type=wpcf7_contact_form');
						} );
					} )( jQuery );
				</script>
				<?php
				break;
			default:
				break;
		}
	}
	
	/*
	 * Set the form edit page link.
	 *
	 * The CF7 plugin does not use WP code std, instead creates its own edit form page, hence the edit links
	 * created by Polylang for cpt are wrong and need to be reset.  Hooks WP filter 'get_edit_post_link' 
	 *
	 * @since    1.0.0 
	 * @param		string	$link  edit page link
	 * @param		string	$post_ID  the post ID of the form to edit
	 * @param		string	$context  the context
	 * @return 	string	the url link to the admin edit page for cf7 form
	 */
	public function set_edit_form_link($link, $post_ID, $context){
		//let's check we have the correct post type
		$post_type = get_post_type($post_ID);
		if(WPCF7_ContactForm::post_type != $post_type){
			return $link;
		}
		$link = admin_url('admin.php?page=wpcf7&post='.$post_ID.'&action=edit');
		return $link;
	}
	/*
	 * Set the new translation form page link.
	 *
	 * Polylang new translation links are assuming std WP coding which CF7 plugin does not follow.
	 * Hooks Polylang filter 'pll_get_new_post_translation_link' 
	 *
	 * @since    1.0.0 
	 * @param		string	$link  to new form page
	 * @param		string	$language  trasnlated to language
	 * @param		string	$from_post_id  the form post ID being translated
	 * @return 	string	the url link to the admin edit page for cf7 form
	 */
	public function cf7_new_translation_link($link, $language, $from_post_id ){
		//let's check we have the correct post type
		$post_type = get_post_type($from_post_id);
		if(WPCF7_ContactForm::post_type != $post_type){
			return $link;
		}
		
		$link = admin_url('admin.php?page=wpcf7-new&from_post='.$from_post_id.'&locale='.$language->locale.'&new_lang='.$language->slug);
		return $link;
	}
	
	/**
	 * Download cf7 trasnlations fro WP api.
	 *
	 * Calls the WP translations_api() funtion to download existing translations for CF7
	 *
	 * @since    1.0.0 
	 */
	public function get_cf7_translations(){
		//what locales are already installed
		$local_locales = $this->scan_local_locales();
		error_log("CF7 POLYLANG: found local locales, ".print_r($local_locales,true));
		//what are the needed locales
		$languages = array();
		if( function_exists('pll_languages_list') ){
			$languages = pll_languages_list(array('fields'=>'locale'));
		}else{
			//we need to show an error message
			error_log("CF7 POLYLANG: Unable to load polylang locales, missing function 'pll_languages_list'");
		}
		error_log("CF7 POLYLANG: found polylang locales, ".print_r($languages,true));
		//which locales do we need to download
		$languages = array_diff($languages, $local_locales);
		
		if(empty($languages)){
			return; //nothing to be loaded
		}
		error_log("CF7 POLYLANG: need to download locales, ".print_r($languages,true));
		//get available locales for CF7
		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		$cf7_locales = array();
		$api = translations_api( 'plugins', array(
			'slug' => 'contact-form-7',
			'version' => WPCF7_VERSION ) );
		if ( is_wp_error( $api ) ) {
			//display error
			error_log("CF7 POLYLANG: Error loading CF7 translations, ".$api->get_error_message());
		}else if( empty( $api['translations'] ) ){
			error_log("CF7 POLYLANG: CF7 translations are empty, please try again");
		}else{
			foreach($api['translations'] as $translation){
				$cf7_locales[$translation['language']] = $translation['package'];
				//error_log( "CF7 POLYLANG: found locale ". print_r($translation,true));
			}
		}
		//error_log("CF7 Locales: \n".print_r($api,true));
		//load the text domain for the locales found in Polylang.
		foreach($languages as $locale){
			if(isset($cf7_locales[$locale])){
				$zipFile = CF7_POLYLANG_PATH  . 'languages/CF7/'.$locale.'.zip'; // Local Zip File Path
				$zipResource = fopen($zipFile, "w");
				// Get The Zip File From Server
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $cf7_locales[$locale] );
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_AUTOREFERER, true);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
				curl_setopt($ch, CURLOPT_FILE, $zipResource);
				$page = curl_exec($ch);
				if(!$page) {
				 echo "Error :- ".curl_error($ch);
				}
				curl_close($ch);
				
				/* Open the Zip file */
				$zip = new ZipArchive;
				$extractPath = CF7_POLYLANG_PATH . 'languages/CF7/';
				if($zip->open($zipFile) != "true"){
				 error_log( "CF7 POLYLANG: Error, unable to open the Zip File ". $zipFile);
				} 
				/* Extract Zip File */
				$zip->extractTo($extractPath);
				$zip->close();
				error_log("CF7 POLYLANG: Found and installed CF7 translation for locale ".$zipFile);
				
				//copy the .mo file to the CF7 language folder
				copy( CF7_POLYLANG_PATH . 'languages/CF7/contact-form-7-'.$locale.'.mo',
						 WP_PLUGIN_DIR . '/contact-form-7/languages/contact-form-7-'.$locale.'.mo');
			}else{
				//we need to report the missing translation
				error_log("CF7 POLYLANG: Missing CF7 translation file for locale ".$locale);
			}
		}
	}
	/**
	 * Get installed CF7 locales.
	 *
	 * Returns an array of locales that are already installed.
	 *
	 * @since    1.0.0 
	 * @return		array	an array of locales
	 */
	protected function scan_local_locales(){
		$translations = scandir(CF7_POLYLANG_PATH . 'languages/CF7/');
		$local_locales = array();
		foreach($translations as $translation_file){
			$parts = pathinfo($translation_file);
			if( 'mo'==$parts['extension'] ){
				if( !isset($parts['filename']) ){
					$parts['filename'] = $local_locales[]=str_replace('.mo','', $parts['basename']);
				}
				$local_locales[]=str_replace( 'contact-form-7-','',$parts['filename'] ); //php 5.2 onwards
			}
		}
		return $local_locales;
	}
	
	/**
	 * Called when new language locale added in Polylang.
	 *
	 * Polylang tracks languages in use with a custom taxonomy 'language'. This function
	 * is triggered on the action hook 'created_term'.
	 *
	 * @since    1.0.0 
	 * @param		int	$term_id  the new term ID
	 * @param		int	$tt_id  term_taxonomy_id
	 * @param		string	$taxonomy  the taxonomy to which the new term was added
	 */
	public function new_plylang_locale_added( $term_id, $tt_id, $taxonomy ){
		//check if this is the polylang language taxonomy
		if('language' != $taxonomy){
			return;
		}
		//let's reset the textdomain
		$this->load_plugin_textdomain();
	}
}
