<?php

namespace InteractiveVarDump;

use ReflectionObject;


/**
 * Node representing a scalar value, array, object.
 */
class Node {

	const LIMIT_TEXT =
		'<span class="ivd__alert  ivd__alert--danger">
			Maximal depth reached. Aborting. <br />
			See docs for modifying `max_depth` value.
		</span>'
	;



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

		// Note: the connotation like this is on purpose.
		//
		//   '<lorem>'
		//  .  '<ipsum>'
		//
		// It solves a styling issue regarding the whitespace.
		// ------------------

		if ($this->is_flat) {
			return $this->renderScalar();
		}

		if (is_array($this->obj)) {
			return $this->renderArray();
		}

		if (is_object($this->obj)) {
			return $this->renderObject();
		}

		// not Array, not Object, not Scalar – fallback for unexpected
		// situations.
		$out = 'unexpected type: '. $this->type;

		// prevent too deep nestings.
		if ($this->current_depth >= $this->max_depth) {
			$out .= self::LIMIT_TEXT;

		} else {
			$sub = new Node($this->obj, $this->max_depth, $this->current_depth +1);
			$out .= $sub->render();
		}

		return $out;
	}


	/**
	 * Render an array node.
	 *
	 * @since version 1.3.0
	 *
	 * @return void
	 */
	private function renderArray() {

		$length = count($this->obj);

		if (!$length) {
			return
				'<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">'
			.		'array(0) '
			.		'<span class="ivd--noncolor">{}</span>'
			.	'</span>'
			;
		}


		$out = sprintf(
			'<span class="ivd__controller">'
		.		'array(%d)'
		.	'</span> '
		.	'{'
		.		'<span class="ivd__content"'
		.		' data-depth="%d">',

			$length, $this->current_depth
		);

		// prevent too deep nestings.
		if ($this->current_depth >= $this->max_depth) {
			$out .= self::LIMIT_TEXT;

		} else {
			foreach($this->obj as $key => $element) {
				$key_string = sprintf(
					'%s<span class="ivd__key-core">%s</span>%s',
					(is_integer($key)   ? ''   : '"'),
					$key,
					(is_integer($key)   ? ''   : '"')
				);

				$sub = new Node($element, $this->max_depth, $this->current_depth +1);

				$out .= sprintf(
					'<span class="ivd__item">'
				.		'<span class="ivd__key" data-type="array-key">%s</span>'
				.		'<span class="ivd__arrow">=></span>%s'
				.	'</span><!-- /.ivd__item -->',

					$key_string, $sub->render()
				);
			}
		}

		$out .=
				'</span><!-- /.ivd__content -->'
		.	'}'
		;

		return $out;
	}


	/**
	 * Render an object node.
	 *
	 * @since version 1.3.0
	 *
	 * @return void
	 */
	private function renderObject() {

		$out = '';

		// be prepared.
		$reflection = new ReflectionObject($this->obj);
		$reflective_properties = array();
		$tmp = $reflection->getProperties();

		// kick the static stuff (for child classes), we don't need it.
		foreach ($tmp as $property) {
			if (!$property->isStatic()) {
				array_push($reflective_properties, $property);
			}
		}
		unset($tmp);


		// count actual properties.
		$length = count($reflective_properties);

		if (!$length) {
			return sprintf(
				'<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">'
			.		'object(%s) (0) '
			.		'<span class="ivd--noncolor">{}</span>'
			.	'</span>',

				$this->classname
			);
		}

		$out .= sprintf(
			'<span class="ivd__controller">'
		.		'object(%s) (%d)'
		.	'</span> '
		.	'{'
		.		'<span class="ivd__content"'
		.		' data-depth="%d">',

			$this->classname, $length, $this->current_depth
		);

		// prevent too deep nestings.
		if ($this->current_depth >= $this->max_depth) {
			$out .= sprintf(
					'%s</span><!-- /.ivd__content -->'
			.	'}',

				self::LIMIT_TEXT
			);

			return $out;
		}


		foreach($reflective_properties as $property) {
			// make protected and private properties readable.
			$property->setAccessible(true);

			// prepare key string.
			$key_string = '';
			$ppp = '';

			if ($property->isPrivate()) {
				$key_string = sprintf(':"%s":private', $property->class);
				$ppp = '  ivd--private';

			} elseif ($property->isProtected()) {
				$key_string = ':protected';
				$ppp = '  ivd--protected';

			} else {
				$ppp = '  ivd--public';
			}

			if (!empty($key_string)) {
				$key_string = sprintf(
					'<span class="ivd--noncolor">%s</span>', $key_string
				);
			}

			// apply "ivd value" structure and display the value recursively (could be an object).
			$sub = new Node(
				$property->getValue($this->obj),
				$this->max_depth,
				$this->current_depth +1
			);

			$out .= sprintf(
				'<span class="ivd__item  %s">'
			.		'<span class="ivd__key" data-type="object-prop">'
			.			'"<span class="ivd__key-core">%s</span>"%s'
			.		'</span>'
			.		'<span class="ivd__arrow">=></span>%s'
			.	'</span><!-- /.ivd__item -->',

				$ppp, $property->name, $key_string, $sub->render()
			);
		}  // end of ( each: property )

		$out .=
				'</span><!-- /.ivd__content -->'
		.	'}'
		;

		return $out;
	}


	/**
	 * Render a scalar node.
	 *
	 * @since version 1.3.0
	 *
	 * @return void
	 */
	private function renderScalar() {

		$out = '';
		$styled_value = sprintf('<span class="ivd__value">%s</span>', $this->obj);

		switch ($this->type) {

			case 'string':
				$length = strlen($this->obj);
				$length_entity_test = strlen(html_entity_decode($this->obj, ENT_QUOTES));

				$out = sprintf('string(%d) "%s"', $length, $styled_value);

				if ($length !== $length_entity_test) {
					$out .= ' (HTML-entity detected)';
				}
				break;


			case 'integer':
				$out = sprintf('int(%s)', $styled_value);
				break;


			case 'double':
				$out = sprintf('float(%s)', $styled_value);
				break;


			case 'boolean':
				$out = sprintf(
					'bool(<span class="ivd__value">%s</span>)',
					($this->obj   ? 'true'   : 'false')
				);
				break;


			case 'null':
				$out = '<span class="ivd__value">NULL</span>';
				break;


			default:
				$out = 'Unsupported variable type: ' .$this->type;
				break;

		}  // end of ( switch: type )


		return sprintf(
			'<span class="ivd__scalar  ivd__value-wrapper  ivd--inline">%s</span>',
			$out
		);
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
}

