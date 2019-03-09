<?php
/**
 * InteractiveVarDump
 *
 * @copyright  "Copyright" © Apr - Jul 2o16, Mar 2o19, by Rafael Cieslik ( woodrow.shigeru@gmx.net )
 * @version    1.2.0-dev
 */

require_once "classes/Tree.class.php";


$ivd_initialized = FALSE;


if (function_exists('ivd')) {
	trigger_error('"ivd" function already exists. Could not initialize InteractiveVarDump.', E_USER_WARNING);

} else {
	/**
	* Dumps a given variable in an interactive tree; for debugging convenience.
	*
	* @param $subject mixed  The to-dump variable.
	* @param $pretext string  Optional message to prefix the dump with.
	* @param $getter boolean  If set to true, will return the tree as an object rather than print it.
	* @return $object|NULL  Depending on getter parameter.
	*/
	function ivd( $subject, $pretext = FALSE, $getter = FALSE ) {

		global $ivd_initialized;

		if (!$ivd_initialized) {
			 // apply necessary includes. Doesn't matter where in the DOM you are
			 // (in DEV environments).

			echo '<style type="text/css">';
				include "css/style.css";
			echo '</style>';

			echo '<script type="text/javascript">';
				include "js/jquery.js";
			echo '</script>';

			echo '<script type="text/javascript">';
				include "js/script.js";
			echo '</script>';

			$ivd_initialized = TRUE;
		}

		if ($pretext) {
			echo $pretext .':<br />';
		}

		$tree = new InteractiveVarDump\Tree($subject);
		if ($getter) {
			return $tree->get();

		} else {
			echo $tree->display();
		}
	}
}  // end of ( ivd didn't exist yet )


if (function_exists('qvd')) {
	trigger_error('"qvd" function already exists. Could not add shortcut.', E_USER_WARNING);

} else {
	/**
	* Simple and quick shortcut for the native var_dump method, but wrapped in ‹pre› tags.
	*
	* @param $subject mixed  The to-dump variable.
	* @param $pretext string  Optional message to prefix the dump with.
	* @return NULL
	*/
	function qvd( $subject, $pretext = FALSE ) {

		if ($pretext) {
			echo $pretext .':<br />';
		}

		echo '<pre style="white-space: pre-wrap;">'; var_dump($subject); echo '</pre><br />';
	}
}