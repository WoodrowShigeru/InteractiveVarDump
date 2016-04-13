<?php

require_once "InteractiveVarDump/InteractiveVarDump_Node.class.php";

class InteractiveVarDump_Tree {

	private $root = NULL;



	//==== CONSTRUCTOR ====//

	public function InteractiveVarDump_Tree( $subject ) {

		$this->root = new InteractiveVarDump_Node($subject);
	}




	//==== METHODS ====//

	public function display() {

		return '<div class="ivd_tree">'.$this->root->display().'</div>';
	}




	//==== GETTERS/SETTERS ====//

	// —/—


}  // end of ( CLASS "InteractiveVarDump_Tree" )
