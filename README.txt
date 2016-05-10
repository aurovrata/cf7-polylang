=== Contact Form 7 Polylang Module ===
Contributors: aurovrata
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z83ZQ2ARSZPC8
Tags: polylang, contact form 7, multisite, contact form 7 extension, contact form 7 module, multilingual contact form 7
Requires at least: 3.0.1
Tested up to: 4.4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows multilingual contact form 7 management using the polylang plugin.

== Description ==
This plugin allows multilingual contact form 7 management using the polylang plugin.  Both Polylang and Contact Form 7 need to be installed prior to installing this plugin.  Works with miltisite installations too.


== Installation ==

1. Download and install the [PolyLang](https://wordpress.org/plugins/polylang/) plugin, and [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugins.  Activate both plugins.
2. Download and install the Contact Form 7 Polylang module plugin and activate it.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Once activated, open the Polylang settings page, Settings->Languages in your admin dashboard.
5. Select the Settings tab and open the section 'Custom Post Types and Taxonomy', ensure that Contact Form checkbox is selected, and save your settings.
6. If you already have Contact Forms created, Polylang settings page should notify you that there are some content that needs to be assigned to the default language.  Click on the link, this will assign all your current contact forms to the default language you have selected in your Polylang settings.
7. Now open the Contact Form table list and you should see the polylang language columns added to your form table.  You can edit forms and change their language assignment, as well as associate translated forms.
8. The form table list does not display the language content properly, this is due to a restriction in the CF7 code.  There is a small change that can be done to the code to enable this, and you can follow my instructions in the section **CF7 Code Modification** below if you wish.  It should not stop you from using the plugin, you will just be missing the table language columns content and links.

== Frequently Asked Questions ==

= My new forms are not translated in my language =

If you found that you installed the plugin correctly and are able to manage your forms using the polylang language columns, then it is likely that the language your have selected does not have a translation for the Contact Form 7.  You can visit the following [translation project page](https://translate.wordpress.org/projects/wp-plugins/contact-form-7) to see the status of the translation CF7 for your language.

= Contact Form 7 is translated in my language, but does not load =

If you have checked the above linked page and are able to find your language, then you can download your language translation pack manually.  It is possible that there is mismatch between the local code used by Polylang and that assigned to your language pack.
 Open the translation page for your specific language (click on the language row in this [table](https://translate.wordpress.org/projects/wp-plugins/contact-form-7)).
 Scroll to the bottom of the page and selected the Export format from the 2nd dropdown to 'Machine Object .mo', then click the Export link.  This will download a zip flie.  Extract the content of this file in the `plugins/contact-form-7/language/` folder.  Rename file name so that the local of the file matches the local of your language as defined by Polylang.  When you create a new form in your language you will find the polylang locale code in the url attributes of your browser address bar.  So if your locale is tk_TK, and you have dowloaded and extracted a file called contact-form-7-tk.mo, rename it to contact-form-7-tk_TK.mo.  This will ensure the correct file is picked.

=  My forms are only partially translated =

This is because the translation in your language have not be completed.  You can help the community by completing the translation [online](https://translate.wordpress.org/projects/wp-plugins/contact-form-7).  You will need to sign up for an account if you haven't got one already and login.  You can also complete the translation on your computer by following the above procedure to download the current status of your language translation.  Insread of the 'Machine Obect .mo' format, select the 'Portable Object .po' format.  Extract the file from the zip archive your download and edit the file using the [PoEdit(or)](https://poedit.net/).  You can then save your translation in the 'Machine Object format' and follow the remaining instructions above to make sure your new translation file is picked up by the plugin.

== Screenshots ==
1. By default the PolyLang quick links don't work due to a bug in the CF7 plugin.  You can fix the bug in your own copy of CF7 by following these [instructions](#cf7change).
2. Contact form table list with Polylang language columns.
3. Creating a new translation form, with polylang language metabox options.
4. There is a bug in the integration which fails to pick the fact that language options have been saved.  So even after click the 'Save' button you will see the familiar alert window popup, you can safely ignore the message.

== Changelog ==

= 1.0 =
* first version


== CF7 Code Modification ==

As of this writing, Contact Form 7 plugin does not provide any hook mechanism to add additional columsn to the form table list.  This is due to the fact that the form plugin was coded at a time when Wordpress offered very little such flexibility.  To enable the language coulmns in the CF7 table list, a small change needs to be done in the code,  the file `admin/includes/class-contact-forms-list-table.php` in the plugin folder has the following function on line 88,

`function column_default( $item, $column_name ) {
  return '';
}
`

this need to be changed to,

`function column_default( $item, $column_name ) {
  return apply_filters( "manage_cf7_custom_column", $column_name, $item->id() );
}
`

if you want the language columns to be filled in.  I have [requested the author](https://wordpress.org/support/topic/request-for-new-filter-for-extending-cf7-admin-dashboard-table) of the plugin to include the modification in his next release, so I hope this will not be required in the future.

As of CF7 v4.4.1 this change has yet to be included.  If you read this and CF7 has been updated but the filter has not been included, please link to the above support thread and voice your request for this filter.  The more people request this change the more likely the author will include it.
