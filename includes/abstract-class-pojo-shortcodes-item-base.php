<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Pojo_Shortcodes_Item_Base {

	/**
	 * Shortcode Fields.
	 * @var array
	 */
	protected $_fields = array();

	/**
	 * Shortcode slug.
	 * @var string
	 */
	public $shortcode = '';

	/**
	 * Shortcode Syntax.
	 * @var string
	 */
	public $shortcode_syntax = '';
	
	protected function _add_field( $id, $args ) {
		$args = wp_parse_args(
			$args,
			array(
				'std' => '',
			)
		);
		
		$this->_fields[ $id ] = $args;
	}
	
	protected function _remove_field( $id ) {
		if ( isset( $this->_fields[ $id ] ) )
			unset( $this->_fields[ $id ] );
	}
	
	protected function _get_fields() {
		return $this->_fields;
	}
	
	protected function _get_default_values() {
		$default = array();
		foreach ( $this->_get_fields() as $k_field => $field ) {
			$default[ $k_field ] = $field['std'];
		}
		return $default;
	}
	
	abstract function render( $atts = array(), $content = null );

	public function __construct() {
		add_shortcode( $this->shortcode, array( &$this, 'render' ) );
	}
	
}