<?php
/**
 * InteractiveVarDump
 *
 * @copyright  "Copyright" © Apr - Jul 2o16, by Rafael Cieslik ( woodrow.shigeru@gmx.net )
 * @version    1.1.3
 */

require_once "InteractiveVarDump_Tree.class.php";


$ivd_initialized = FALSE;


function ivd( $subject, $pretext = FALSE, $getter = FALSE ) {

	global $ivd_initialized;

	if (!$ivd_initialized) {
		 // apply necessary includes. Doesn't matter where in the DOM you are
		 // (in DEV environments).

		echo '<style type="text/css">';
			include "ivd.css";
		echo '</style>';

		echo '<script type="text/javascript">';
			include "jquery.js";
		echo '</script>';

		echo '<script type="text/javascript">';
			include "ivd.js";
		echo '</script>';

		$ivd_initialized = TRUE;
	}

	if ($pretext) {
		echo $pretext .':<br />';
	}

	$tree = new InteractiveVarDump_Tree($subject);
	if ($getter) {
		return $tree->get();

	} else {
		echo $tree->display();
	}
}


