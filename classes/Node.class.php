<?php

namespace InteractiveVarDump;

class Node {

	private $type = NULL;
	private $classname = NULL;
	private $obj = NULL;
	private $is_flat = true;	// = scalar or NULL
	private $current_depth = 0;



	//=============== CONSTRUCTOR ===============//

	public function __construct( $subject, $max_depth = 10, $current_depth = 0 ) {

		if (isset($subject)) {
			$this->type = gettype($subject);

			if (is_object($subject)) {
				$this->classname = get_class($subject);
			}
		}

		$this->obj = $subject;

		$this->is_flat = is_scalar($subject)  ||  !isset($subject);

		$this->current_depth = $current_depth;
	}




	//=============== METHODS ===============//

	public function display() {

		$out = '';

		if (!$this->is_flat) {
			 // *** Array ***
			if (is_array($this->obj)) {

				$length = count($this->obj);
				if (!$length) {
					$out .=
						'<span class="ivd--scalar ivd--value-wrapper ivd--inline">'
					.		'array(0) '
					.		'<span class="ivd--noncolor">{}</span>'
					.	'</span>'
					;
				}
				else {
					$out .=
						'<span class="ivd--controller">'
					.		'array('.$length.')'
					.	'</span> '
					.	'{'
					.		'<span class="ivd--content">'
					;

					foreach($this->obj as $key => $element) {
						$tmp = new Node($element);
						$out .=
							'<span class="ivd--item">'
						.		'<span class="ivd--key">'
						.			(is_integer($key)  ? $key  : '"'.$key.'"')
						.		'</span>'
						.		'<span class="ivd--arrow">=></span>'
						.		$tmp->display()
						.	'</span><!-- /.ivd--item -->'
						;
					}

					$out .=
							'</span><!-- /.ivd--content -->'
					.	'}'
					;
				}  // end of ( non-empty array )


			 // *** Object ***
			} elseif (is_object($this->obj)) {

				$reflection = new \ReflectionObject($this->obj);
				$reflective_properties = array();
				$tmp = $reflection->getProperties();   // array of ReflectionProperty objects.

				 // kick the static stuff, I don't need it.
				foreach ($tmp as $property) {
					if (!$property->isStatic()) {
						array_push($reflective_properties, $property);
					}
				}
				unset($tmp);

				$length = count($reflective_properties);
				if (!$length) {
					$out .=
						'<span class="ivd--scalar ivd--value-wrapper ivd--inline">'
					.		'object('.$this->classname.') (0) '
					.		'<span class="ivd--noncolor">{}</span>'
					.	'</span>'
					;
				}
				else {
					$out .=
						'<span class="ivd--controller">'
					.		'object('.$this->classname.') ('.$length.')'
					.	'</span> '
					.	'{'
					.		'<span class="ivd--content">'
					;

					foreach($reflective_properties as $property) {
						 // make protected and private properties readable.
						$property->setAccessible(true);

						 // prepare key string.
						$key_string = '';
						$ppp = '';
						if ($property->isPrivate()) {
							$key_string .= ':"'.$property->class.'":private';
							$ppp = ' ivd--private';
						}
						elseif ($property->isProtected()) {
							$key_string .= ':protected';
							$ppp = ' ivd--protected';
						}
						else {
							$ppp = ' ivd--public';
						}
						if (!empty($key_string)) {
							$key_string = '<span class="ivd--noncolor">'.$key_string.'</span>';
						}
						$key_string = '"'.$property->name.'"'.$key_string;


						 // apply "ivd value" structure and display the value recursively (could be an object).
						$tmp = $property->getValue($this->obj);
						$tmp = new Node($tmp);
						$out .=
							'<span class="ivd--item '.$ppp.'">'
						.		'<span class="ivd--key">'
						.			$key_string
						.		'</span>'
						.		'<span class="ivd--arrow">=></span>'
						.		$tmp->display()
						.	'</span><!-- /.ivd--item -->'
						;
					}  // end of ( each property )

					$out .=
							'</span><!-- /.ivd--content -->'
					.	'}'
					;
				}  // end of ( object has at least one property )


			 // *** not Array, not Object, not Scalar – fallback for unexpectations ***
			} else {
				$out .= 'unexpected type: '. $this->type;

				$tmp = new Node($this->obj);
				$out .= $tmp->display();
			}


		 // *** Scalar – obj is as flat as a flunder ***
		} else {

			$styled_value = '<span class="ivd--value">'.$this->obj.'</span>';

			switch ($this->type) {

				case "string":
					$out .= 'string('.strlen($this->obj).') "'.$styled_value.'"';
				break;

				case "integer":
					$out .= 'int('.$styled_value.')';
				break;

				case "double":
					$out .= 'float('.$styled_value.')';
				break;

				case "boolean":
					$out .= 'bool(<span class="ivd--value">'.($this->obj  ? 'true'  : 'false').'</span>)';
				break;

				case NULL:
					$out .= '<span class="ivd--value">NULL</span>';
				break;

				default:
					$out .= 'Unsupported variable type: '.$this->type;
				break;

			}  // end of ( switch-case type )

			$out = '<span class="ivd--scalar ivd--value-wrapper ivd--inline">'.$out.'</span>';

		}  // end of ( is flat )

		return $out;
	}




	//=============== GETTERS/SETTERS ===============//

	public function get_object() {
		return $this->obj;
	}

	public function get_type() {
		return $this->type;
	}

	public function get_classname() {
		return $this->classname;
	}

	public function are_you_flat() {
		return $this->is_flat;
	}

}  // end of ( CLASS "Node" )
