=== Contact Form 7 Polylang Module ===
Contributors: aurovrata
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z83ZQ2ARSZPC8
Tags: polylang, contact form 7, multisite, contact form 7 extension, contact form 7 module, multilingual contact form 7, multilingual form, cf7 smart grid extension
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 4.9.6
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows multilingual contact form 7 management using the polylang plugin.

== Description ==
**NOTE** v2 is now an extension of the [CF7 Smart Grid-layout](https://wordpress.org/plugins/cf7-grid-layout/) plugin.  You need to install it to use this plugin.  Why is this? You can read this [thread](https://wordpress.org/support/topic/not-compatible-with-cf7-v5/#post-9973288), and this [post](https://wordpress.org/support/topic/why-i-wrote-this-plugin-2/).
This plugin allows multilingual contact form 7 management using the polylang plugin. As of version 2.0 of this plugin, it is now developed as an extension of the [CF7 Smart Grid-layout](https://wordpress.org/plugins/cf7-grid-layout/) plugin.  All 3 plugins, Polylang, CF7 Smart Grid-layout and Contact Form 7 need to be installed prior to installing this plugin.  Works with multisite installations too.

* Now you can use a single CF7 form shortcode for all your translations.
* **WARNING**: ensure you follow the installation instructions along with the PolyLang settings adjustments.

= Make your CF7 Form more portable =

 this plugin introduces form keys (which you can modify in the CF7 admin table).  Keys are unique for each form, allowing you identify a form my its key rather than an ID.  Why is this priceless?  IDs changes from one server to the next because they are the custom post ID attributed by the WordPress installation, and therefore you develop your form in a local machine only to find out that the IDs are different when you move your form to your production server.  To overcome this problem, we suggest you use a form key along with this plugin's contact form shortcode, `[cf7-form key="contact-us"]`.  Don't worry your old contact form 7 shortcodes will still work too, behind the scenes we simply map the key to the ID and call the regular contact form 7 shortcode.

 Similarly you can use any translated form shortcode, and the plugin will make sure the right language is loaded.

Please follow the [Installation](https://wordpress.org/plugins/cf7-polylang/installation/) instructions carefully, especially the part about saving your Polylang settings after you have activated this plugin.

English subtitled video on youtube, [Spanish](https://www.youtube.com/embed/0IJsPGSpYog?cc_load_policy=1&amp;rel=0&amp;showinfo=0&amp;hl=es) & [French](https://www.youtube.com/embed/0IJsPGSpYog?cc_load_policy=1&amp;rel=0&amp;showinfo=0&amp;hl=fr) subtitles available in the caption settings.

[youtube https://www.youtube.com/watch?v=0IJsPGSpYog&t=83s?cc_load_policy=1&rel=0&showinfo=0]

= Checkout our other CF7 plugin extensions =

* [CF7 Polylang Module](https://wordpress.org/plugins/cf7-polylang/) - this plugin allows you to create forms in different languages for a multi-language website.  The plugin requires the [Polylang](https://wordpress.org/plugins/polylang/) plugin to be installed in order to manage translations.

* [CF7 Multi-slide Module](https://wordpress.org/plugins/cf7-multislide/) - this plugin allows you to build a multi-step form using a slider.  Each slide has cf7 form which are linked together and submitted as a single form.

* [Post My CF7 Form](https://wordpress.org/plugins/post-my-contact-form-7/) - this plugin allows you to save you cf7 form submissions to a custom post, map your fields to meta fields or taxonomy.  It also allows you to pre-fill fields before your form  is displayed.

* [CF7 Google Map](https://wordpress.org/plugins/cf7-google-map/) - allows google maps to be inserted into a Contact Form 7.  Unlike other plugins, this one allows map settings to be done at the form level, enabling diverse maps to be configured for each forms.

* [Smart Grid-Layout Design for CF7](https://wordpress.org/plugins/cf7-grid-layout/) - allows responsive grid layout Contact Form 7 form designs, enabling modular designs of complex forms, and rich inter-linking of your CMS data with taxonomy/posts populated dynamic dropdown fields.

= Thanks to =
Gérard Mathiuet for providing a fix for PolylangPro.
Peter J. Herrel for improving the language folder management.
Didier (@swissspaceboy) for pointing out an [issue](https://wordpress.org/support/topic/mailtag-_site_url-is-not-returning-the-localized-homepage-url/) with the CF7 Special Mail tag `[_site_url]`.

= Privacy Notices =

This plugin, in itself, does not:

* track users by stealth;
* write any user personal data to the database;
* send any data to external servers;
* use cookies.


== Installation ==

1. Download and install the [PolyLang](https://wordpress.org/plugins/polylang/) plugin, the [ CF7 Smart Grid-Layout Extension](https://wordpress.org/plugins/cf7-grid-layout/) and [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugins.  Activate all 3 plugins.
2. Download and install the Contact Form 7 Polylang module plugin and activate it.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Once activated, open the Polylang settings page, Languages->Settings in your admin dashboard.
5. If you already have Contact Forms created, Polylang settings page should notify you that there are some content that needs to be assigned to the default language.  Click on the link, this will assign all your current contact forms to the default language you have selected in your Polylang settings.
6. Now open the Contact Form table list and you should see the polylang language columns added to your form table.  You can edit forms and change their language assignment, as well as associate translated forms.

== Frequently Asked Questions ==

= 1. My new forms are not translated in my language =

If you found that you installed the plugin correctly and are able to manage your forms using the polylang language columns, then it is likely that the language your have selected does not have a translation for the Contact Form 7.  You can visit the following [translation project page](https://translate.wordpress.org/projects/wp-plugins/contact-form-7) to see the status of the translation CF7 for your language.

= 2. Contact Form 7 is translated in my language, but does not load =

If you have checked the above linked page and are able to find your language, then you can download your language translation pack manually.  It is possible that there is mismatch between the local code used by Polylang and that assigned to your language pack.
 Open the translation page for your specific language (click on the language row in this [table](https://translate.wordpress.org/projects/wp-plugins/contact-form-7)).  This will open the locale specific page that you have selected, then click on the 'Stable' link in the table.  You should now see a page with a table that show the different translations, scroll to the bottom of the page and selected the Export format from the 2nd dropdown to 'Machine Object .mo', then click the Export link.  This will download a zip flie.  Extract the content of this file in the `plugins/contact-form-7/language/CF7/` folder.  Rename file name so that the locale of the file matches the locale of your language as defined by Polylang.  When you create a new form in your language you will find the polylang locale code in the url attributes of your browser address bar.  So if your locale is tk_TK, and you have dowloaded and extracted a file called contact-form-7-tk.mo, rename it to contact-form-7-tk_TK.mo.  This will ensure the correct file is picked.

=  3. My forms are only partially translated =

This is because the translation in your language have not be completed.  You can help the community by completing the translation [online](https://translate.wordpress.org/projects/wp-plugins/contact-form-7).  You will need to sign up for an account if you haven't got one already and login.  You can also complete the translation on your computer by following the above procedure to download the current status of your language translation.  Instead of the 'Machine Object .mo' format, select the 'Portable Object .po' format.  Extract the file from the zip archive your download and edit the file using the [PoEdit(or)](https://poedit.net/).  You can then save your translation in the 'Machine Object format' and follow the remaining instructions above to make sure your new translation file is picked up by the plugin.

= 4. I want to display my forms in templates using do_shortcode() =

In order to ensure the correct translation is shown in your template page, you need to make sure you get the translated id `$trans_form_id` in your `do_shortcode` function call,

`
do_shortcode([contact_form_7 id="{$trans_form_id}"]);
`
You have Polylang setup using a default language and a set of additional languages. When Polylang translates a custom post (such as the wpcf7 post), it keeps track of all translations using the post ID, by pairing the primary language post ID with its corresponding translated post IDs which is what the CF7 Polylang Extension does for you.

So you need to search your translation using the primary language post ID, to do this you need to make use of the [Polylang functions](https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/),

`
$form_id = 252; //assuming this is your default language form ID
$default_lang = pll_default_language('slug');
$current_lang = pll_current_language('slug); //the current language your page is being viewed as
if($current_lang != $default_lang){
  $form_id = pll_get_post($form_id, $current_lang);
  if(empty($form_id)){ //if a translation does not exists
    $form_id = 252; //show the default form
  }
}
//display your form
echo do_shortcode('[contact-form-7 id=”'.$form_id.'″]');
`
= 5. How do I get the current language when my form is submitted? =

Polylang only filters links and provides the current language function `pll_current_language()` for the front-end requests.  Submissions are handled using admin hooks by the CF7 plugin and these do not have access to the pll functions.  To overcome this limitation, v2.3 of this plugin introduced the `_wpcf7_lang` hidden variable which is automatically submitted.  So you can find out the current language of the submission using the `$_POST['_wpcf7_lang']` value.

= 6. How can I can show which language site the form submisison email notification is coming from? =

The cf7 plugin provides a special mail tag `[_site_url]` which prints the site url.  However, this is not one of the filtered polylang links.  Therefore as of v2.3 this plugin now has the `[_home_url]` mail tag that you an use in your mail body and which will show the home url of site from which it was submitted from.

Alternatively, you could also construct your own special mail tag, such as `[_lang]` using the follwoing code in your functions.php file,

`
add_filter( 'wpcf7_special_mail_tags','my_cf7_mail_tag', 10,3);
function my_cf7_mail_tag($output, $name, $html ) {
  if ( '_lang' == $name ) {
    $filter = $html ? 'display' : 'raw';
    $output = $_POST['_wpcf7_lang'];
  }
  return $output;
}
`
== Screenshots ==
1. If you don't see the polylang links in your contact table list, head to the Polylang settings and save the existing post content to the default language. (Step 6 in the installation instructions)
2. Contact form table list with Polylang language columns, a dropdown of available languages next to the 'Add New' button allows you to create new forms in any language, note also the portable cf7 shortcodes.
3. Creating a new translation form, with polylang language metabox options.
4. Ensure you enable translations for Contact Forms in your Polyland settings.

== Changelog ==
= 2.3.0 =
* added hidden field _wpcf7_lang to front-end form.
* instroduce special mail tag [_home_url].
= 2.2.0 =
* fix for CF7 bug on special mail tag _site_url.
= 2.1.1 =
* fix notices.
* improved translations
= 2.1.0 =
* allows plugin update without cf7 smart grid, but restricted functionality.
= 2.0.1 =
* removed empty front-end css/js from script queue.
= 2.0.0 =
* major update to plugin to integrate with WP std admin pages for cf7 offered by cf7 smart grid plugin.
* code update to fix issue with polylang v2.3+ changes.
