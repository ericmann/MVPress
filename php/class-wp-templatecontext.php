<?php
namespace MVPress;

/**
 * Context object made available for rendered templates. Contains information pertaining to the template instance,
 * it's invoker, and the context in which the template was created.
 *
 * @property-read \WP_Query $query    Current WP_Query instance
 * @property-read array     $request  Shortcut to PHP's global $_REQUEST array
 * @property      string    $template Source of the template file
 * @property      array     $data     Arbitrary user data storage
 *
 * @package WordPress
 * @subpackage Templates
 * @since 3.9.0
 */
class WP_TemplateContext {
	/**
	 * @var array Data storage
	 */
	protected $_collection;

	/**
	 * Default object constructor
	 */
	public function __construct() {
		$this->_collection         = array();
		$this->_collection['data'] = apply_filters( 'default_template_data', array() );
	}

	/**
	 * Magic method for grabbing object properties from storage.
	 *
	 * Lazy-loads properties from global objects and WordPress environment.
	 *
	 * @param string $property Property name to retrieve
	 *
	 * @return mixed
	 */
	public function __get( $property ) {
		if ( array_key_exists( $property, $this->_collection ) ) {
			return $this->_collection[ $property ];
		}

		switch ( $property ) {
			case 'query':
				global $wp_query;
				$this->_collection['query'] = $wp_query;

				return $this->_collection['query'];
				break;
			case 'request':
				$this->_collection['request'] = $_REQUEST;

				return $this->_collection['request'];
				break;
		}

		return new \WP_Error( 'unknown-template-context-property', __( 'Unknown context property.' ), $property );
	}

	/**
	 * Magic setter for populating the writable parts of the object.
	 *
	 * If setting the property to the same value as already stored, we won't do anything.
	 *
	 * @param string $property
	 * @param mixed  $value
	 */
	public function __set( $property, $value ) {
		// If the property is read-only, just return.
		$read_only_fields = array( 'query', 'request' );
		if ( in_array( $property, $read_only_fields ) ) {
			return;
		}

		$this->_collection[$property] = $value;
	}
}