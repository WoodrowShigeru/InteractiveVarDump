<?php

namespace InteractiveVarDump;

use Exception;


/**
 * Node representing a scalar value, array, object.
 */
class Node {

	/**
	 * @var string $type
	 *   The type of the current node value.
	 */
	private $type = '';

	/**
	 * @var string $classname
	 *   The classname for objects.
	 */
	private $classname = '';

	/**
	 * @var mixed $obj
	 *   The raw value of the current Node.
	 */
	private $obj = NULL;

	/**
	 * @var boolean $is_flat
	 *   Whether the current Node value is scalar or not.
	 */
	private $is_flat = TRUE;	// = scalar or NULL

	/**
	 * @var integer $max_depth
	 *   The maximum depth carried over from the parent Tree object.
	 */
	private $max_depth = 10;

	/**
	 * @var integer $current_depth
	 *   The tree depth of the current Node.
	 */
	private $current_depth = 0;



	//=============== CONSTRUCTOR ===============//

	/**
	 * Create an instance of this class.
	 *
	 * @param mixed $subject
	 *   The variable or sub-variable to process.
	 *
	 * @param integer $max_depth
	 *   The maximum recursion depth.
	 *
	 * @param integer $current_depth
	 *   The current recursion depth.
	 *
	 * @return Node
	 */
	public function __construct( $subject, int $max_depth = 10, int $current_depth = 0 ) {

		$this->type = isset($subject)   ? gettype($subject)   : 'null';

		if (is_object($subject)) {
			$this->classname = get_class($subject);
		}

		if ($max_depth < 1) {
			$max_depth = 10;
		}

		$this->obj = $subject;

		$this->is_flat = is_scalar($subject) || !isset($subject);

		$this->max_depth = $max_depth;
		$this->current_depth = $current_depth;
	}




	//=============== METHODS ===============//

