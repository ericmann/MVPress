<?php
/**
 * Plugin Name: MVPress
 * Plugin URI:  http://wordpress.org/plugins/mvpress
 * Description: MVC-style template loader for WordPress
 * Version:     1.0.0
 * Author:      Eric Mann
 * Author URI:  http://eamann.com
 * License:     GPLv2+
 */

/**
 * Copyright (c) 2013-5 Eric Mann (email : eric@eamann.com)
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
 * @param string $name     The name of the specialised template (optional.
 * @param mixed  $model    Object to be passed in to the view (optional).
 * @param array  $tempData Object to pass additional contextual information (optional).
 *
 * @return void
 */
function mvpress_template_part( $slug, $name = null, $model = null, $tempData = array() ) {
	\MVPress\get_template_part( $slug, $name, $model, $tempData );
}