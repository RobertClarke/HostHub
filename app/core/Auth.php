<?php

namespace HostList;

use MysqliDb;
use Mandrill;

class Auth {

	/**
	 * Attempts to authenticate a user given a $username and $password.
	 *
	 * @param  string     $username  Users username
	 * @param  string     $password  Users password
	 * @return User|Error            Depending on success/fail
	 */
	public static function login( $username, $password ) {

		// Note: username and email are already escaped in User::get_by()

		// Check if fields empty
		if ( empty($username) || empty($password) )
			return new Error('AUTH_MISSING_VALUES');

		// If username is actually an email, check if the email exists
		if ( filter_var($username, FILTER_VALIDATE_EMAIL) !== false ) {

			if ( User::get_by('email', $username) !== false )
				$user = new User($username, 'email');
			else
				return new Error('AUTH_FAILED_EMAIL');

		}

		// Check to see if the username exists
		else {

			if ( User::get_by('username', $username) !== false )
				$user = new User($username, 'username');
			else
				return new Error('AUTH_FAILED_USER');

		}

		// Check users password against database
		if ( !password_verify( $password, $user->val('password') ) ) {

			if ( filter_var($username, FILTER_VALIDATE_EMAIL) !== false )
				return new Error('AUTH_FAILED_EMAIL');
			else
				return new Error('AUTH_FAILED_USER');

		}

		// Check if user deleted
		if ( $user->is_deleted() )
			return new Error('AUTH_DELETED');

		// Check if user banned
		if ( $user->is_banned() )
			return new Error('AUTH_BANNED');

		// Check if user suspended
		if ( $user->is_suspended() )
			return new Error('AUTH_SUSPENDED');

		// Auth successful! 🎉
		return $user;

	}

	/**
	 * Validates registration inputs that are passed through.
	 *
	 * @param  array                   $reg  Array of input values from the registration form
	 * @return boolean|ErrorContainer        Depending on success/fail
	 */
	public static function check_registration( $reg ) {

		$errors = new ErrorContainer();

		/**
		 * USERNAME CHECKS
		 */
		if ( empty($reg['username']) )
			$errors->add_code('USERNAME_MISSING');

		else if ( !Auth::username_valid($reg['username']) )
			$errors->add_code('USERNAME_INVALID');

		else if ( strlen($reg['username']) < 5 || strlen($reg['username']) > 20 )
			$errors->add_code('USERNAME_LENGTH');

		else if ( User::get_by('username', $reg['username']) )
			$errors->add_code('USERNAME_TAKEN');

		/**
		 * EMAIL CHECKS
		 */
		if ( empty($reg['email']) )
			$errors->add_code('EMAIL_MISSING');

		else if ( filter_var($reg['email'], FILTER_VALIDATE_EMAIL) == false )
			$errors->add_code('EMAIL_INVALID');

		else if ( strlen($reg['email']) > 100 )
			$errors->add_code('EMAIL_LENGTH');

		else if ( User::get_by('email', $reg['email']) )
			$errors->add_code('EMAIL_TAKEN');

		/**
		 * PASSWORD CHECKS
		 */
		if ( empty($reg['password']) )
			$errors->add_code('PASSWORD_MISSING');

		else if ( strpos($reg['password'], $reg['username']) !== false )
			$errors->add_code('PASSWORD_HAS_USERNAME');

		else if ( strlen($reg['password']) < 8 )
			$errors->add_code('PASSWORD_SHORT');

		else if ( strlen($reg['password']) > 100 )
			$errors->add_code('PASSWORD_LONG');

		/**
		 * TERMS AND CONDITIONS CHECKS
		 */
		if ( !$reg['agree'] )
			$errors->add_code('TERMS_MISSING');

		// Some errors were found
		if ( !$errors->is_empty() )
			return $errors;

		return true;

	}

