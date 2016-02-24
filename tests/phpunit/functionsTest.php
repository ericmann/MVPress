<?php
namespace MVPress;

use WP_Mock;

/**
 * Class TestTemplateFunctions
 * @package MVPress
 *
 * @runTestsInSeparateProcesses
 * @group   template
 */
class TestTemplateFunctions extends TestCase {

	protected $testFiles = array(
		'class-wp-template.php',
		'class-wp-templatecontext.php',
		'general-template.php',
	);

	/**
	 * Setup method to be run before each test.
	 *
	 * Configures function mocks as necessary.
	 */
	public function setUp() {
		parent::setUp();

		require_once 'dummy-files/wp_error.php';

		WP_Mock::wpFunction( 'get_stylesheet_directory', array( 'return' => __DIR__ ) );
		WP_Mock::wpFunction( 'get_template_directory',   array( 'return' => __DIR__ ) );
	}

	/**
	 * Test that the template part was retrieved.
	 *
	 * @group template
	 */
	public function test_template_part_retrieved() {
		$model       = new \stdClass;
		$model->text = 'template test.';
		$_REQUEST    = array( 'times' => 99 );

		WP_Mock::wpFunction( 'locate_template', array(
			'return_in_order' => array(
				__DIR__ . '/templates/test-context.php',
				__DIR__ . '/templates/test-model.php',
			)
		) );

		\WP_Mock::wpPassthruFunction( '__' );

		ob_start();
		get_template_part( 'templates/test', 'context', $model );
		$output = ob_get_clean();

		$this->assertEquals( 'Context claims something happened 99 times!', $output );

		ob_start();
		get_template_part( 'templates/test', 'model', $model );
		$output = ob_get_clean();

		$this->assertEquals( 'This is a template test.', $output );
	}
}
