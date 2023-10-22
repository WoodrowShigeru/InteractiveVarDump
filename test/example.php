<?php

// This is the file with which I made screenshots for the ReadMe.

require_once "./1.3.2/autoload.php";
require_once "./testing_MyProduct.class.php";


$user = new stdClass();

$user->ID = 2;
$user->name = 'Jill Doe';
$user->friends = array(
	'Summer',
	'Winter',
	'Spring',
	'Falls',
);
$user->address = array(
	'Street' => 'Main Street',
	'Street no.' => '42a',
	'Zip code' => 6788,
	'City' => 'Honolulu',
);
$user->shopping_cart = array(
	new MyProduct(array(
		'ID' => 9288,
		'title' => 'Green Socks',
		'price' => '7.99',
	)),
	new MyProduct(array(
		'ID' => 412892,
		'title' => 'Winter Pants',
		'price' => '34.99',
	)),
	new MyProduct(array(
		'ID' => 2882,
		'title' => 'Mysterious Scarf',
		'price' => '109.99',
		'is_promo' => TRUE,
	)),
);


ivd($user, '$user');
