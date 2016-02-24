<?php

namespace MVPress;

/**
 * Class TestTemplate
 *
 * @package MVPress
 *
 * @runTestsInSeparateProcesses
 * @group   template
 */
class TestTemplate extends TestCase {

	protected $testFiles = array(
		'class-wp-template.php',
		'class-wp-templatecontext.php',
	);

	/**
	 * Ensure the included template can reference the model object.
	 *
	 * @group template
	 */
	public function test_include_can_reference_model() {
		$model       = new \stdClass;
		$model->text = 'test';
		$template    = new WP_Template( __DIR__ . '/templates/test-model.php', $model );

		$this->expectOutputString( 'This is a test' );
		$template->render();
	}

	/**
	 * Ensure the included template can reference the context object.
	 *
	 * @group template
	 */
	public function test_include_can_reference_context() {
		$_REQUEST = array( 'times' => 5 );
		$template = new WP_Template( __DIR__ . '/templates/test-context.php', null );

		$this->expectOutputString( 'Context claims something happened 5 times!' );
		$template->render();
	}
}
