<?php
// http://localhost/ivd/testing.php
//
// Download latest repository release
// and unpack it here, then manually
// require its autoload.php (see below).
// ------------------------------------

// PLAN  (NEXTs):
//
// - → Vagrant.  Get rid of LAMP.
// - use synced folders instead of symbolic links from /var/www/… to ~/work/.

// TODO  consider setting up a separate vagrant machine-- Nay, multiple ones, solely dedicated to testing IVD in different PHP versions.


error_reporting(E_ALL);
ini_set('display_errors', 1);

// some TODOs remain.
// - drag & drop.


require_once "./latest/autoload.php";


// "responsive".
$is_responsive = isset($_REQUEST['responsive']);

$valid_color_modes = array('all', 'link', 'box', 'none');
$color_mode = $_REQUEST['color'] ?? '';
if (!in_array($color_mode, $valid_color_modes)) {
	$color_mode = 'all';
}

?><!DOCTYPE html>
<html>
<head>
	<meta name="charset" content="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>IVD Testing</title>

	<style type="text/css">
		html {
			font-size: 14px;
		}

		body {
			min-width: 320px;
			margin: 0;
			padding: 1rem;
		}

		#page {
			/* overflow: hidden; */
		}
	</style>
</head>
<body>
	<div id="page">
		<p>Supported querystring controls in this testing environment:</p>

		<ul>
			<li>responsive: enable "responsive" mode.</li>
			<li>color: either of [ `all`, `link`, `box`, `none` ] values.</li>
		</ul>

		<hr />

	<?php
// ----------------
// testing the class method way to call it.
IVD::dump('easy text', "test #1", array(
	'color' => $color_mode,
));



include './testing-02.inc.php';


// ----------------
$ray = array(
	'CheeseCake'		=> array(
		'tastes'	=> 'more delicious',
	),
	'StrawberryCake'	=> array(
		'tastes'	=> 'delicious',
	),
	'Favorites'	=> array(
		'game'	=> "Kirby's Dream Course",
	),
);
$ray = json_encode($ray, 0, 8);
$specialed = htmlspecialchars($ray);
$filvared = filter_var($ray, FILTER_SANITIZE_STRING);
ivd(array(
	'input' => $ray,
	'specialed' => $specialed,
	'filvared' => $filvared,
), "entities test", array(
	'color' => $color_mode,
));

echo "<p><i>using ivd to test ENT_QUOTES leads to misleading and confusing results.</i><br />
note how the 202 decoded becomes 130 whereas it should be 126.</p>";
qvd(array(
	'input' => $ray,
	'specialed' => $specialed,
	'specialed-decoded-wo-entquotes' => html_entity_decode($specialed),
	'specialed-decoded-w-entquotes' => html_entity_decode($specialed, ENT_QUOTES),
	'filvared' => $filvared,
	'filvared-decoded-wo-entquotes' => html_entity_decode($filvared),
	'filvared-decoded-w-entquotes' => html_entity_decode($filvared, ENT_QUOTES),
));

$input = "Kirby's Dream Course";
$filvared = filter_var($input, FILTER_SANITIZE_STRING);
ivd(array(
	'input' => $input,
	'filvared' => $filvared,
), "directly", array(
	'color' => $color_mode,
	'z_index' => 12,
));






// ----------------


ivd(NULL, "null must still work");


// ----------------

$myo = array(
	'filligreen',
	'0' => 'but this is something else.',
);

ivd($myo, "Numeric vs. quoted array keys", array(
	'color' => $color_mode,
));
//
// Note: it only has one item.


// ----------------

include './testing-03.inc.php';


?>
	</div>
</body>
</html>
