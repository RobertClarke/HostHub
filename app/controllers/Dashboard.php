<?php

namespace HostList;

class Dashboard extends Controller {

	public function display() {

		if ( Auth::logged_in() )
			echo 'Logged in ~ <a href="/logout">Logout</a>';
		else
			echo 'Not logged in ~ <a href="/login">Login</a>';

	}

}
