<?php
/**
 * InteractiveVarDump
 *
 * @copyright  "Copyright" © Apr - Jul 2o16, by Rafael Cieslik ( woodrow.shigeru@gmx.net )
 * @version    1.1.3
 */

require_once "classes/Tree.class.php";


$ivd_initialized = FALSE;


if (TRUE === function_exists('ivd')) {
	trigger_error('"ivd" function already exists. Could not initialize InteractiveVarDump.', E_USER_WARNING);

} else {
	function ivd( $subject, $pretext = FALSE, $getter = FALSE ) {

		global $ivd_initialized;

		if (!$ivd_initialized) {
			 // apply necessary includes. Doesn't matter where in the DOM you are
			 // (in DEV environments).

			echo '<style type="text/css">';
				include "css/ivd.css";
			echo '</style>';

			echo '<script type="text/javascript">';
				include "js/jquery.js";
			echo '</script>';

			echo '<script type="text/javascript">';
				include "js/ivd.js";
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


if (TRUE === function_exists('qvd')) {
	trigger_error('"qvd" function already exists. Could not add shortcut.', E_USER_WARNING);

} else {
	function qvd( $subject, $pretext = FALSE ) {

		if ($pretext) {
			echo $pretext .':<br />';
		}

		echo '<pre>'; var_dump($subject); echo '</pre><br />';
	}
}