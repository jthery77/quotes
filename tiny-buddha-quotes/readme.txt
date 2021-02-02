=== Plugin Name ===
Contributors: michaelmartin
Tags: Tiny Buddha, Quotes, Wisdom, Widgets
Requires at least: 3.0.0
Tested up to: 3.0.0
Stable tag: trunk

Get Tiny Buddha quotes delivered daily to your website.

== Description ==

This plugin will take quotes from [TinyBuddha.com](http://tinybuddha.com/) and allow you to display them on your blog.

You can either use the widget provided, or the template tag:

`<?php if (function_exists('tb_wisdom_view')) { tb_wisdom_view(); } ?>`

== Installation ==

1. Upload the 'tiny-buddha-quotes.zip' file via Plugins > Add New > Upload' OR Upload the 'tiny-buddha-quotes' folder to the '/wp-content/plugins/' directory via FTP.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enable the widget via 'Appearance > Widgets' in your dashboard. You can place it in your sidebar, footer, or any other widgetized area.

Alternatively, you can place the template tag manually in your theme:

`<?php if (function_exists('tb_wisdom_view')) { tb_wisdom_view(); } ?>`

== Frequently Asked Questions ==

= How Often Do Quotes Update? =

The plugin will automatically check for a new each day. The quote will match Tiny Buddha's Monday to Friday, and pull random quotes from the archive on the weekends.

= What if the Update Fails? =

If it fails to find a new quote for any reason, then it will use a fallback quote instead and check again for a new quote in 10 minutes.

== Screenshots ==

1. The widget in use.

== Changelog ==

= 1.0 =
* Initial release.
