<?php

namespace InteractiveVarDump;


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
	private static bool $is_initialized = FALSE;



	//=============== CONSTRUCTOR ===============//
	//=============== METHODS ===============//

	/**
	 * Dump a given variable in an interactive tree; for debugging convenience.
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
	public static function dump( $subject, string $pretext = NULL, array $config = NULL ) {

		if (!self::$is_initialized) {
			self::$is_initialized = TRUE;

			// apply necessary includes. Doesn't matter where in the DOM you are
			// (in DEV environments).

			$dir = dirname(__FILE__) .'/../';

			echo '<style type="text/css">';
			include $dir .'css/style.min.css';
			echo '</style>';

			echo '<script type="text/javascript">';
				include $dir .'js/jquery.js';
			echo '</script>';

			echo '<script type="text/javascript">';
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




	//=============== GETTERS/SETTERS ===============//
}
