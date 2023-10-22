<?php

// namespace InteractiveVarDump;
//
// decision: we don't use namespaces, for spl_autoload_register() to work.


/**
 * Wrapper class for actual calls.
 *
 * @since version 1.3.0
 */
class InteractiveVarDump {

	/**
	 * @var boolean $is_initialized
	 *   Whether the library has been initalized yet.
	 */
	private static $is_initialized = FALSE;

	// decision: not using type casting on class properties in order to avoid
	//   dependency on PHP 8.



	//=============== CONSTRUCTOR ===============//
	//=============== METHODS ===============//

	/**
	 * Dump a given variable in an interactive tree; for debugging convenience.
	 *
	 * @param mixed $subject
	 *   The variable to dump.
	 *
	 * @param string|null $pretext
	 *   Optional message to preface the dump with. The pretext is never part
	 *   of the returned value of the `return` configuration.
	 *
	 * @param array $config
	 *   Optional configuration for further control. See README for further
	 *   info.
	 *
	 * @return Tree|null
	 *   Returns or prints, depending on `return` configuration.
	 */
	public static function dump( $subject, string $pretext = NULL, array $config = NULL ) {

		if (!self::$is_initialized) {
			self::$is_initialized = TRUE;

			// apply necessary includes. Doesn't matter where in the DOM you are
			// (in DEV environments).

			$dir = dirname(__FILE__) .'/../';

			echo '<style type="text/css">';
			include $dir .'css/style.min.css';
			echo '</style>';

			echo '<script>';
				include $dir .'js/jquery.js';
			echo '</script>';

			echo '<script>';
				include $dir .'js/debounce.min.js';
			echo '</script>';

			echo '<script>';
				include $dir .'js/script.js';
			echo '</script>';
		}

		if (isset($pretext)) {
			echo $pretext .':<br />';
		}

		$tree = new Tree($subject, $config);
		if (($config['return'] ?? FALSE) === TRUE) {
			return $tree->get();

		} else {
			echo $tree->render();
		}
	}


	/**
	 * Simple and quick shortcut for the native var_dump() method, but wrapped
	 * in ‹pre› tags.
	 *
	 * @param mixed $subject
	 *   The variable to dump.
	 *
	 * @param string $pretext
	 *   Optional message to prefix the dump with.
	 *
	 * @return null
	 */
	public static function simple( $subject, $pretext = FALSE ) {

		if ($pretext) {
			echo $pretext .':<br />';
		}

		echo '<pre style="white-space: pre-wrap;">'; var_dump($subject); echo '</pre><br />';
	}




	//=============== GETTERS/SETTERS ===============//
}