	/**
	 * Render the node.
	 *
	 * @since version 1.0.1: as display()
	 * @since version 1.3.0: renamed to render()
	 *
	 * @return void
	 */
	public function render() {

		$out = '';
		$limit_text =
			'<span class="ivd__alert  ivd__alert--danger">'
		.		'Maximal depth reached. Aborting. <br />'
		.		'See docs for modifying `max_depth` value.'
		.	'</span>'
		;

		if (!$this->is_flat) {
			 // *** Array ***
			if (is_array($this->obj)) {

				$length = count($this->obj);
				if (!$length) {
					$out .=
						'<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">'
					.		'array(0) '
					.		'<span class="ivd--noncolor">{}</span>'
					.	'</span>'
					;
				}
				else {
					$out .=
						'<span class="ivd__controller">'
					.		'array('.$length.')'
					.	'</span> '
					.	'{'
					.		'<span class="ivd__content"'
					.		' data-depth="'. $this->current_depth .'">'
					;

					 // prevent too deep nestings.
					if ($this->current_depth >= $this->max_depth) {
						$out .= $limit_text;

					} else {
						foreach($this->obj as $key => $element) {
							$key_string = sprintf(
								'%s<span class="ivd__key-core">%s</span>%s',
								is_integer($key)  ? ''  : '"',
								$key,
								is_integer($key)  ? ''  : '"'
							);

							$tmp = new Node($element, $this->max_depth, ($this->current_depth +1));
							$out .=
								'<span class="ivd__item">'
							.		'<span class="ivd__key" data-type="array-key">'
							.			$key_string
							.		'</span>'
							.		'<span class="ivd__arrow">=></span>'
							.		$tmp->render()
							.	'</span><!-- /.ivd__item -->'
							;
						}
					}

					$out .=
							'</span><!-- /.ivd__content -->'
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
						'<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">'
					.		'object('.$this->classname.') (0) '
					.		'<span class="ivd--noncolor">{}</span>'
					.	'</span>'
					;
				}
				else {
					$out .=
						'<span class="ivd__controller">'
					.		'object('.$this->classname.') ('.$length.')'
					.	'</span> '
					.	'{'
					.		'<span class="ivd__content"'
					.		' data-depth="'. $this->current_depth .'">'
					;

					 // prevent too deep nestings.
					if ($this->current_depth >= $this->max_depth) {
						$out .= $limit_text;

					} else {
						foreach($reflective_properties as $property) {
							 // make protected and private properties readable.
							$property->setAccessible(true);

							 // prepare key string.
							$key_string = '';
							$ppp = '';
							if ($property->isPrivate()) {
								$key_string .= ':"'.$property->class.'":private';
								$ppp = '  ivd--private';
							}
							elseif ($property->isProtected()) {
								$key_string .= ':protected';
								$ppp = '  ivd--protected';
							}
							else {
								$ppp = '  ivd--public';
							}
							if (!empty($key_string)) {
								$key_string = '<span class="ivd--noncolor">'.$key_string.'</span>';
							}

							 // apply "ivd value" structure and display the value recursively (could be an object).
							$tmp = $property->getValue($this->obj);
							$tmp = new Node($tmp, $this->max_depth, ($this->current_depth +1));
							$out .=
								'<span class="ivd__item  '.$ppp.'">'
							.		'<span class="ivd__key" data-type="object-prop">'
							.			'"<span class="ivd__key-core">'
							.				$property->name
							.			'</span>"'
							.			$key_string
							.		'</span>'
							.		'<span class="ivd__arrow">=></span>'
							.		$tmp->render()
							.	'</span><!-- /.ivd__item -->'
							;
						}  // end of ( each property )
					}  // end of ( depth allowed )

					$out .=
							'</span><!-- /.ivd__content -->'
					.	'}'
					;
				}  // end of ( object has at least one property )


			 // *** not Array, not Object, not Scalar – fallback for unexpectations ***
			} else {
				$out .= 'unexpected type: '. $this->type;

				 // prevent too deep nestings.
				if ($this->current_depth >= $this->max_depth) {
					$out .= $limit_text;

				} else {
					$tmp = new Node($this->obj, $this->max_depth, ($this->current_depth +1));
					$out .= $tmp->render();
				}
			}


		 // *** Scalar – obj is as flat as a flunder ***
		} else {

			$styled_value = '<span class="ivd__value">'.$this->obj.'</span>';

			switch ($this->type) {

				case 'string':
					$len = strlen($this->obj);
					$len_entity_test = strlen(html_entity_decode($this->obj, ENT_QUOTES));

					$out .= 'string('.$len.') "'.$styled_value.'"';

					if ($len !== $len_entity_test) {
						$out .= ' (HTML-entity detected)';
					}
					break;


				case 'integer':
					$out .= 'int('.$styled_value.')';
					break;


				case 'double':
					$out .= 'float('.$styled_value.')';
					break;


				case 'boolean':
					$out .= 'bool(<span class="ivd__value">'.($this->obj  ? 'true'  : 'false').'</span>)';
					break;


				case 'null':
					$out .= '<span class="ivd__value">NULL</span>';
					break;


				default:
					$out .= 'Unsupported variable type: '.$this->type;
					break;

			}  // end of ( switch: type )

			$out = '<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">'.$out.'</span>';

		}  // end of ( is flat )

		return $out;
	}




	//=============== GETTERS/SETTERS ===============//

	/**
	 * Get the $obj property.
	 *
	 * @since version 1.0.1: as get_object()
	 * @since version 1.3.0: renamed to getObject()
	 *
	 * @return mixed
	 */
	public function getObject() {
		return $this->obj;
	}

	/**
	 * Get the $type property.
	 *
	 * @since version 1.0.1: as get_type()
	 * @since version 1.3.0: renamed to getType()
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Get the $classname property.
	 *
	 * @since version 1.0.1: as get_classname()
	 * @since version 1.3.0: renamed to getClassname()
	 *
	 * @return string
	 */
	public function getClassname() {
		return $this->classname;
	}

	/**
	 * Get the $is_flat property.
	 *
	 * @since version 1.0.1: as are_you_flat()
	 * @since version 1.3.0: renamed to isFlat()
	 *
	 * @return boolean
	 */
	public function isFlat() {
		return $this->is_flat;
	}

}  // end of ( CLASS "Node" )

