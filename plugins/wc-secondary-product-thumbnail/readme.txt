=== WC Secondary Product Thumbnail ===
Contributors: frosdqy
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6AD46HAX3URN4
Tags: woocommerce, hover, reveal, product, images
Requires at least: 3.8
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: trunk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

This plugin adds a hover effect that will reveal a secondary product thumbnail to product images on your WooCommerce product listings.

== Description ==

WC Secondary Product Thumbnail (WCSPT) adds a hover effect that will reveal a secondary product thumbnail to product images on your WooCommerce product listings. This plugin is ideal for displaying front and back images of products.

= Features =
* Can either reveal the first image or the last image in product gallery
* High-performance animations using CSS3 transitions
* Fallback to jQuery's .animate(), if needed
* Ultra lightweight
* Most WooCommerce compatible themes are supported
* Compatible with AJAX products loading
* Supports IE 8+ and all of the evergreen browsers
* WordPress Multisite support

= More Information =
See [plugin documentation](https://www.thewebflash.com/wcspt-documentation/).

= WCSPT Needs Your Support =
If you like this plugin and find it useful, you can show your appreciation and support future development by [donating](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6AD46HAX3URN4).


== Installation ==

1. From your WordPress dashboard, go to **Plugins** > **Add New**
2. Search for **WC Secondary Product Thumbnail**
3. Click **Install Now**
4. Activate the plugin
5. Enjoy!


== Screenshots ==

1. A secondary product thumbnail revealed on hover.


== Changelog ==

= 1.3.2 =
* Fixed execution order of the function that adds secondary product thumbnail
* Fixed compatibility issue with caching plugins

= 1.3.1 =
* Added support for the version check feature in WooCommerce 3.2+
* Dev - Removed `wcspt_disable_on_mobile` filter hook

= 1.3 =
* Added support for AJAX products loading (e.g. infinite scroll and load more button)
* Added support for WordPress Multisite
* Compatible up to Wordpress 4.9 and WooCommerce 3.2
* Refactored and optimized plugin code

= 1.2.1 =
* Fix - WooCommerce 3.0 compatibility

= 1.2 =
* Feature - Can reveal the last image in product gallery instead of the first image, see plugin documentation
* Tweak - Better animation timing
* Tweak - Further improve themes compatibility
* Dev - Removed `wc_secondary_product_thumbnail_styles` filter hook

= 1.1.2 =
* Minor CSS improvements

= 1.1.1 =
* Use minified CSS & JS files rather than the non-minified versions, if SCRIPT_DEBUG is not turned on

= 1.1 =
* Animations now use CSS3 transitions for smoother animation effect
* Fallback to jQuery's .animate() in legacy browsers (e.g. IE 8-9)
* Improved performance

= 1.0.4 =
* Tested with WordPress 4.6 and WooCommerce 2.6
* Replace deprecated jQuery(document).ready(function) with jQuery(function)

= 1.0.3 =
* Fix a fatal error when $product->get_gallery_attachment_ids() is called on some themes.
* Code cleanup.

= 1.0.2 =
* Minor CSS fixes.

= 1.0.1 =
* Fix secondary thumbnail opacity issue on some themes.

= 1.0 =
* Initial release.


== Upgrade Notice ==

= 1.1 =
Animations now use CSS3 transitions instead of jQuery's .animate()