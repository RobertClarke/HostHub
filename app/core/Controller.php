<?php

namespace HostList;

class Controller {

	protected $view;

	public final function __construct() {
		$this->view = new View;
	}

}
