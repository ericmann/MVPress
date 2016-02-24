<?php
/**
 * General template tags that can go anywhere in a template.
 *
 * @package WordPress
 * @subpackage Template
 */

namespace MVPress;

/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @since 3.0.0
 *
 * @param string $slug    The slug name for the generic template.
 * @param string $name    The name of the specialised template (optional.
 * @param mixed  [$model] Object to be passed in to the view (optional).
 * @param array  [$data]  Object to pass additional contextual information (optional).
 *
 * @return void
 */
function get_template_part( $slug, $name = null, $model = null, $data = array() ) {
	/**
	 * Fires before the specified template part file is loaded.
	 *
	 * The dynamic portion of the hook name, `$slug`, refers to the slug name
	 * for the generic template part.
	 *
	 * @since 3.0.0
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialized template.
	 */
	do_action( "get_template_part_{$slug}", $slug, $name );

	$templates = array();
	if ( 'string' === gettype( $name ) ) {
		// If $name is a string, assume it's a template part definition and load a template.
		$templates[] = "{$slug}-{$name}.php";
	} elseif ( null !== $name ) {
		// If $name is non-null and also not a string, then we're overloading the method as ( $slug, $model, $data )
		if ( null !== $model ) {
			// The third parameter (now assumed to be $data) is non-null, so move it to the proper variable.
			$data = $model;
		}

		// Move the data model from the second variable ($name) to its proper place.
		$model = $name;
	}
	$templates[] = "{$slug}.php";

	$path = locate_template( $templates );

	if ( '' === $path ) {
		return;
	}

	$template = new WP_Template( $path, $model, $data );

	$template->render();
}