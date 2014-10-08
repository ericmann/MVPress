<?php
/**
 * Plugin Name: MVPress
 * Plugin URI:  http://wordpress.org/plugins/mvpress
 * Description: MVC-style template loader for WordPress
 * Version:     0.1.0
 * Author:      Eric Mann
 * Author URI:  http://eamann.com
 * License:     GPLv2+
 * Text Domain: mvpress
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2013 Eric Mann (email : eric@eamann.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'MVPRESS_VERSION', '0.1.0' );
define( 'MVPRESS_URL',     plugin_dir_url( __FILE__ ) );
define( 'MVPRESS_PATH',    dirname( __FILE__ ) . '/' );

// Require our objects
require_once 'includes/class-wp-template.php';
require_once 'includes/class-wp-templatecontext.php';

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function mvpress_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'mvpress' );
	load_textdomain( 'mvpress', WP_LANG_DIR . '/mvpress/mvpress-' . $locale . '.mo' );
	load_plugin_textdomain( 'mvpress', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'mvpress_init' );

/**
 * Shortcut to create a new WP_Template object and render it on the page.
 *
 * Template file will be fetched from the theme assuming it is named {$slug}-{$name}.php. To reference templates
 * in a subdirectory, add the subdirectory to the $name parameter.
 *
 * For example, assuming you need to reference the template file in /templates/special-video.php, you would call
 * get_template_part( 'templates/special', 'video' ), optionally passing in $model and $context objects.
 *
 * @uses do_action() Calls 'get_template_part_{$slug}' action, passing both $slug and $name to the hook.
 *
 * @param string $slug     The slug name for the generic template.
 * @param string $name     The name of the specialised template (optional).
 * @param mixed  $model    Object to be passed in to the view (optional).
 * @param array  $tempData Object to pass additional contextual information (optional).
 * @param bool   $return   [optional] <p>
 * If you would like to capture the output of <b>print_r</b>,
 * use the <i>return</i> parameter. When this parameter is set
 * to <b>TRUE</b>, <b>print_r</b> will return the information rather than print it.
 *
 * @return void
 */
function mvpress_template_part( $slug, $name = null, $model = null, $tempData = array(), $return = false ) {
	do_action( "get_template_part_{$slug}", $slug, $name );

	$templates = array();
	if ( 'string' === gettype( $name ) ) {
		// If $name is a string, assume it's a template part definition and load a template.
		$templates[] = "{$slug}-{$name}.php";
	} elseif ( null !== $name ) {
		// If $name is non-null and also not a string, then we're overloading the method as ( $slug, $model, $tempData )
		if ( null !== $model ) {
			// The third parameter (now assumed to be $tempData) is non-null, so move it to the proper variable.
			$tempData = $model;
		}

		// Move the data model from the second variable ($name) to its proper place.
		$model = $name;
	}
	$templates[] = "{$slug}.php";

	$path = locate_template( $templates );

	if ( '' === $path ) {
		return;
	}

	$template = new WP_Template( $path, $model, $tempData );

	return $template->render($return);
}