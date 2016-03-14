<?php

namespace HostList;

class Homepage extends Controller {

	public function display() {
		$this->view->render('homepage/homepage');
	}

}
