<?php

namespace HostList;

use MysqliDb;

class Register extends Controller {

	/**
	 * Displays the registration form view.
	 */
	public function display() {

		// Redirect already logged in users
		Auth::logged_in_redirect('/dashboard');

		$this->view->render('Auth/register');

	}

	/**
	 * Fires when the registration form is submitted to the server.
	 */
	public function submit() {

		// If user is already logged in and tries an AJAX request, send a redirect status
		if ( is_ajax() && Auth::logged_in() )
			ajax_return('redirect', ['target' => '/dashboard']);

		// Redirect already logged in users
		Auth::logged_in_redirect('/dashboard');

		$input_args = [
			'username'	=> FILTER_DEFAULT,
			'email'		=> FILTER_DEFAULT, // Email is validated in Auth::check_registration()
			'password'	=> FILTER_DEFAULT,
			'agree'		=> FILTER_VALIDATE_BOOLEAN
		];

		$inputs = filter_input_array(INPUT_POST, $input_args);

		// Process the inputs and check if registration inputs are valid
		$result = Auth::check_registration($inputs);

		// Success!
		if ( $result === true ) {

			// Register a new user with the given credentials
			$register = Auth::register($inputs);

			// Registration completed, user added in the database successfully
			if ( !$register instanceof Error ) {

				// Send an activation email to the new user
				$activation = Auth::force_activation_email( $register['username'], $register['email'], $register['token'] );

				/**
				 * @todo Add verification for whether or not the activation email bounced/delivered.
				 */

				if ( is_ajax() )
					ajax_return('success');

				redirect('/welcome');

			}

			// Something went wrong when adding the user to the database, display error
			else {

				$error = 'Oops! Something went wrong while creating your account. Please try again in a few minutes.';

				if ( is_ajax() )
					ajax_return('error', ['error' => $error]);

				$params = [
					'error'		=> $error,
					'username'	=> $inputs['username'],
					'email'		=> $inputs['email'],
					'agree'		=> $inputs['agree'],
				];

				$this->view->render('Auth/register', $params);

			}

		}

		// Something went wrong
		else {

			// Error message language
			$errors = [
				'USERNAME_MISSING'		=> 'Please enter a username.',
				'USERNAME_INVALID'		=> 'Your username must start with a letter and may contain letters, numbers and underscores only.',
				'USERNAME_LENGTH'		=> 'Your username must be 5-20 characters long.',
				'USERNAME_TAKEN'		=> 'That username is already in use. Please choose another username.',
				'EMAIL_MISSING'			=> 'Please enter an email address.',
				'EMAIL_INVALID'			=> 'Please enter a valid email address.',
				'EMAIL_LENGTH'			=> 'Your email cannot be over 100 characters long.',
				'EMAIL_TAKEN'			=> 'That email is already in use. Please use another email.',
				'PASSWORD_MISSING'		=> 'Please enter a password.',
				'PASSWORD_HAS_USERNAME'	=> 'Your password can\'t contain your username.',
				'PASSWORD_SHORT'		=> 'Your password must be at least 8 characters long.',
				'PASSWORD_LONG'			=> 'Your password cannot be over 100 characters long.',
				'TERMS_MISSING'			=> 'Please accept the terms and conditions.',
				'REGISTER_FAILED'		=> 'Oops! Something went wrong while creating your account. Please try again in a few minutes.',
			];

			// Attach error messages to error codes for display
			$result->set_messages($errors);

			if ( is_ajax() )
				ajax_return('error', ['error' => $result->return()]);

			$params = [
				'error'		=> $result->return(),
				'username'	=> $inputs['username'],
				'email'		=> $inputs['email'],
				'agree'		=> $inputs['agree'],
			];

			$this->view->render('Auth/register', $params);

		}

	}

	/**
	 * Fires when the welcome page at /welcome is requested.
	 */
	public function welcome() {

		// Redirect already logged in users
		Auth::logged_in_redirect('/dashboard');

		$params = [
			'username'	=> substr( filter_input(INPUT_GET, 'u'), 0, 20)
		];

		$this->view->render('Auth/welcome', $params);

	}

}
