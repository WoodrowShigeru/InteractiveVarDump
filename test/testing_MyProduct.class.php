<?php


class MyProduct {
	private $ID = NULL;
	private $title = NULL;
	private $price = NULL;
	public  $is_promo = FALSE;

	function __construct( $data ) {
		$this->ID = $data['ID'];
		$this->title = $data['title'];
		$this->price = $data['price'];
		
		if (isset($data['is_promo']) && is_bool($data['is_promo'])) {
			$this->is_promo = $data['is_promo'];
		}
	}
}

