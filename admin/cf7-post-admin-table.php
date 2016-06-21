<?php

/**
 * The admin-specific functionality of cf7 custom post table.
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
 if(!class_exists('Cf7_WP_Post_Table')){

  class Cf7_WP_Post_Table {
    /**
  	 * A CF7 list table object.
  	 *
  	 * @since    1.0.0
  	 * @access   private
  	 * @var      Cf7_WP_Post_Table    $singleton   cf7 admin list table object.
  	 */
  	private static $singleton;
    /**
  	 * A flag to monitor if hooks are in place.
  	 *
  	 * @since    1.0.0
  	 * @access   private
  	 * @var      boolean    $hooks_set   true if hooks are set.
  	 */
  	private $hooks_set;

    protected function __construct(){
      $this->hooks_set= false;
    }

    public static function set_table(){
      if(null === self::$singleton ){
        self::$singleton = new self();
      }
      return self::$singleton;
    }

    public function hooks(){
      if( !$this->hooks_set ){
        $this->hooks_set= true;
        return false;
      }
      return $this->hooks_set;
    }
    /**
  	 * Register the stylesheets for the admin area.
  	 *
  	 * @since    1.0.0
  	 */
  	public function enqueue_styles() {
  		//let's check if this is a cf7 admin page
  		/*if( !($action = $this->is_cf7_admin_page()) ){
  			return;
  		}*/
  		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-polylang-admin.css', array('contact-form-7-admin'), $this->version, 'all' );
  	}
    /**
    * Modify the regsitered cf7 post tppe
    * THis function enables public capability and amind UI visibility for the cf7 post type. Hooked late on `init`
    * @since 1.0.0
    *
    */
    public function modify_cf7_post_type(){
      if(class_exists('WPCF7_ContactForm') &&  post_type_exists( WPCF7_ContactForm::post_type ) ) {
          global $wp_post_types;
          $wp_post_types[WPCF7_ContactForm::post_type]->public = true;
          $wp_post_types[WPCF7_ContactForm::post_type]->show_ui = true;
          //debug_msg("CF7 2 POST: ".print_r($wp_post_types[WPCF7_ContactForm::post_type],true));
      }
    }

    /**
    * Adds a new sub-menu
    * Add a new sub-menu to the Contact main menu, as well as remove the current default
    *
    */
    public function add_cf7_sub_menu(){

      $hook = add_submenu_page(
        'wpcf7',
        __( 'Edit Contact Form', 'contact-form-7' ),
    		__( 'Contact Forms', 'contact-form-7' ),
    		'wpcf7_read_contact_forms',
        'edit.php?post_type=wpcf7_contact_form');
      //remove_submenu_page( $menu_slug, $submenu_slug );
      remove_submenu_page( 'wpcf7', 'wpcf7' );
    }

    /**
    * Change the submenu order
    * @since 1.0.0
    */
    public function change_cf7_submenu_order( $menu_ord ) {
        global $submenu;
        //debug_msg("SUBMENU: ".print_r($submenu,true));
        //debug_msg("MENU ORDER: ".print_r($menu_ord,true));
        // Enable the next line to see all menu orders
        //echo '<pre>'.print_r($submenu,true).'</pre>';
        //debug_msg("SYBMENU: ".print_r($submenu['wpcf7'],true));
        $arr = array();
        foreach($submenu['wpcf7'] as $menu){
          switch($menu[2]){
            case 'cf7_post': //do nothing, we hide this submenu
              $arr[]=$menu;
              break;
            case 'edit.php?post_type=wpcf7_contact_form':
              //push to the front
              array_unshift($arr, $menu);
              break;
            default:
              $arr[]=$menu;
              break;
            }
          }
        //debug_msg("SYBMENU: ".print_r($arr,true));
        $submenu['wpcf7'] = $arr;
        return $menu_ord;
    }
    /**
    * Modify cf7 post type list table columns
    * Hooked on 'modify_{$post_type}_posts_columns', to remove the default columns
    *
    */
    public function modify_cf7_list_columns($columns){
      return array(
          'cb' => '<input type="checkbox" />',
          'custom_title' => __( 'Title', 'contact-form-7' ),
          'shortcode' => __( 'Shortcode', 'contact-form-7'),
          'custom_author' => __('Author', 'contact-form-7'),
          'date' => __('Date', 'contact-form-7')
      );
    }
    /**
    * Populate custom columns in cf7 list table
    * @since 1.0.0
    *
    */
    public function populate_custom_column( $column, $post_id ) {
      switch ( $column ) {
        case 'custom_title':
          if( !class_exists('WPCF7_ContactForm') ){
            echo 'No CF7 Form class';
          }else{
            $form = WPCF7_ContactForm::get_instance($post_id);
            $url = admin_url( 'admin.php?page=wpcf7&post=' . absint( $form->id() ) );
        		$edit_link = add_query_arg( array( 'action' => 'edit' ), $url );

        		$output = sprintf(
        			'<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
        			esc_url( $edit_link ),
        			esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'contact-form-7' ),
        				$form->title() ) ),
        			esc_html( $form->title() ) );

        		$output = sprintf( '<strong>%s</strong>', $output );

        		if ( function_exists('wpcf7_validate_configuration') && wpcf7_validate_configuration()
          		&& current_user_can( 'wpcf7_edit_contact_form', $form->id() )
          		&& $config_errors = $form->get_config_errors() ) {
          			$error_notice = sprintf(_n(
          					'%s configuration error found',
          					'%s configuration errors found',
          					count( $config_errors ), 'contact-form-7' ),
          				number_format_i18n( count( $config_errors ) ) );
          			$output .= sprintf(
          				'<div class="config-error">%s</div>',
          				$error_notice );
          	}

            echo $output;
        		//$output .= $this->row_actions( $actions );

          }

          break;
        case 'shortcode' :
          if( !class_exists('WPCF7_ContactForm') ){
            echo 'No CF7 Form class found';
          }else{
            $form = WPCF7_ContactForm::get_instance($post_id);
            $shortcodes = array( $form->shortcode() );
        		$output = '';
        		foreach ( $shortcodes as $shortcode ) {
        			$output .= "\n" . '<span class="shortcode"><input type="text"'
        				. ' onfocus="this.select();" readonly="readonly"'
        				. ' value="' . esc_attr( $shortcode ) . '"'
        				. ' class="large-text code" /></span>';
        		}
        		echo trim( $output );
          }
          break;
        case 'custom_author':
          $post = get_post( $post_id );
          if ( ! $post ) {
            break;
          }
          $author = get_userdata( $post->post_author );
          if ( false === $author ) {
            break;
          }
          echo esc_html( $author->display_name );
          break;
      }
    }

    /**
  	 * Modify the quick action links in the contact table.
  	 * Since this plugin replaces the default contact form list table
     * for the more std WP table, we need to modify the quick links to match the default ones.
     * This function is hooked on 'post_row_actions'
  	 * @since    1.0.0
     * @param Array  $actions  quick link actions
     * @param WP_Post $post the current row's post object
     */
    public function modify_cf7_list_row_actions($actions, $post){
        //check for your post type
        if ($post->post_type =="wpcf7_contact_form"){
          $form = WPCF7_ContactForm::get_instance($post->ID);
          $url = admin_url( 'admin.php?page=wpcf7&post=' . absint( $form->id() ) );
          $edit_link = add_query_arg( array( 'action' => 'edit' ), $url );
          $trash = $actions['trash'];
          $actions = array(
            'edit' => sprintf( '<a href="%1$s">%2$s</a>',
              esc_url( $edit_link ),
              esc_html( __( 'Edit', 'contact-form-7' ) ) ) );

          if ( current_user_can( 'wpcf7_edit_contact_form', $form->id() ) ) {
            $copy_link = wp_nonce_url(
              add_query_arg( array( 'action' => 'copy' ), $url ),
              'wpcf7-copy-contact-form_' . absint( $form->id() ) );

            $actions = array_merge( $actions, array(
              'copy' => sprintf( '<a href="%1$s">%2$s</a>',
                esc_url( $copy_link ),
                esc_html( __( 'Duplicate', 'contact-form-7' ) ) ) ) );
                //reinsert thrash link
                //$actions['trash']=$trash;
          }
          //debug_msg("CF7 2 POST: post row actions, ".print_r($actions,true));
        }
        return $actions;
    }
  }
}
