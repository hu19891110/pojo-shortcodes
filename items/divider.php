<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Shortcodes_Item_Divider extends Pojo_Shortcodes_Item_Base {
	
	public $shortcode = 'divider';
	
	public $shortcode_syntax = '[divider style="{{style}}" weight="{{weight}}" color="{{color}}" width="{{width}}" align="{{align}}" margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}"]';

	public function render( $atts = array(), $content = null ) {
		$atts = shortcode_atts( $this->_get_default_values(), $atts );

		$wrap_style_array = $hr_style_array = array();
		if ( ! empty( $atts['margin_top'] ) )
			$wrap_style_array[] = 'margin-top:' . $atts['margin_top'];

		if ( ! empty( $atts['margin_bottom'] ) )
			$wrap_style_array[] = 'margin-bottom:' . $atts['margin_bottom'];

		if ( ! empty( $atts['width'] ) )
			$wrap_style_array[] = 'width:' . $atts['width'];

		if ( ! empty( $atts['color'] ) )
			$hr_style_array[] = 'border-color:' . $atts['color'];

		if ( ! empty( $atts['weight'] ) )
			$hr_style_array[] = 'border-width:' . $atts['weight'];
		
		return sprintf(
			'<div class="pojo-divider align%s divider-style-%s"%s>
				<hr%s />
			</div>',
			esc_attr( $atts['align'] ),
			$atts['style'],
			! empty( $wrap_style_array ) ? ' style="' . esc_attr( implode( ';', $wrap_style_array ) ) . '"' : '',
			! empty( $hr_style_array ) ? ' style="' . esc_attr( implode( ';', $hr_style_array ) ) . '"' : ''
		);
	}

	public function __construct() {
		$this->_add_field(
			'style',
			array(
				'std' => 'space',
			)
		);
		
		$this->_add_field(
			'weight',
			array(
				'std' => '1px',
			)
		);
		
		$this->_add_field(
			'color',
			array(
				'std' => '#999999',
			)
		);
		
		$this->_add_field(
			'width',
			array(
				'std' => '100%',
			)
		);
		
		$this->_add_field(
			'align',
			array(
				'std' => 'none',
			)
		);
		
		$this->_add_field(
			'margin_top',
			array(
				'std' => '20px',
			)
		);
		
		$this->_add_field(
			'margin_bottom',
			array(
				'std' => '20px',
			)
		);
		
		parent::__construct();
	}
	
}

