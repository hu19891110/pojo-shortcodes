<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Shortcodes_Item_Menu_anchor extends Pojo_Shortcodes_Item_Base {

	public $shortcode = 'menu-anchor';

	public $shortcode_syntax = '[menu-anchor anchor="{{anchor}}"]';

	public function render( $atts = array(), $content = null ) {
		$atts = shortcode_atts( $this->_get_default_values(), $atts );

		if ( empty( $atts['anchor'] ) )
			return '';
		
		return sprintf( '<div id="%s" class="pojo-menu-anchor"></div>', $atts['anchor'] );
	}

	public function __construct() {
		$this->_add_field(
			'anchor',
			array(
				'std' => '',
			)
		);
		
		parent::__construct();
	}

}

