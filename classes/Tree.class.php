<?php

namespace InteractiveVarDump;

require_once "Node.class.php";


class Tree {
	const COLOR_MODE_ALL = 'all';
	const COLOR_MODE_LINK = 'link';
	const COLOR_MODE_NONE = 'none';

	private $root = NULL;
	private $color_mode = self::COLOR_MODE_ALL;
	private $max_depth = 10;



	//=============== CONSTRUCTOR ===============//

	public function __construct( $subject, $config ) {

		$this->max_depth = $config['max_depth'];
		$this->color_mode = $config['color'];

		$this->root = new Node($subject, $this->max_depth, 0);
	}




	//=============== METHODS ===============//

	public function display() {

		$classes = array('ivd--tree');

		switch ($this->color_mode) {
			case self::COLOR_MODE_NONE:
				array_push($classes, 'ivd--color-mode-none');
				break;

			case self::COLOR_MODE_LINK:
				array_push($classes, 'ivd--color-mode-link');
				break;

			case self::COLOR_MODE_ALL:
			default:
				array_push($classes, 'ivd--color-mode-all');
				break;
		}

		return sprintf(
			'<div class="%s">%s</div><!-- /.ivd--tree -->',
			implode(' ', $classes),
			$this->root->display()
		);
	}




	//=============== GETTERS/SETTERS ===============//

	public function get() {

		return $this->root;
	}

}  // end of ( CLASS "Tree" )
