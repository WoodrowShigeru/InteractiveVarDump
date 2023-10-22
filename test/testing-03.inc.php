<?php

// test #3


// TODO  can't really test this right now. This does not set up the faulty state that this test intends to create in the first place. Need to increment treehouse-vagrant PHP from 7.2 to 7.4 first.
//
// Uninitiated properties don't seem to exist on 7.2 …?


//	echo PHP_VERSION ." <br />";
//	$is_8_1 = version_compare(PHP_VERSION, '8.1') >= 0; // … or higher.
//	$is_7_2 = version_compare(PHP_VERSION, '7.2') >= 0;
//	$is_7_4 = version_compare(PHP_VERSION, '7.4') >= 0;
//	$is_5 = version_compare(PHP_VERSION, '5') >= 0;
//
//	ivd(compact('is_5', 'is_7_2', 'is_7_4', 'is_8_1'));exit;


// ----------------
class Test03 {

	private $a_string = '';
	private $b_int = 4;
	private $c_int;
	private $d_string;

	// don't do this. This requires PHP 8 – I want to stay compatible with 7.4.
//	private string $a_string = '';
//	private int $b_int = 4;
//	private int $c_int;
//	private string $d_string;
}

// ----------------
$myo = new Test03();






ivd($myo, 'test #3: symfony can var_dump a class instance if the property hasn\'t been instantiated … now ivd can do so too.');

