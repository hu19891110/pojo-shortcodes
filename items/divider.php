<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Shortcodes_Item_Divider extends Pojo_Shortcodes_Item_Base {
	
	public $shortcode = 'divider';
	
	public $shortcode_syntax = '[divider up_button="{{up_button}}" style="{{style}}"]';

	public function render( $atts = array(), $content = null ) {
		$atts = shortcode_atts( $this->_get_default_values(), $atts );
		$color = '';
		if ( 'yes' === $atts['up_button'] ) {
			return sprintf( '<a href="javascript:void(0);" class="divider-up-button">' . __( 'Go To Top', 'pojo-shortcodes' ) . '</a><hr class="divider-with-up-button divider-style-%s"%s />', $atts['style'], $color );
		}

		return sprintf( '<hr class="divider divider-style-%s"%s />', esc_attr( $atts['style'] ), $color );
	}

	public function __construct() {
		$this->_add_field(
			'up_button',
			array(
				'std' => 'no',
			)
		);
		
		$this->_add_field(
			'style',
			array(
				'std' => 'solid',
			)
		);
		
		parent::__construct();
	}
	
}

