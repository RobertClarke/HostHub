<?php

namespace HostList;

use MysqliDb;

class User extends Model {

	// Users unique id
	private $id		= 0;

	// List of users data collected in an array
	private $data	= [];

	/**
	 * Constructor
	 *
	 * @param  int|string $identifier  Identifier to search with for a user. Can be integer (id) or string (username)
	 * @param  string     $key         Key to use for search (username/email). Automatically 'id' if $identifier is an integer
	 * @return boolean                 False if a $id user is not found
	 */
	public function __construct( $identifier, $key='username' ) {

		if ( is_numeric($identifier) )
			$result = self::get_by('id', $identifier);

		elseif ( is_string($identifier) && in_array($key, ['username', 'email']) )
			$result = self::get_by($key, $identifier);

		else
			return false;

		// Check if a result has been found in the database
		if ( $result ) {
			$this->id	= $result['id'];
			$this->data	= $result;
		}
		else
			return false;

		// Add newly created user object to object cache
		cache_add($this->id, $this, 'users_objects');

	}

	/**
	 * Gets user information from the database using a key and value
	 *
	 * @param  string $key    The key to search with (column)
	 * @param  string $value  The value to search with
	 * @return array|boolean  Array of user data on success, false on failiure
	 */
	public static function get_by( $key, $value ) {

		$db = MysqliDb::getInstance();

		// Validate value based on key being used
		switch ( $key ) {
			case 'id':
				$value = $user_id = filter_var($value, FILTER_VALIDATE_INT, ['min_range' => 0]);
			break;
			case 'username':
				$value = $db->escape($value);
				$user_id = cache_get($value, 'users_username');
			break;
			case 'email':
				$value = filter_var($value, FILTER_VALIDATE_EMAIL);
				$user_id = cache_get($value, 'users_email');
			break;
			default:
				return false; // Invalid $key provided
		}

		// Validation on $value failed
		if ( $value === false )
			return false;

		// Attempt to fetch user info from cache
		if ( $user_id !== false && $user = cache_get($user_id, 'users') )
			return $user;

		// Attempt to fetch user info from database
		if ( !$user = $db->where($key, $value)->getOne('users') )
			return false;

		cache_add($user['id'], $user, 'users');
		cache_add($user['username'], $user['id'], 'users_username');
		cache_add($user['email'], $user['id'], 'users_email');

		return $user;

	}

	public function val( $key ) {
		return ( empty($this->data) || !array_key_exists($key, $this->data) ) ? false : $this->data[$key];
	}

	public function is_activated() {
		return ( $this->val('activated') == '1' );
	}

	public function is_suspended() {
		return ( $this->val('status') == '-1' );
	}

	public function is_banned() {
		return ( $this->val('status') == '-2' );
	}

	public function is_deleted() {
		return ( $this->val('deleted') == '1' );
	}

}
