<?php

namespace MVPress;

/**
 * Class TestTemplateContext
 *
 * @package MVPress
 *
 * @runTestsInSeparateProcesses
 * @group   template
 */
class TestTemplateContext extends TestCase {

	protected $testFiles = array( 'class-wp-templatecontext.php' );

	/**
	 * Certain fields are meant to be read-only. Attempting to write them should fail.
	 *
	 * @group template
	 */
	public function test_readonly_fields() {
		$context = new WP_TemplateContext();

		// $query
		$unexpected = new \stdClass();
		$context->query = $unexpected;
		$this->assertNotSame( $unexpected, $context->query );

		// $request
		$_REQUEST = array( 'apple' => 'banana' );
		$unexpected = array();
		$context->request = $unexpected;
		$this->assertNotSame( $unexpected, $context->request );
	}

	/**
	 * Certain fields are meant to be writable.  Make sure they persist
	 *
	 * @group template
	 */
	public function test_writable_fields() {
		$context = new WP_TemplateContext();

		// User Data
		$this->assertNotEquals( array( 5 ), $context->data );
		$context->data = array( 5 );
		$this->assertEquals( array( 5 ), $context->data );
	}

	/**
	 * The context object should always contain a reference to the global $_REQUEST and wp_query
	 * objects. Make sure this happens.
	 *
	 * @group template
	 */
	public function test_has_globals() {
		global $wp_query;
		$wp_query           = new \stdClass;
		$wp_query->identity = 12345;
		$request            = $_REQUEST = array( 'identity' => 23456 );

		$context = new WP_TemplateContext();

		$this->assertEquals( $wp_query, $context->query );
		$this->assertEquals( $request, $context->request );
	}

	/**
	 * Invalid items in the getter should return a WP_Error instance
	 */
	public function test_getter_exception() {
		require_once 'dummy-files/wp_error.php';

		\WP_Mock::wpPassthruFunction( '__' );

		$context = new WP_TemplateContext();
		$context->invalid;

		$this->assertInstanceOf( 'WP_Error', $context->invalid );
	}
}
