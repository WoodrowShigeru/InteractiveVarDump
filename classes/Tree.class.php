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
	private $indent = 0;
	private $plz_start_collapsed = FALSE;



	//=============== CONSTRUCTOR ===============//

	public function __construct( $subject, $config ) {

		$this->max_depth = $config['max_depth'];
		$this->plz_start_collapsed = $config['start_collapsed'];

		// indent.
		if (
			($config['indent'] >= 1)
		&&	($config['indent'] <= 20)
		) {
			$this->indent = $config['indent'];
		}

		// colors.
		$valid = array(
			self::COLOR_MODE_ALL,
			self::COLOR_MODE_LINK,
			self::COLOR_MODE_NONE,
		);
		if (in_array($config['color'], $valid)) {
			$this->color_mode = $config['color'];
		}

		$this->root = new Node($subject, $this->max_depth, 0);
	}




	//=============== METHODS ===============//

	public function display() {

		$classes = array('ivd__tree');

		if ($this->plz_start_collapsed) {
			array_push($classes, 'ivd--start-collapsed');
		}

		return sprintf(
			'<div class="%s"
				data-ivd-color-mode="%s"
				data-ivd-indent-level="%d"
			>%s</div><!-- /.ivd__tree -->',

			implode('  ', $classes),
			$this->color_mode,
			$this->indent,
			$this->root->display()
		);
	}




	//=============== GETTERS/SETTERS ===============//

	public function get() {

		return $this->root;
	}

}  // end of ( CLASS "Tree" )
