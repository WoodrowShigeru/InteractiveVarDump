<?php

namespace InteractiveVarDump;

require_once "Node.class.php";


class Tree {

	private $root = NULL;



	//=============== CONSTRUCTOR ===============//

	public function __construct( $subject ) {

		$this->root = new Node($subject);
	}




	//=============== METHODS ===============//

	public function display() {

		return '<div class="ivd_tree">'.$this->root->display().'</div><!-- /.ivd_tree -->';
	}




	//=============== GETTERS/SETTERS ===============//

	public function get() {

		return $this->root;
	}

}  // end of ( CLASS "Tree" )
