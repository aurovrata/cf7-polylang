=== Contact Form 7 Polylang Module ===
Contributors: aurovrata
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z83ZQ2ARSZPC8
Tags: polylang, contact form 7, multisite, contact form 7 extension, contact form 7 module, multilingual contact form 7
Requires at least: 4.4
Tested up to: 4.7.5
Stable tag: 1.4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows multilingual contact form 7 management using the polylang plugin.

== Description ==
This plugin allows multilingual contact form 7 management using the polylang plugin.  Both Polylang and Contact Form 7 need to be installed prior to installing this plugin.  Works with miltisite installations too.

* Now you can use a single CF7 form shortcode for all your translations.

= Make your CF7 Form more portable =

 this plugin introduces form keys (which you can modify in the CF7 admin table).  Keys are unique for each form, allowing you identify a form my its key rather than an ID.  Why is this priceless?  IDs changes from one server to the next because they are the custom post ID attributed by the WordPress installation, and therefore you develop your form in a local machine only to find out that the IDs are different when you move your form to your production server.  To overcome this problem, we suggest you use a form key along with this plugin's contact form shortcode, `[cf7-2-post key="contact-us"]`.  Don't worry your old contact form 7 shortcodes will still work too, behind the scenes we simply map the key to the ID and call the regular contact form 7 shortcode.

 Similarly you can use any translated form shortcode, and the plugin will make sure the right language is loaded.

