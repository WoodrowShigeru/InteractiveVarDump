<?php

// test #2


// ----------------
$myo = new stdClass();

$myo->feet = 2;
$myo->name = 'Yesterday';
$myo->hands = array(
	'left' => 'Hannah',
	'right' => 'Bertha',
);

$myo->favorite_website = new stdClass();
$myo->favorite_website->name = 'Favslist';
$myo->favorite_website->url = 'http://www.favslist.com/';
$myo->favorite_website->users = array(
	13 => new stdClass(),
	115 => new stdClass(),
);
$myo->favorite_website->users[13]->name = 'WoodrowShigeru';
$myo->favorite_website->users[13]->ID = 13;
$myo->favorite_website->users[13]->avatar = array(
	'ID' => 7809,
	'url-thumbnail' => 'http://image-7809.small.jpg',
	'url-full' => 'http://image-7809.large.jpg',
);
$myo->favorite_website->users[115]->name = 'Husky Wing';
$myo->favorite_website->users[115]->ID = 115;
$myo->favorite_website->users[115]->avatar = array(
	'ID' => 19282,
	'url-thumbnail' => 'http://image-19282.small.jpg',
	'url-full' => 'http://image-19282.large.jpg',
);

$myo->favorite_website->pages = array(
	5738 => new stdClass(),
);
$myo->favorite_website->pages[5738]->name = 'Final Fantasy X';
$myo->favorite_website->pages[5738]->ID = 5738;
$myo->favorite_website->pages[5738]->stats = array(
	'played' => 39,
	'owned' => 31,
	'finished' => 30,
	'wishlist' => 3,
	'great' => TRUE,
);
$myo->favorite_website->pages[5738]->score = 8.2;
$myo->favorite_website->pages[5738]->elephants = array();
$myo->favorite_website->pages[5738]->discussion = array(
	'1249598182' => new stdClass(),
	//'5387782357' => new stdClass(),
);
$myo->favorite_website->pages[5738]->discussion['1249598182']
	->ID = '1249598182';
$myo->favorite_website->pages[5738]->discussion['1249598182']
	->text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra mi a velit consectetur, quis efficitur mauris pellentesque. Suspendisse pretium quam sit amet cursus laoreet. Quisque sagittis sagittis dolor, vel maximus dolor commodo eu. Mauris semper purus ut pharetra dictum. Nulla porta fermentum sodales. Nam vel gravida erat. Donec semper feugiat sem in gravida. Aenean rutrum mi at diam sagittis, eu maximus eros euismod. Suspendisse at tortor ornare, fermentum nibh ac, mollis arcu. Aenean et mauris pellentesque, gravida odio ut, molestie tellus. Cras finibus mollis nibh et ullamcorper. Duis et arcu nec felis ultricies eleifend. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus fermentum, nisi ac volutpat vestibulum, mi ipsum ultricies ligula, nec efficitur urna est nec magna. Vivamus sagittis justo id diam aliquet laoreet.';
$myo->favorite_website->pages[5738]->discussion['1249598182']
	->user_id = 115;
$myo->favorite_website->pages[5738]->discussion['1249598182']
	->likes = 4;
$myo->favorite_website->pages[5738]->discussion['1249598182']
	->replies = array(
		'158978951' => new stdClass()
	);
$myo->favorite_website->pages[5738]->discussion['1249598182']->replies['158978951']->ID = '158978951';
$myo->favorite_website->pages[5738]->discussion['1249598182']->replies['158978951']->user_id = 91;
$myo->favorite_website->pages[5738]->discussion['1249598182']->replies['158978951']->user_name = 'Nodley';
$myo->favorite_website->pages[5738]->discussion['1249598182']->replies['158978951']->text = 'Yo!';
$myo->favorite_website->pages[5738]->discussion['1249598182']->replies['158978951']->likes = 21;

$myo->favorite_website->pages[5738]->page_created_by = $myo->favorite_website->users[13];

$myo->favorite_website->pages[5738]->series = array(
	19294 => new stdClass(),
);
$myo->favorite_website->pages[5738]->series[19294]->ID = 19294;
$myo->favorite_website->pages[5738]->series[19294]->name = 'Final Fantasy';
$myo->favorite_website->pages[5738]->series[19294]->elements = array(
	114098 => new stdClass(),
);
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->ID = 114098;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->name = 'Final Fantasy VII';
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters = array(
	142098 => new stdClass(),
);
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->ID = 142098;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->name = 'Tifa Lockhart';
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies = array(
	1294819124 => new stdClass(),
);
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->ID = 1294819124;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->name = 'Final Fantasy VII: Advent Children';
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors = array(
	124098 => new stdClass(),
);
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->ID = 124098;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->name = 'Tetsuya Nomura';
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place = new stdClass();
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place->ID = 918257;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place->name = 'Tokio';
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place->country = new stdClass();
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place->country->ID = 1298415289;
$myo->favorite_website->pages[5738]->series[19294]->elements[114098]->characters[142098]->movies[1294819124]->directors[124098]->birth_place->country->name = 'Japan';





ivd($myo, 'test #2: most often occurring use-case', array(
	//'max_depth' => 11,
	'start_collapsed'	=> TRUE,
	'color'	=> $color_mode,
));


// test: return to variable instead of print.
$ivd = ivd($myo, NULL, array(
	'return' => true,
	'color' => $color_mode,
));

echo sprintf(
	'<div style="%s">',
	($is_responsive   ? 'max-width: 300px;'   : '')
);
ivd($ivd, NULL, array(
	'indent' => 4,
	'color' => $color_mode,
));
echo '</div>';

qvd($myo, 'simple dump version');

