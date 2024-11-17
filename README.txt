=== Fast Social Media AI Poster ===
Contributors: tamimh
Tags: social-media, auto-poster, ai, wordpress, woocommerce
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight WordPress plugin that analyzes your content and generates custom social media posts with relevant hashtags for various platforms.

== Description ==
Fast Social Media AI Poster is a WordPress plugin that automatically analyzes your WooCommerce product posts and generates engaging social media posts for platforms like Twitter and Facebook. It creates tailored content along with relevant hashtags, and can schedule these posts for optimal engagement.

== Installation ==

1. Upload `fast-social-media-ai-poster.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin settings as needed.

== Configuration ==

To enable the auto-post feature for each individual product:

1. Go to **Products > All Products** in WooCommerce.
2. For each product, click **Edit**.
3. In the product edit page, navigate to the **Social Media** tab.
4. Check the "Enable Auto-Post" checkbox to allow automatic posting for that product.

> *Note:* Each product requires this checkbox to be selected individually to activate the auto-post feature. This is the only functionality offered by the plugin; there are no additional settings pages or configuration options.

== Frequently Asked Questions ==

= What is the purpose of this plugin? =
This plugin analyzes your WooCommerce product content and generates custom social media posts with relevant hashtags, allowing for automated posting to various platforms.

= How do I enable the auto-post feature for each product? =
To enable auto-post for a product, go to **Products > All Products**, edit the product, navigate to the **Social Media** tab, and check the "Enable Auto-Post" checkbox.

== Screenshots ==

1. Screenshot of the auto-post checkbox on the product page

== Changelog ==

= 1.0.0 =
* Initial release of the plugin
* Added functionality to analyze WooCommerce product posts and generate custom social media posts with hashtags
* Enabled scheduling of posts for optimal engagement

== Upgrade Notice ==

= 1.0.0 =
Initial release of the plugin.

== Arbitrary section ==

This plugin uses the following hooks and filters to modify WooCommerce behavior:

* `woocommerce_product_options_general_product_data`
* `woocommerce_process_product_meta`
* `wp_insert_post`
* `wp_schedule_event`

These hooks and filters can be customized if needed.

== A brief Markdown Example ==

Ordered list:

1. Analyze WooCommerce product posts for social media.
2. Generate custom social media posts with relevant hashtags.
3. Schedule posts for optimal engagement.

Unordered list:

* Easy to use and configure
* Compatible with WooCommerce 3.0.1 and later
* Automatically generates engaging content for social media

Here's a link to [WooCommerce](https://woocommerce.com/ "Your favorite e-commerce plugin") and one to [WordPress](http://wordpress.org/ "Your favorite software").

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up for **strong**.

`<?php code(); // goes in backticks ?>`