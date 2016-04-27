<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Polylang_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
						'cf7-polylang',
						false,
						dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
		
		//get available locales for CF7
		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		$cf7_locales = array();
		$api = translations_api( 'plugins', array(
			'slug' => 'contact-form-7',
			'version' => WPCF7_VERSION ) );
		if ( is_wp_error( $api ) || empty( $api['translations'] ) ) {
			//display error
			error_log("CF7 POLYLANG: Error loading CF7 translations, ".$api);
		}else{
			foreach($api['translations'] as $translation){
				$cf7_locales[$translation['language']] = $translation['package'];
				//error_log( "CF7 POLYLANG: found locale ". print_r($translation,true));
			}
		}
		//error_log("CF7 Locales: \n".print_r($api,true));
		//load the text domain for the locales found in Polylang.
		if( function_exists('pll_languages_list') ){
			$languages = pll_languages_list(array('fields'=>'locale'));
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
					error_log("CF7 POLYLANG: Downloaded locale ".$zipFile);
					/* Open the Zip file */
					$zip = new ZipArchive;
					$extractPath = CF7_POLYLANG_PATH . 'languages/CF7/';
					if($zip->open($zipFile) != "true"){
					 error_log( "CF7 POLYLANG: Error, unable to open the Zip File ". $zipFile);
					} 
					/* Extract Zip File */
					$zip->extractTo($extractPath);
					$zip->close();
					//load the new locales for the CF7 domain
					load_plugin_textdomain(
						'contact-form-7',
						false,
						dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/CF7/'
					);
				}else{
					//we need to report the missing translation
					error_log("CF7 POLYLANG: Missing CF7 translation file for locale ".$locale);
				}
			}
		}else{
			//we need to show an error message
			error_log("CF7 POLYLANG: Unable to load polylang locales, missing function 'pll_languages_list'");
		}

	}



}
