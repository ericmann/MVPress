<?php
/**
 * MVPress Library Autoloader
 *
 * @author    Eric Mann <eric@eamann.com>
 * @copyright 2015 Eric Mann
 * @license   GPLv2+
 * @version   1.0.0
 */

// Require files
require_once dirname( __FILE__ ) . 'php/class-wp-template.php';
require_once dirname( __FILE__ ) . 'php/class-wp-templatecontext.php';
require_once dirname( __FILE__ ) . 'php/general-template.php';

/**
 * Back-compate shortcut to create a new WP_Template object and render it on the page.
 *
 * Template file will be fetched from the theme assuming it is named {$slug}-{$name}.php. To reference templates
 * in a subdirectory, add the subdirectory to the $name parameter.
 *
 * For example, assuming you need to reference the template file in /templates/special-video.php, you would call
 * get_template_part( 'templates/special', 'video' ), optionally passing in $model and $context objects.
 *
 * @deprecated since 1.0.0 Use \MVPress\get_template_part()
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