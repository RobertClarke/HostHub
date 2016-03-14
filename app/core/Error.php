<?php

namespace HostList;

class ErrorContainer {

	protected static $_instance;

	// Array container for Error objects
	private $errors = [];

	public function __construct() {
		self::$_instance = $this;
	}

	public function add( $error ) {

		if ( $error instanceof Error )
			$this->errors[ $error->get_code() ] = $error;

		else if ( is_array($error) && isset($error['code']) )
			$this->errors[ $error['code'] ] = new Error( $error['code'], $error['message'] );

		else
			return false;

	}

	public function add_code( $code ) {
		$this->errors[$code] = new Error($code);
	}

	public function set_messages( $arr ) {

		foreach ( $this->errors as $code => $error ) {

			if ( array_key_exists($code, $arr) )
				$this->errors[$code]->set_message( $arr[$code] );

		}

	}

	public function return() {

		$return = [];

		foreach ( $this->errors as $code => $obj ) {
			$return[] = $obj->get_message();
		}

		return $return;

	}

	public function is_empty() {
		return ( empty($this->errors) );
	}

	public static function getInstance() {
        return self::$_instance;
    }

}

class Error {

	private $code;
	private $message = '';

	public function __construct( $code, $message='' ) {
		$this->code = $code;
		$this->message = $message;
	}

	public function get_code() {
		return $this->code;
	}

	public function get_message() {
		return $this->message;
	}

	public function set_code( $code ) {
		$this->code = $code;
	}

	public function set_message( $message ) {
		$this->message = $message;
	}

}
