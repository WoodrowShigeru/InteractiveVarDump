<?php

// namespace InteractiveVarDump;


/**
 * Tree representation of any given variable.
 */
class Tree {

	const COLOR_MODE_ALL	= 'all';
	const COLOR_MODE_LINK	= 'link';
	const COLOR_MODE_BOX	= 'box';
	const COLOR_MODE_NONE	= 'none';



	/**
	 * @var Node|null $root
	 *   The root node.
	 */
	private $root = NULL;

	/**
	 * @var string $color_mode
	 *   The current color-mode of the tree.
	 */
	private $color_mode = self::COLOR_MODE_ALL;

	/**
	 * @var integer $max_depth
	 *   The current threshold value to prevent too deep nesting.
	 */
	private $max_depth = 10;

	/**
	 * @var integer $indent
	 *   The current indentation level.
	 */
	private $indent = 0;

	/**
	 * @var boolean $plz_start_collapsed
	 *   Whether or not to start collapsed.
	 */
	private $plz_start_collapsed = FALSE;



	//=============== CONSTRUCTOR ===============//

	/**
	 * Create an instance of this class.
	 *
	 * @param mixed $subject
	 *   The variable to dump.
	 *
	 * @param array|null $config
	 *   Optional configuration.
	 *
	 * @return Tree
	 */
	public function __construct( $subject, array $config = NULL ) {

		// normalize config.
		if (!isset($config)) {
			$config = array();
		}

		// [return].
		if (
			!array_key_exists('return', $config)
		||	!is_bool($config['return'])
		) {
			$config['return'] = FALSE;
		}


		// [color].
		$valid = array(
			self::COLOR_MODE_ALL,
			self::COLOR_MODE_LINK,
			self::COLOR_MODE_BOX,
			self::COLOR_MODE_NONE,
		);
		if (
			!array_key_exists('color', $config)
		||	!in_array($config['color'], $valid)
		) {
			$config['color'] = 'all';
		}


		// [max_depth].
		if (
			!array_key_exists('max_depth', $config)
		||	!is_integer($config['max_depth'])
		||	($config['max_depth'] < 1)
		) {
			$config['max_depth'] = 10;
		}


		// [indent].
		if (
			!array_key_exists('indent', $config)
		||	!is_integer($config['indent'])
		||	($config['indent'] < 1)
		||	($config['indent'] > 20)
		) {
			$config['indent'] = 0;
		}


		// [start_collapsed].
		if (
			!array_key_exists('start_collapsed', $config)
		||	!is_bool($config['start_collapsed'])
		) {
			$config['start_collapsed'] = FALSE;
		}


		$this->max_depth	= $config['max_depth'];
		$this->indent		= $config['indent'];
		$this->color_mode	= $config['color'];

		$this->plz_start_collapsed	= $config['start_collapsed'];

		$this->root = new Node($subject, $this->max_depth, 0);
	}




	//=============== METHODS ===============//

	/**
	 * Render the tree.
	 *
	 * @since version 1.0.1: as display()
	 * @since version 1.3.0: renamed to render()
	 *
	 * @return void
	 */
	public function render() {

		$classes = array('ivd__tree  ivd--dismissable');

		if ($this->plz_start_collapsed) {
			array_push($classes, 'ivd--start-collapsed');
		}

		return sprintf(
			'<div class="%s"
				data-ivd-color-mode="%s"
				data-ivd-indent-level="%d"
			>'
		.		'<span class="ivd__dismiss">&times;</span>'
		.		'<span class="ivd__z-indexer-start"
					title="Adjust z-index"
				>z</span>'
		.		'<div class="ivd__root-wrapper">%s</div>'
		.	'</div><!-- /.ivd__tree -->',

			implode('  ', $classes),
			$this->color_mode,
			$this->indent,
			$this->root->render()
		);
	}




	//=============== GETTERS/SETTERS ===============//

	/**
	 * Get the tree as a variable instead of rendering it.
	 *
	 * @since version 1.1
	 *
	 * @return Node
	 *   Returns the root node.
	 */
	public function get() {

		return $this->root;
	}

}