	/**
	 * Registers a new user given an array of username/email/password.
	 *
	 * WARNING: This function assumes you've already ran Auth::check_registration() so
	 *          ensure that is ran first to verify all input fields are valid.
	 *
	 * @param  array       $reg  Array of input values from the registration form
	 * @return array|Error       The activation token and user info array success, Error object on fail
	 */
	public static function register( $reg ) {

		$db = MysqliDb::getInstance();

		$row = [
			'username'		=> $db->escape($reg['username']),
			'password'		=> password_hash($reg['password'], PASSWORD_DEFAULT),
			'email'			=> $reg['email'],
			'date_joined'	=> date('Y-m-d H:i:s'),
			'login_ip'		=> filter_input(INPUT_SERVER, 'REMOTE_ADDR'),
		];

		// Attempt to create a new user in the database
		$create = $db->insert('users', $row);

		if ( $create ) {

			// Create an activation token for the user
			$token = [
				'user_id'	=> $create,
				'token'		=> random_str(24),
				'created'	=> date('Y-m-d H:i:s'),
			];

			$create_token = $db->insert('user_activations', $token);

			return array_merge($row, $token);

		}

		// Something went wrong with the SQL insert, let the user know to try again later
		else
			return new Error('REGISTER_FAILED');

	}

	/**
	 * Sends an activation email given a username/user id. Won't send an email if the user
	 * has already activated their account previously.
	 *
	 * @param  string|int $id  Username or user id of the user to send the email to
	 * @return boolean         Whether or not an email ended up getting sent off
	 */
	public static function send_activation_email( $id ) {

		$db = MysqliDb::getInstance();

		if ( is_numeric($id) )
			$user = User::get_by('id', $id);

		elseif ( is_string($id) )
			$user = User::get_by('username', $id);

		if ( $user ) {

			// Check if user has already activated their account
			if ( $user['activated'] == 0 ) {

				global $twig;

				// Get activation token from database
				$token = $db->where('user_id', $user['id'])->getOne('user_activations')['token'];

				// Template parameters
				$params = [
					'title'		=> '🌟 Activate Your Host List Account',
					'username'	=> $user['username'],
					'url'		=> MAIN_URL . '/activate/' . $token,
				];

				// Load and render email template
				$template = $twig->loadTemplate('email/activate.tpl');
				$email_html = $template->render($params);

				// Send email via. Mandrill API
				$mandrill = new Mandrill(MANDRILL_API_KEY);

				$message = [
					'html'			=> $email_html,
					'subject'		=> $params['title'],
					'from_email'	=> 'noreply@hostlist.com',
					'from_name'		=> 'Host List',
					'to'			=> [['email' => $user['email']]],
					'headers'		=> ['Reply-to', 'noreply@hostlist.com'],
					'tags'			=> ['activations'],
					'track_opens'	=> true,
					'track_clicks'	=> true,
					'async'			=> true,
				];

				try {
					$send = $mandrill->messages->send($message, $message['async']);
				}
				catch(Mandrill_Error $e) {}

				return true;

			}
			else
				return false;

		}
		else
			return false;

	}

	/**
	 * Force sends an activation email given an array of values. Unlike send_activation_email(),
	 * this function will send an email regardless of the users activation status.
	 *
	 * Primarily used to avoid extra database calls during user registration.
	 *
	 * @param  string $username  Username to display in email
	 * @param  string $email     Email to deliver the message to
	 * @param  string $token     Activation token to display in the activate button
	 * @return boolean           Whether or not an email ended up getting sent off
	 */
	public static function force_activation_email( $username, $email, $token ) {

		global $twig;

		// Template parameters
		$params = [
			'title'		=> '🌟 Activate Your Host List Account',
			'username'	=> $username,
			'url'		=> MAIN_URL . '/activate/' . $token,
		];

		// Load and render email template
		$template = $twig->loadTemplate('email/activate.tpl');
		$email_html = $template->render($params);

		// Send email via. Mandrill API
		$mandrill = new Mandrill(MANDRILL_API_KEY);

		$message = [
			'html'			=> $email_html,
			'subject'		=> $params['title'],
			'from_email'	=> 'noreply@hostlist.com',
			'from_name'		=> 'Host List',
			'to'			=> [['email' => $email]],
			'headers'		=> ['Reply-to', 'noreply@hostlist.com'],
			'tags'			=> ['activations'],
			'track_opens'	=> true,
			'track_clicks'	=> true,
			'async'			=> true,
		];

		try {
			$send = $mandrill->messages->send($message, $message['async']);
		}
		catch(Mandrill_Error $e) {}

		return true;

	}

