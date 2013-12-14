=== MVPress ===
Contributors:      ericmann
Donate link:       http://wordpress.org/plugins/mvpress
Tags:              MVC, template, get_template_part
Requires at least: 3.7.1
Tested up to:      3.8
Stable tag:        0.1.0
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

MVC-style template loader for WordPress

== Description ==

Allows for models and contextual data to be passed in to WordPress theme template files.

== Installation ==

= Manual Installation =

1. Upload the entire `/mvpress` directory to the `/wp-content/plugins/` directory.
2. Activate MVPress through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How do I use it? =

Just replace `get_template_part()` with `mvpress_template_part()` in your themes.  From now on, you can reference `$this->model` to manipulate any data model passed in and `$this->context->query` to access the current `WP_Query` instance without the need to declare a messy global variable.

= How do I pass a model? =

Simply specify the once optional third parameter when calling `mvpress_template_part()`.  This value will be passed in directly to the model container.

= How can I pass other data? =

The fourth (again, optional) parameter of the `mvpress_template_part()` function accepts an array of temporary data, which will be available within the template as `$this->context->tempData`.

== Screenshots ==


== Changelog ==

= 0.1.0 =
* First release

== Upgrade Notice ==

= 0.1.0 =
First Release