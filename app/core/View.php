<?php

namespace HostList;

class View {

	/**
	 * Renders a View given a view name and parameters.
	 *
	 * @param  string   $view    View path & name, example: Login/form
	 * @param  array    $params  Array of parameters to pass to view
	 * @param  boolean  $params  Whether or not to use the Twig template engine
	 * @return View              Rendered HTML of requested view
	 */
	public function render( $view, $params=[], $twig=true ) {

		if ( $twig ) {

			global $twig;

			// Load and render template file
			$template = $twig->loadTemplate( $view . '.tpl' );
			echo $template->render($params);

		} else if ( file_exists('../app/views/'. $view .'.php') ) {
			require_once('../app/views/'. $view .'.php');
		}

	}

}