Please follow the [Installation](https://wordpress.org/plugins/cf7-polylang/installation/) instructions carefully, especially the part about saving your Polylang settings after you have activated this plugin.

English subtitled video on youtube, [Spanish](https://www.youtube.com/embed/0IJsPGSpYog?cc_load_policy=1&amp;rel=0&amp;showinfo=0&amp;hl=es) & [French](https://www.youtube.com/embed/0IJsPGSpYog?cc_load_policy=1&amp;rel=0&amp;showinfo=0&amp;hl=fr) subtitles available in the caption settings.

[youtube https://www.youtube.com/watch?v=0IJsPGSpYog&t=83s?cc_load_policy=1&rel=0&showinfo=0]

= Checkout our other CF7 plugin extensions =

* [CF7 Polylang Module](https://wordpress.org/plugins/cf7-polylang/) - this plugin allows you to create forms in different languages for a multi-language website.  The plugin requires the [Polylang](https://wordpress.org/plugins/polylang/) plugin to be installed in order to manage translations.

* [CF7 Multi-slide Module](https://wordpress.org/plugins/cf7-multislide/) - this plugin allows you to build a multi-step form using a slider.  Each slide has cf7 form which are linked together and submitted as a single form.

* [Post My CF7 Form](https://wordpress.org/plugins/post-my-contact-form-7/) - this plugin allows you to save you cf7 form submissions to a custom post, map your fields to meta fields or taxonomy.  It also allows you to pre-fill fields before your form  is displayed.

* [CF7 Google Map](https://wordpress.org/plugins/cf7-google-map/) - allows google maps to be inserted into a Contact Form 7.  Unlike other plugins, this one allows map settings to be done at the form level, enabling diverse maps to be configured for each forms.

= Thanks to =
Gérard Mathiuet for providing a fix for PolylangPro.
Peter J. Herrel for improving the language folder management.

== Installation ==

1. Download and install the [PolyLang](https://wordpress.org/plugins/polylang/) plugin, and [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugins.  Activate both plugins.
2. Download and install the Contact Form 7 Polylang module plugin and activate it.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Once activated, open the Polylang settings page, Languages->Settings in your admin dashboard.
5. Open the Settings link in the section 'Custom post types and Taxonomies', ensure that Contact Form checkbox is selected, and save your settings.
6. If you already have Contact Forms created, Polylang settings page should notify you that there are some content that needs to be assigned to the default language.  Click on the link, this will assign all your current contact forms to the default language you have selected in your Polylang settings.
7. Now open the Contact Form table list and you should see the polylang language columns added to your form table.  You can edit forms and change their language assignment, as well as associate translated forms.

NOTE: There is a small issue with the CF7 plugin. When you edit and save a form you may get a pop-up alert saying the form isn't saved and you may loose your changes, even after saving it.  I haven't managed to figure out how to get rid of this.  The CF7 plugin uses a custom edit page and somehow the browser javascripts are not notified of the updated saves, but rest assured your form is saved on the server. PS: if anyone knows how to fix this, please submit a thread in the support section.

== Frequently Asked Questions ==

= My new forms are not translated in my language =

If you found that you installed the plugin correctly and are able to manage your forms using the polylang language columns, then it is likely that the language your have selected does not have a translation for the Contact Form 7.  You can visit the following [translation project page](https://translate.wordpress.org/projects/wp-plugins/contact-form-7) to see the status of the translation CF7 for your language.

= Contact Form 7 is translated in my language, but does not load =

If you have checked the above linked page and are able to find your language, then you can download your language translation pack manually.  It is possible that there is mismatch between the local code used by Polylang and that assigned to your language pack.
 Open the translation page for your specific language (click on the language row in this [table](https://translate.wordpress.org/projects/wp-plugins/contact-form-7)).  This will open the locale specific page that you have selected, then click on the 'Stable' link in the table.  You should now see a page with a table that show the different translations, scroll to the bottom of the page and selected the Export format from the 2nd dropdown to 'Machine Object .mo', then click the Export link.  This will download a zip flie.  Extract the content of this file in the `plugins/contact-form-7/language/CF7/` folder.  Rename file name so that the locale of the file matches the locale of your language as defined by Polylang.  When you create a new form in your language you will find the polylang locale code in the url attributes of your browser address bar.  So if your locale is tk_TK, and you have dowloaded and extracted a file called contact-form-7-tk.mo, rename it to contact-form-7-tk_TK.mo.  This will ensure the correct file is picked.

=  My forms are only partially translated =

This is because the translation in your language have not be completed.  You can help the community by completing the translation [online](https://translate.wordpress.org/projects/wp-plugins/contact-form-7).  You will need to sign up for an account if you haven't got one already and login.  You can also complete the translation on your computer by following the above procedure to download the current status of your language translation.  Insread of the 'Machine Obect .mo' format, select the 'Portable Object .po' format.  Extract the file from the zip archive your download and edit the file using the [PoEdit(or)](https://poedit.net/).  You can then save your translation in the 'Machine Object format' and follow the remaining instructions above to make sure your new translation file is picked up by the plugin.

= I want to display my forms in templates using do_shortcode() =

In order to ensure the correct translation is shown in your template page, you need to make sure you get the translated id `$trans_form_id` in your `do_shortcode` funciton call,

`
do_shortcode([contact_form_7 id="{$trans_form_id}"]);
`
You have Polylang setup using a default language and a set of additional languages. When Polylang translates a custom post (such as the wpcf7 post), it keeps track of all translations using the post ID, by pairing the primary langauge post ID with its corresponding translated post IDs which is what the CF7 Polylang Extension does for you.

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

== Screenshots ==
1. If you don't see the polylang links in your contact table list, head to the Polylang settings and save the existing post content to the default language. (Step 6 in the installation instructions)
2. Contact form table list with Polylang language columns, a dropdown of available languages next to the 'Add New' button allows you to create new forms in any language, note also the portable cf7 shortcodes.
3. Creating a new translation form, with polylang language metabox options.

== Changelog ==
=1.4.5=
* bug fix: beforeunload saveAlert
=1.4.4=
* bug fix wp_reset_postdata called regardless of query success.
= 1.4.3 =
* disable cf7 form post meta field synchronisation by polylang
= 1.4.2 =
* fix minor bug which stopped ajax listing of non-translated forms
* changed links to Polylang settings page.
= 1.4.1 =
* small bug fix which prevented the new cf7 post table page from showing up
= 1.4.0 =
* introduced cf7 key to make forms more portable across translations
* bug fix on polylang translation saves due to non-std cf7 code

= 1.3.0 =
* bug fix - The language select was not showing in wp4.7 cf7 post list table page

= 1.2.9 =
* bug fix due to POLYLANG_URL constant missing in new version of polylang 2.1
* bux fix due to polylang v2.1 using nonce fields in the translation metabox

= 1.2.8 =
* bug fix on front-end enable user login pages reported by @Zelester

= 1.2.7 =
* bug fix on new polylang locale being added.

= 1.2.6 =
* improvement to folder management (contributed by Peter J. Herrel)

= 1.2.5 =
* Added french translation
* Moved cf7 language files to wp-content/languages folder
* cleaner exist in case either cf7 or polylang plugin is deactivated

= 1.2.4 =
* Updated FAQ!
* Removed en_US default locale verification.

= 1.2.3 =
* Fixes admin table bug due to CF7 plugin v4.5 update

= 1.2.2 =
* Enable usage for PolylangPro.  (Contributed by Gérard Mathiuet)

= 1.2.1 =
* Auto-deactivation of plugin if either Polylang or CF7 plugins are deactivated

= 1.2 =
* fixed a bug that prevented translation links to be loaded in the cf7 edit page
* reintroduced the select language in the cf7 admin page
* fixed the 'Add New' button in the cf7 admin page
* fixed the delete button redirect
* fixed the delete of polylang translation links when a form is deleted

= 1.1.2 =
* remove translations column from table list when deactivating
= 1.1.1 =
* fixed a bug that prevented deletion of translation when forms are deleted/trashed

= 1.1 =
* Changed the way the contact form table list is displayed
* better saving of translations

= 1.0 =
* first version
