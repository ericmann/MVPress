<?php
class WP_Error {
	static $last_code = 0;

	static $last_message = '';

	static $last_data = null;

	public function __construct( $code, $message, $data ) {
		self::$last_code = $code;
		self::$last_message = $message;
		self::$last_data = $data;
	}
}