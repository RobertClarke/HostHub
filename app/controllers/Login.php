<?php

namespace HostList;

class Login extends Controller {

	/**
	 * Displays the login form view.
	 */
	public function display() {

		// Redirect already logged in users
		Auth::logged_in_redirect('/dashboard');

		// Display logged extra messages, if needed
		$extras = [];

		// Logged out message
		if ( filter_input(INPUT_GET, 'loggedout') !== null )
			$extras = [
				'error' => 'You have been securely signed out.',
				'errorType' => 'success'
			];

		// Login required message
		if ( filter_input(INPUT_GET, 'auth') !== null )
			$extras = [
				'error' => 'You need to be signed in to do that. Please sign in below or <a href="/register">create an account</a>.',
				'errorType' => 'info'
			];

		$this->view->render('Auth/login', $extras);

	}

	/**
	 * Fires when the login form is submitted to the server.
	 */
	public function submit() {

		// If user is already logged in and tries an AJAX request, send a redirect status
		if ( is_ajax() && Auth::logged_in() )
			ajax_return('redirect', ['target' => '/dashboard']);

		// Redirect already logged in users
		Auth::logged_in_redirect('/dashboard');

		$input_args = [
			'username'	=> FILTER_DEFAULT,
			'password'	=> FILTER_DEFAULT,
			'remember'	=> FILTER_VALIDATE_BOOLEAN
		];

		$login = filter_input_array(INPUT_POST, $input_args);

		// Process the inputs and check if login is valid
		$result = Auth::login( $login['username'], $login['password'] );

		// Success!
		if ( $result instanceof User ) {

			// Create and set a cookie/session for the browser
			Auth::set( $result, $login['remember'] );

			if ( is_ajax() )
				ajax_return('success');

			redirect('/dashboard');

		}

		// Something went wrong
		else {

			// Error message language
			$errors = [
				'AUTH_MISSING_VALUES'	=> 'Your username or password was missing.',
				'AUTH_FAILED_EMAIL'		=> 'The email or password you entered is incorrect.',
				'AUTH_FAILED_USER'		=> 'The username or password you entered is incorrect.',
				'AUTH_DELETED'			=> 'Your account has been permanently closed.',
				'AUTH_BANNED'			=> 'Your account has been banned.',
				'AUTH_SUSPENDED'		=> 'Your account is currently suspended.',
			];

			// Attach error messages to the current error
			$err = ErrorContainer::getInstance();
			$err->add($result);
			$err->set_messages($errors);

			if ( is_ajax() )
				ajax_return('error', ['error' => $err->return()]);

			$params = [
				'error'		=> $err->return()[0],
				'username'	=> $login['username'],
				'remember'	=> $login['remember']
			];

			$this->view->render('Auth/login', $params);

		}

	}

	/**
	 * Fires when a user requests to log out.
	 */
	public function logout() {
		Auth::logout();
	}

}