	/**
	 * Creates and sets an authentication cookie for a given user.
	 *
	 * @param User|string|int  $user      User object (preferred) or users id/username
	 * @param boolean          $remember  Whether or not to 'remember me'
	 */
	public static function set( $user, $remember=false ) {

		// If $user is a string, atttempt to create new User object for use
		if ( !$user instanceof User && !$user = new User($user) )
			return false;

		$username	= $user->val('username');

		// Default expiry for 'remember me' is 3 months
		$expiry		= ( $remember ) ? time()+(60*60*24*30*3) : 0;

		// Password fragment
		$fragment	= substr( $user->val('password'), 10, 12 );

		// Create hashes
		$hash_key	= hash_hmac('sha1', $username.'|'.$fragment.'|'.$expiry, KEY_SECRET);
		$hash		= hash_hmac('sha1', $username.'|'.$expiry, $hash_key);

		cookie_set('hostlist_auth', $username.'|'.$expiry.'|'.$hash, $expiry);

		return;

	}

	public static function validate() {

		$cookie = filter_input(INPUT_COOKIE, 'hostlist_auth');

		// Check for cookie existence
		if ( $cookie === null || $cookie === false )
			return false;

		// Check if cookie is in valid format, not expired and that the user exists
		if ( !$cookie = Auth::parse($cookie) ) {
			Auth::expire();
			return false;
		}

		// Check if cookie is expired
		if ( $cookie['expiry'] != 0 && time() > $cookie['expiry'] ) {
			Auth::expire();
			return false;
		}

		// Check if user is valid in the database
		if ( !$user = new User($cookie['user']) ) {
			Auth::expire();
			return false;
		}

		// Password fragment
		$fragment	= substr( $user->val('password'), 10, 12 );

		// Create hashes
		$hash_key	= hash_hmac('sha1', $cookie['user'].'|'.$fragment.'|'.$cookie['expiry'], KEY_SECRET);
		$hash		= hash_hmac('sha1', $cookie['user'].'|'.$cookie['expiry'], $hash_key);

		// Compare hashes
		if ( $hash != $cookie['token'] ) {
			Auth::expire();
			return false;
		}

		return $user;

	}







	public static function allowed( $user ) {

		// If $user is a string, atttempt to create new User object for use
		if ( !$user instanceof User && !$user = new User($user) )
			return false;

		// Check if the user is deleted
		if ( $user->val('deleted') == 1 ) {
			$reason = 'deleted';
		}

		// Check users account status if they are suspended/banned
		else {
			switch ( $user->val('status') ) {
				case '-2': // banned
					$reason = 'banned';
				break;
				case '-1': // suspended
					$reason = 'suspended';
				break;
			}
		}

		// We have a reason to kick this user off
		if ( isset($reason) ) {

			Auth::expire();
			redirect('/login?reason=' . $reason);
			return false;

		}

		return true;

	}



	public static function logout() {
		Auth::expire();
		redirect('/login?loggedout');
	}



	public static function logged_in() {

		return ( Auth::validate() == true );

	}



	public static function logged_in_redirect( $target='/' ) {
		if ( Auth::logged_in() )
			redirect($target);
	}

	public static function logged_out_redirect( $target='/' ) {
		if ( !Auth::logged_in() )
			redirect($target);
	}



	public static function expire() {
		cookie_expire('hostlist_auth');
		return;
	}

	private static function parse( $cookie ) {

		$cookie = explode('|', $cookie);

		// Check if cookie is in vaild format
		if ( empty($cookie) || count($cookie) != 3 )
			return false;

		list($user, $expiry, $token) = $cookie;

		return compact('user', 'expiry', 'token');

	}


	public static function username_valid( $username ) {
		return ( preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $username) );
	}

}
