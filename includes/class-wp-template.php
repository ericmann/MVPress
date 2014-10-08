<?php
/**
 * Wrapper class for building out template parts as views and passing arbitrary data models to the theme front end
 * with contextual data.
 *
 * @package WordPress
 * @subpackage Templates
 * @since 3.9.0
 */
class WP_Template {
	/**
	 * @var mixed Arbitrary data model
	 */
	protected $model;

	/**
	 * @var string Name of the template file to invoke.
	 */
	protected $view;

	/**
	 * @var WP_TemplateContext View context
	 */
	public $context;

	/**
	 * Default Constructor
	 *
	 * @param string $src
	 * @param mixed  $model
	 * @param array  $tempData Optional additional data
	 */
	public function __construct( $src, $model, $tempData = array() ) {
		$this->context = new WP_TemplateContext();

		$this->context->template = $src;
		$this->context->tempData = array_merge( $this->context->tempData, $tempData );

		$this->view  = $src;
		$this->model = $model;
	}

	/**
	 * Set up global variables and include the template file.
	 *
	 * Should declare local $model and $context variables and assign the class variables to them for easy access inside
	 * the template file scope.
	 * 
	 * @param bool $return [optional] <p>
	 * If you would like to capture the output of <b>print_r</b>,
	 * use the <i>return</i> parameter. When this parameter is set
	 * to <b>TRUE</b>, <b>print_r</b> will return the information rather than print it.
	 *
	 * @uses include()
	 */
	public function render($return = false) {
		if( ! file_exists( $this->view ) ) {
			return;
		}

		ob_start(); // turn on output buffering
		include( $this->view );
		$output = ob_get_contents(); // get the contents of the output buffer
		ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering

		if ($return)
			return $output;
		
		echo $output;
	}
}