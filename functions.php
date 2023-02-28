<?php
/**
 * InteractiveVarDump
 *
 * @copyright "Copyright" © 2016
 * @author Rafael Cieslik <woodrow.shigeru@gmx.net>
 * @version 1.3.0
 */

use InteractiveVarDump\InteractiveVarDump as IVD;
use InteractiveVarDump\Tree;

require_once dirname(__FILE__) .'/vendor/autoload.php';


$ivd_initialized = FALSE;


if (function_exists('ivd')) {
	trigger_error('"ivd" function already exists. Could not initialize InteractiveVarDump.', E_USER_WARNING);

} else {
	/**
	 * Dumps a given variable in an interactive tree; for debugging convenience.
	 *
	 * @param mixed $subject
	 *   The to-dump variable.
	 *
	 * @param string|null $pretext
	 *   Optional message to prefix the dump with.
	 *
	 * @param array $config
	 *   Optional configuration array for further control. See docs for further info.
	 *
	 * @return Tree|null
	 *   Returns or prints, depending on getter parameter.
	 */
	function ivd( ...$args ) {

		return IVD::dump(...$args);

		// TODO  1.3.0: more testing.
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
	 *
	 * @return null
	 */
	function qvd( $subject, $pretext = FALSE ) {

		if ($pretext) {
			echo $pretext .':<br />';
		}

		echo '<pre style="white-space: pre-wrap;">'; var_dump($subject); echo '</pre><br />';
	}
}

