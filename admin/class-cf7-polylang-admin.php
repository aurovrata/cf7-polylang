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
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      boolean    $is_lang_column_set  be default set to false, true if CF7 calls the function to set the column value.
	 */
	private $is_lang_column_set;

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
		$this->is_lang_column_set=false;
	}
	/**
	*
	*
	*@since 2.1.0
	*@param string $param text_description
	*@return string text_description
	*/
	public function admin_notices(){
		//check if we have any notices.
		global $pagenow;


		$notices = get_option('cf7-polylang-admin-notices', array());
		if(empty($notices)) return;

		if(!isset($notices[$pagenow])) return;

		foreach($notices[$pagenow] as $key=>$notice){
			switch(true){
				case strpos($key, 'page=') !== false && $_GET['page'] === str_replace('page=','',$key):
				case strpos($key, 'post_type=') !== false && $_GET['post_type'] === str_replace('post_type=','',$key):
				case $key==='any':
        case $key==='polylang':
					$dismiss = $notice['nonce'].'-forever';
					if ( ! PAnD::is_admin_notice_active( $dismiss ) ) {
						unset($notices[$pagenow]);
						update_option('cf7-polylang-admin-notices', $notices);
						continue;
					}
					?>
					<div data-dismissible="<?=$dismiss?>" class="updated notice <?=$notice['type']?> is-dismissible"><p><?=$notice['msg']?></p></div>
					<?php
					break;
			}
		}
	}
  /**
  * Deactivate this plugin if CF7 plugin is deactivated or CF7 Smart Grid.
  * Hooks on action 'admin_init'
  * @since 2.0
  */
  //public function deactivate_cf7_polylang( $plugin, $network_deactivating ) {
  public function check_plugin_dependency() {
    //if either the polylang for the cf7 plugin is not active anymore, deactive this extension
    if( !is_plugin_active("contact-form-7/wp-contact-form-7.php") || !defined ("POLYLANG_VERSION") ){
        deactivate_plugins( "cf7-polylang/cf7-polylang.php" );
        debug_msg("Deactivating CF7 Polylang Module Enxtension");

        $button = '<a href="'.network_admin_url('plugins.php').'">Return to Plugins</a></a>';
        wp_die( '<p><strong>CF7 Polylang Module Extension</strong> requires <strong>Contact Form 7 & Polylang</strong> plugins, and has therefore been deactivated!</p>'.$button );

        return false;
    }
    return true;
  }
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		//let's check if this is a cf7 admin page
		// if( Cf7_WP_Post_Table::is_cf7_admin_page() || Cf7_WP_Post_Table::is_cf7_edit_page() ){
		//     wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-polylang-admin.css', array('contact-form-7-admin'), $this->version, 'all' );
    // }
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//let's check if this is a cf7 admin page
		// if( Cf7_WP_Post_Table::is_cf7_admin_page() || Cf7_WP_Post_Table::is_cf7_edit_page() ){
		//     //enqueue de polylang scripts needed for this to work
		//   global $polylang;
		//   $polylang->admin_enqueue_scripts();
    //   if( file_exists(ABSPATH .'wp-content/plugins/polylang/js/post.min.js') ){
    //     wp_enqueue_script( 'pll_post', content_url('/plugins/polylang/js/post.min.js'), array( 'jquery', 'wp-ajax-response', 'post', 'jquery-ui-autocomplete' ), POLYLANG_VERSION, true );
    //   }else{
    //     wp_enqueue_script( 'pll_post', content_url('/plugins/polylang-pro/js/post.min.js'), array( 'jquery', 'wp-ajax-response', 'post', 'jquery-ui-autocomplete' ), POLYLANG_VERSION, true );
    //   }
		// }
		// if(Cf7_WP_Post_Table::is_cf7_edit_page()){
		// 	wp_enqueue_script( $this->plugin_name, plugin_dir_url(  __FILE__ ) . 'js/cf7-polylang-admin.js', array('jquery'), $this->version, true);
		// }

	}

  /**
  * Display a warning when the pluign is installed
  * Warning to save the settings in Polylang, hooks 'admin_notices'
  * @since 1.1.0
  */
  public function display_polylang_settings_warning(){
		if(defined ("POLYLANG_VERSION") && version_compare(POLYLANG_VERSION, '2.3','>=')){
			return ; //taken care programmatically.
		}
		//debug_msg(POLYLANG_VERSION);
    $options = get_option('polylang',false);
    if( $options && in_array(WPCF7_ContactForm::post_type, $options['post_types']) ){
      return;
    }
    //check the version
		//
    $link = '<a href="'.admin_url('admin.php?page=mlang_settings').'">'.__('settings','cf7_polylang').'</a>';
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'Warning: save contact forms translation in Polylang '.$link, 'cf7_polylang' ); ?></p>
    </div>
    <?php
  }
  /**
  * called when a cf7 post is saved
  * saves languages and translations, hooks 'wpcf7_save_contact_form', and sets hooks for cf7 saving action.
  *
  * @since 1.1.0
  *
  * @param object $cf7_form CF7 form object
  */
  public function save_polylang_translations($cf7_form){
    global $post_ID;
    $post_ID =  $cf7_form->id();
    add_action('wpcf7_after_create', array(&$this, 'save_cf7_translations'));
    add_action('wpcf7_after_update', array(&$this, 'update_cf7_translations'));
  }
  /**
  * called when a cf7 post is saved
  * saves languages and translations
  *
  * @since 1.1.0
  *
  * @param object $cf7_form CF7 form object
  */
  public function save_cf7_translations($cf7_form){
    $this->save_translations($cf7_form, false);
  }
  /**
  * called when a cf7 post is updated
  * saves languages and translations
  *
  * @since 1.1.0
  *
  * @param object $cf7_form CF7 form object
  */
  public function update_cf7_translations($cf7_form){
    $this->save_translations($cf7_form, true);
  }
  /**
  * called when a post is saved or updated
  * saves languages and translations
  *
  * @since 1.1.0
  *
  * @param object $cf7_form CF7 form object
  * @param bool $is_update whether it is an update or not
  */
  public function save_translations($cf7_form, $is_update){
    global $polylang;

    $post_id = $cf7_form->id();
    $post = get_post( $post_id);
    $GLOBALS['post_type'] = $post->post_type;
    //let's use polylang's hooked functionality that triggers when posts are saved
    $_POST['post_ID'] = $post_id;
    $polylang->filters_post->save_post($post_id, $post, $is_update);
  }
  /**
  * called when a post is saved or updated
  * saves languages and translations
  *
  * @since 1.1.1
  *
  * @param object $cf7_form CF7 form object
  * @param bool $is_update whether it is an update or not
  */
  public function delete_translations($post_id){
    global $polylang;

    $polylang->filters_post->delete_post($post_id);
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
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $this->check_plugin_dependency();

    $post_type = WPCF7_ContactForm::post_type;

		$types =  array_merge($types, array($post_type => $post_type));
		return $types;
	}
	/**
	*  add links to translated forms.
	*
	*@since 2.1.0
	*@param string $param text_description
	*@return string text_description
	*/
	public function add_default_cf7_plugin_table_script(){
		global $pagenow;
		//check that we are on the right page
		if(empty($pagenow) || 'admin.php' !== $pagenow) return;

		if(!isset($_GET['page']) || $_GET['page'] !== 'wpcf7' || isset($_GET['action'])) return;
		if(!function_exists('pll_the_languages') || !function_exists('pll_get_post')){
			debug_msg('No polylang functions found, unable to create script!');
			return;
		}
		$lang = pll_languages_list();

		if(empty($lang)) return; //languages not set.

		$posts = get_posts(array('post_type'=>WPCF7_ContactForm::post_type, 'post_status'=>'any', 'posts_per_page'=>-1));

		if(empty($posts)) return; //nothing to do here.

		$translations = array();
		foreach($posts as $form){
			$translations[$form->ID] = array();
			foreach($lang as $lg){
				$translations[$form->ID][$lg] = pll_get_post($form->ID, $lg);
			}
		}
		?>
		<script type="text/javascript">
      ( function( $ ) {
        $(document).ready( function(){
					var map = <?=wp_json_encode($translations)?>;
					var root = '<?= admin_url('admin.php?page=wpcf7&action=edit&post=')?>';
					$('#the-list tr').each(function(){
						var $row = $(this);
						var postID = parseInt( $('input[name="post[]"]', $row).val() );
						if(postID>0){
							var links = map[postID];
							for(lang in links){
								var id = links[lang];
								var text='';
								if(id>0 && id!==postID ){
									text = '<span style="margin:0 5px">|</span><a href="'+root+id+'">'+lang+'</a>';
								}else if(id!==postID){
									text ='<span style="margin:0 5px">|</span>'+lang;
								}
								$('td.title strong', $row).append(text);
							}
						}
					});
        } );
      } )( jQuery );
    </script>
    <?php
	}
  /**
  * Change the 'Add New' button and introduce the langauge select
  * Hooks on 'admin_print_footer_scripts'
  * @since 1.1.3
  */
  public function add_language_select_to_table_page(){
    //check that we are on the right page
		if(!isset($_GET['post_type']) || $_GET['post_type'] !== WPCF7_ContactForm::post_type) return;

    $locales = $language_names = array();

    if( function_exists('pll_languages_list') ){
      $locales =  pll_languages_list(array('fields'=>'locale'));
      $language_names = pll_languages_list(array('fields'=>'name'));

      //error_log('CF7 Polylang languages '.print_r($language_names,true));
    }
    $default_locale = 'en_GB';
    if(function_exists('pll_default_language')){
      $default_locale = pll_default_language('locale');
    }
    ?>
    <script id="select-locales-html" type="text/html">
      <select id="select-locales">
        <?php

        foreach($locales as $idx => $locale){
          $selected = $locale == $default_locale ? 'selected' : '';
          echo '<option '.$selected.' value="'.$locale.'">'.$language_names[$idx].'</option>';
        }?>
      </select>
    </script>
    <style>
      #select-locales.wp47{
        position:relative;
        top: -4px;
      }
    </style>
    <script type="text/javascript">
      ( function( $ ) {
        $(document).ready( function(){
          var addNewButton = $('h1 > a.page-title-action');
          var isWP47 = false;
          if(0 == addNewButton.length){ //wp 4.7+
            addNewButton = $('h1 + a.page-title-action');
            isWP47 = true;
          }
          var language_selector = $('#select-locales-html').html();
          var locale = "<?php echo $default_locale; ?>";
          var lang = locale.substring(0,2);
					var originalURL ='<?= admin_url("/post-new.php?post_type=wpcf7_contact_form")?>';
          addNewButton.attr('href',originalURL+'&locale='+locale+'&new_lang='+lang);
          if(isWP47){
            addNewButton.after($(language_selector).addClass('wp47'));
          }else{
            addNewButton.parent().append(language_selector);
          }
          $('#select-locales').on('change', function() {
            locale = $(this).val();
            lang = locale.substring(0,2);
            addNewButton.attr('href',originalURL+'&locale='+locale+'&new_lang='+lang);
          });
        } );
      } )( jQuery );
    </script>
    <?php
  }
	/**
	* Smart grid default form.
	* Hooked to 'wpcf7_default_template'
	* @since 2.0.0
	* @param string $template  the html string for the form tempalte
	* @param string $prop  the template property required.
	* @return string default form.
	*/
	public function default_cf7_form($template, $prop){

		if(!is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )) return $template;

		if($prop !== 'form') return $template;
    include( plugin_dir_path( __FILE__ ) . '/partials/cf7-default-form.php');
    return $template;
	}

	/**
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
		if(is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )){
			return $link; //using std WP post.php edit page
		}
		$link = admin_url('admin.php?page=wpcf7&post='.$post_ID.'&action=edit');
		return $link;
	}

  /**
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
		if(is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )){
			return $link; //using std WP post.php edit page
		}

		$link = admin_url('admin.php?page=wpcf7-new&from_post='.$from_post_id.'&locale='.$language->locale.'&new_lang='.$language->slug);
		return $link;
	}

	/**
	 * Download cf7 translations from WP api.
	 *
	 * Calls the WP translations_api() funtion to download existing translations for CF7
	 *
	 * @since    1.0.0
	 */
	public function get_cf7_translations(){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(! $this->check_plugin_dependency()){
      return;
    };

		//what locales are already installed
		$local_locales = $this->scan_local_locales();
    // foreach($local_locales as $locale){
    //   //register locale for cf7 domain
    //   load_textdomain( 'contact-form-7', WP_LANG_DIR . '/plugins/contact-form-7-'.$locale.'.mo' );
    // }
		//what are the needed locales
		$languages = array();
		if( function_exists('pll_languages_list') ){
			$languages = pll_languages_list(array('fields'=>'locale'));
		}else{
			//we need to show an error message
			debug_msg("CF7 POLYLANG: Unable to load polylang locales, missing function 'pll_languages_list'");
		}
		//which locales do we need to download, remove default locale en_US
		$languages = array_diff($languages, $local_locales, array('en_US'));

		if(empty($languages)){
			return; //nothing to be loaded
		}

		//get available locales for CF7
		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		$cf7_locales = array();
		$api = translations_api( 'plugins', array(
			'slug' => 'contact-form-7',
			'version' => WPCF7_VERSION ) );
		if ( is_wp_error( $api ) ) {
			//display error
			debug_msg("CF7 POLYLANG: Error loading CF7 translations, ".$api->get_error_message());
		}else if( empty( $api['translations'] ) ){
			debug_msg("CF7 POLYLANG: CF7 translations are empty, please try again");
		}else{
			foreach($api['translations'] as $translation){
				$cf7_locales[$translation['language']] = $translation['package'];
			}
		}
		//load the text domain for the locales found in Polylang.
		foreach($languages as $locale){
			if(isset($cf7_locales[$locale])){
				$zipFile = $locale.'.zip';
				$zipPath = WP_LANG_DIR . '/plugins/';// Local Zip File Path
				//get the file stream, not using cURL as may not support https
				file_put_contents($zipFile, fopen($cf7_locales[$locale], 'r'));

				/* Open the Zip file */
				$zip = new ZipArchive;
				$extractPath = WP_LANG_DIR . '/plugins/';
				if($zip->open($zipFile) != "true"){
				 debug_msg( "CF7 POLYLANG: Error, unable to open the Zip File ". $zipFile);
				}
				/* Extract Zip File */
				$zip->extractTo($extractPath);
				$zip->close();
				//delete zip file
				unlink($zipFile);
				//copy the .mo file to the CF7 language folder
				if(! copy( WP_LANG_DIR . '/plugins/contact-form-7-'.$locale.'.mo',
						 WP_LANG_DIR . '/plugins/contact-form-7/contact-form-7-'.$locale.'.mo') ){
					debug_msg("CF7 POLYLANG: Unable to copy CF7 translation for locale ".$zipFile." to CF7 plugin folder.");
				}else{
					debug_msg("CF7 POLYLANG: Found and installed CF7 translation for locale ".$zipFile);
          //register locale for cf7 domain
          // load_textdomain( 'contact-form-7', WP_LANG_DIR . '/plugins/contact-form-7-'.$locale.'.mo' );
				}
			}else{
				//we need to report the missing translation
				debug_msg("CF7 POLYLANG: Missing CF7 translation file for locale ".$locale);
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
    if(!is_dir(WP_LANG_DIR . '/plugins/contact-form-7/')){
      wp_mkdir_p(WP_LANG_DIR . '/plugins/contact-form-7/');
    }
		$translations = scandir(WP_LANG_DIR . '/plugins/contact-form-7/');
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
	public function new_polylang_locale_added( $term_id, $tt_id, $taxonomy ){
		//check if this is the polylang language taxonomy
		if('language' != $taxonomy){
			return;
		}
		//let's get the new locale cf7 translation
		$this->get_cf7_translations();
	}
  /**
   * Redirect to new table list on form delete
   * hooks on 'wpcf7_post_delete'
   * @since 1.1.3
   * @var string $location a fully formed url
   * @var int $status the html redirect status code
   */
  public function delete_post($post_id){
    $post_type = get_post_type($post_id);
    if( WPCF7_ContactForm::post_type != $post_type ) return;
    global $polylang;
    $polylang->filters_post->delete_post($post_id);
  }
  /**
   * Stop polylang synchronising form meta fields.
   *
   * @since 1.4.3
   * @param      array     $keys    meta fields to be synched .
   * @param      boolean     $sync    if synchorinsation is enabled .
   * @param      string     $post_id    post id from which to copy meta fields .
   * @return     array    filtered meta fields to be synched.
  **/
  public function polylang_meta_fields_sync($keys, $sync, $post_id){
    if(!$sync) return $keys;
    if('wpcf7_contact_form' != get_post_type($post_id)) return $keys;
    else return array(); //don't sync any cf7 meta fields
  }
  /**
  * Fix for special email tag [_site_url].
  *
  *@since 2.2.0
  *@param string $output output to filter.
  *@param string $name tag name.
  *@param boolean $html display flag.
  *@return string proper url.
  */
  public function cf7_tag_site_url($output, $name, $html ) {
    if ( '_site_url' == $name ) {
      $filter = $html ? 'display' : 'raw';
      $output =  site_url();
    }
    return $output;
  }
	/**
  * Introduction of email tag [_home_url].
  *
  *@since 2.3.0
  *@param string $output output to filter.
  *@param string $name tag name.
  *@param boolean $html display flag.
  *@return string proper url.
  */
  public function cf7_tag_home_url($output, $name, $html ) {
    if ( '_home_url' == $name ) {
      $filter = $html ? 'display' : 'raw';
			if(function_exists('pll_home_url')) $output =  pll_home_url($_POST['_wpcf7_lang']);
			else {
				debuug_msg('WARNING: function pll_home_url() not found, unable to set home url mail tag, useing WP home_url() instead.');
				$output = home_url();
			}
    }
    return $output;
  }
}
