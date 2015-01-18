<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Source: http://themehybrid.com/plugins/grid-columns

class Pojo_Shortcodes_Item_Column extends Pojo_Shortcodes_Item_Base {
	
	public $shortcode = 'column';
	
	public $shortcode_syntax = '[column grid="{{grid}}" span="{{span}}" push="{{push}}"]{{content}}[/column]';

	/**
	 * The current grid.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $grid = 4;

	/**
	 * The current total number of columns in the grid.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    int
	 */
	public $span = 0;

	/**
	 * Whether we're viewing the first column.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    bool
	 */
	public $is_first_column = true;

	/**
	 * Whether we're viewing the last column.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    bool
	 */
	public $is_last_column = false;

	/**
	 * Allowed grids can be 2, 3, 4, 5, 6, or 12 columns.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $allowed_grids = array( 2, 3, 4, 5, 6, 12 );

	public function render( $attr = array(), $content = null ) {
		/* If there's no content, just return back what we got. */
		if ( is_null( $content ) )
			return $content;

		/* Set up the default variables. */
		$output         = '';
		$row_classes    = array();
		$column_classes = array();

		/* Set up the default arguments. */
		$defaults = apply_filters(
			'gc_column_defaults',
			array(
				'grid'  => $this->grid,
				'span'  => 1,
				'push'  => 0,
				'class' => ''
			)
		);

		/* Parse the arguments. */
		$attr = shortcode_atts( $defaults, $attr );

		/* Allow devs to filter the arguments. */
		$attr = apply_filters( 'gc_column_args', $attr );

		/* Allow devs to overwrite the allowed grids. */
		$this->allowed_grids = apply_filters( 'gc_allowed_grids', $this->allowed_grids );

		/* Make sure the grid is in the allowed grids array. */
		if ( $this->is_first_column && in_array( $attr['grid'], $this->allowed_grids ) )
			$this->grid = absint( $attr['grid'] );

		/* Span cannot be greater than the grid. */
		$attr['span'] = ( $this->grid >= $attr['span'] ) ? absint( $attr['span'] ) : 1;

		/* The push argument should always be less than the grid. */
		$attr['push'] = ( $this->grid > $attr['push'] ) ? absint( $attr['push'] ) : 0;

		/* Add to the total $span. */
		$this->span = $this->span + $attr['span'] + $attr['push'];

		/* Column classes. */
		$column_classes[] = 'column';
		$column_classes[] = "column-length-{$attr['span']}";
		$column_classes[] = "column-push-{$attr['push']}";

		/* Add user-input custom class(es). */
		if ( ! empty( $attr['class'] ) ) {
			if ( ! is_array( $attr['class'] ) )
				$attr['class'] = preg_split( '#\s+#', $attr['class'] );
			$column_classes = array_merge( $column_classes, $attr['class'] );
		}

		/* Add the 'column-first' class if this is the first column. */
		if ( $this->is_first_column )
			$column_classes[] = 'column-first';

		/* If the $span property is greater than (shouldn't be) or equal to the $grid property. */
		if ( $this->span >= $this->grid ) {
			/* Add the 'column-last' class. */
			$column_classes[] = 'column-last';

			/* Set the $is_last_column property to true. */
			$this->is_last_column = true;
		}

		/* Object properties. */
		$object_vars = get_object_vars( $this );

		/* Allow devs to create custom classes. */
		$column_classes = apply_filters( 'gc_column_class', $column_classes, $attr, $object_vars );

		/* Sanitize and join all classes. */
		$column_class = join( ' ', array_map( 'sanitize_html_class', array_unique( $column_classes ) ) );

		/* Output */

		/* If this is the first column. */
		if ( $this->is_first_column ) {
			/* Row classes. */
			$row_classes = array( 'column-grid', "column-grid-{$this->grid}" );
			$row_classes = apply_filters( 'gc_row_class', $row_classes, $attr, $object_vars );
			$row_class   = join( ' ', array_map( 'sanitize_html_class', array_unique( $row_classes ) ) );

			/* Open a wrapper <div> to contain the columns. */
			$output .= '<div class="' . $row_class . '">';

			/* Set the $is_first_column property back to false. */
			$this->is_first_column = false;
		}

		/* Add the current column to the output. */
		$output .= '<div class="' . $column_class . '">' . apply_filters( 'gc_column_content', $content ) . '</div>';

		/* If this is the last column. */
		if ( $this->is_last_column ) {
			/* Close the wrapper. */
			$output .= '</div>';

			/* Reset the properties that have been changed. */
			$this->reset();
		}

		/* Return the output of the column. */

		return apply_filters( 'gc_column', $output );
	}

	/**
	 * Resets the properties to their original states.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function reset() {
		$skipVars = array( '_fields', '_header', '_outside_header', '_outside_icon', '_shortcode', '_shortcode_syntax' );

		foreach ( get_class_vars( __CLASS__ ) as $name => $default ) {
			if ( ! in_array( $name, $skipVars ) ) {
				$this->$name = $default;
			}
		}
	}

	public function __construct() {
		/* Apply filters to the column content. */
		add_filter( 'gc_column_content', 'wpautop' );
		add_filter( 'gc_column_content', 'shortcode_unautop' );
		add_filter( 'gc_column_content', 'do_shortcode' );
		
		
		parent::__construct();
	}
	
}

