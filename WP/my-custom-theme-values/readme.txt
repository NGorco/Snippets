=== My Custom Theme Values===
Contributors: Junaid Iqbal   
Author link: http://www.junaidiqbal.net
Donate Link: http://www.junaidiqbal.net
Tags: theme, values, theme values, custom theme values, custom theme options, short code, short code option, custom, custom field, custom field template, custom fields, custom post type, field, fields, meta, template,add custom fields to search, book custom post type, castom, custom, custom field, custom fields search, custom post, custom search, custom search plugin, cutom, default post types, feld, field, include custom fields in search, portfolio custom post type, Post, search, search by custom fields, search by custom post types, serach, website search,admin, advanced, custom, custom field, edit, field, file, image, magic fields, matrix, more fields, Post, repeater, simple fields, text, textarea, type,custom field, custom field groups, custom fields, custom fields for taxonomy terms, custom-post-type-fields, dropdown field, extra fields, extra parameters, more fields, numeric field, page attributes, page fields, post attributes, post fields, sortable custom field groups, sortable custom fields, text field, textarea
Requires at least: 3
Version: 1.1
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later 

This plugin will provide user to use the custom dynamic values anywhere on the site.

== Description ==

This plugin will provide user to use the custom dynamic values anywhere on the site by editing code OR by simply using short code that you can see the details on the plug-in setting page.


== Frequently Asked Questions ==

If you have any query just drop me a message on junaid19_0688@yahoo.com. 

== Upgrade Notice ==

Not available. 

== Installation ==

1. Upload `custom-theme-values.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Now need to go on Theme Setting page and add your content.
After saving all your values in plug-in setting page, use echo get_option( 'my_value' )[0]; in code to render value in frontend OR Use short code [get-my-values key="my_value(0)"] in posts and pages to render values.
You can also use short code button that appears on post and page editor.

== Screenshots ==

1. Plugin settings page.
2. Post Shortcode and TinyMCE Button for Shortcode.

== Changelog ==

= 1.1 =
* New feature: Adds the button of short code on editor of posts and pages.
* Fix Code: Fix the code to work on php 4 and 5 both.
* Add file: Add new javascript file named as 'editor_sc.js' and updated the icon image.