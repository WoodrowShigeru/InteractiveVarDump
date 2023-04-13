<?php
/**
 * InteractiveVarDump
 *
 * @copyright "Copyright" © 2016-2023
 * @author Rafael Cieslik <woodrow.shigeru@gmx.net>
 * @version 1.3.2-dev
 */

// autoloader magic.
spl_autoload_register(function($class) {

	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = implode(DIRECTORY_SEPARATOR, array(
		dirname(__FILE__),
		'classes',
		$class .'.class.php',
	));

	if (file_exists($file)) {
		require_once $file;
	}
});


if (function_exists('ivd')) {
	trigger_error(
		'"ivd" function already exists. Could not initialize InteractiveVarDump.',
		E_USER_WARNING
	);

} else {
	/**
	 * Shorthand wrapper for the main method.
	 *
	 * See {@see \InteractiveVarDump\InteractiveVarDump::dump()
	 * InteractiveVarDump::dump()} for more info.
	 *
	 * @param mixed $subject
	 * @param string|null $pretext
	 * @param array $config
	 *
	 * @return Tree|null
	 */
	function ivd( ...$args ) {

		return IVD::dump(...$args);
	}
}  // end of ( ivd didn't exist yet )




if (function_exists('qvd')) {
	trigger_error(
		'"qvd" function already exists. Could not add shortcut.',
		E_USER_WARNING
	);

} else {
	/**
	 * Shorthand wrapper for the simpler, secondary method.
	 *
	 * @param mixed $subject
	 *   The variable to dump.
	 *
	 * @param string $pretext
	 *   Optional message to prefix the dump with.
	 *
	 * @return null
	 */
	function qvd( ...$args ) {

		IVD::simple(...$args);
	}
}

