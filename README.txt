=== Fast WordPress Media Cleaner ===
Contributors: tamimh
Tags: wordpress, media-cleaner, unused-media, wordpress-plugin
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight WordPress plugin that helps you identify and delete unused media files in your WordPress directory.

== Description ==
Fast WordPress Media Cleaner is a WordPress plugin that scans your WordPress directory for unused media files and helps you delete them. It's a simple and efficient way to clean up your WordPress installation and free up disk space.

== Installation ==

1. Upload `fast-wordpress-media-cleaner.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin settings as needed.

== Configuration ==

To use the plugin, follow these steps:

1. Go to **Media > Unused Media** in WordPress.
2. The plugin will scan your WordPress directory for unused media files.
3. Review the list of unused media files and select the ones you want to delete.
4. Click the "Delete" button to delete the selected files.

> *Note:* Be careful when deleting files, as this action is permanent and cannot be undone.

== Frequently Asked Questions ==

= What is the purpose of this plugin? =
This plugin helps you identify and delete unused media files in your WordPress directory, freeing up disk space and keeping your WordPress installation clean.

= How do I use the plugin? =
To use the plugin, go to **Media > Unused Media** in WordPress, review the list of unused media files, select the ones you want to delete, and click the "Delete" button.

== Screenshots ==

1. Screenshot of the unused media files list

== Changelog ==

= 1.0.0 =
* Initial release of the plugin
* Added functionality to scan WordPress directory for unused media files
* Added functionality to delete selected unused media files

== Upgrade Notice ==

= 1.0.0 =
Initial release of the plugin.

== Arbitrary section ==

This plugin uses the following hooks and filters to modify WordPress behavior:

* `wp_insert_post`
* `wp_delete_attachment`

These hooks and filters can be customized if needed.

== A brief Markdown Example ==

Ordered list:

1. Scan WordPress directory for unused media files.
2. Review the list of unused media files.
3. Delete selected unused media files.

Unordered list:

* Easy to use and configure
* Compatible with WordPress 6.0 and later
* Helps keep your WordPress installation clean and organized

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software").