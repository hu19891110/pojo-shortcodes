<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Shortcodes_Item_Button extends Pojo_Shortcodes_Item_Base {
	
	public $shortcode = 'button';
	
	public $shortcode_syntax = '[button text="{{text}}" link="{{link}}" target_link="{{target_link}}" bg_color="{{bg_color}}" bg_opacity="{{bg_opacity}}" border_color="{{border_color}}" text_color="{{text_color}}" size="{{size}}" icon="{{icon}}" align="{{align}}"]';

	public function render( $atts = array(), $content = null ) {
		$atts = shortcode_atts( $this->_get_default_values(), $atts );

		if ( empty( $atts['text'] ) )
			return '';

		if ( empty( $atts['link'] ) )
			$atts['link'] = 'javascript:void(0);';

		$target = '';
		if ( ! empty( $atts['target_link'] ) && 'blank' === $atts['target_link'] )
			$target = ' target="_blank"';

		$link_inline_style = array();
		if ( ! empty( $atts['bg_color'] ) ) {
			$rgb_color = pojo_hex2rgb( $atts['bg_color'] );
			$color_value = sprintf( 'rgba(%d,%d,%d,%s)', $rgb_color[0], $rgb_color[1], $rgb_color[2], ( $atts['bg_opacity'] / 100 ) );

			$link_inline_style[] = 'background-color:' . $color_value;
		}

		if ( ! empty( $atts['border_color'] ) ) {
			$link_inline_style[] = 'border-color:' . $atts['border_color'];
		}

		if ( ! empty( $atts['text_color'] ) ) {
			$link_inline_style[] = 'color:' . $atts['text_color'];
		}
		
		return sprintf(
			'<div class="pojo-button-wrap pojo-button-%s">
				<a class="button size-%s"%s href="%s"%s>%s
					<span class="pojo-button-text">%s</span>
				</a>
			</div>',
			esc_attr( $atts['align'] ),
			esc_attr( $atts['size'] ),
			! empty( $link_inline_style ) ? ' style="' . esc_attr( implode( ';', $link_inline_style ) ) . '"' : '',
			$atts['link'],
			$target,
			! empty( $atts['icon'] ) ? '<span class="pojo-button-icon">' . $atts['icon'] . '</span> ' : '',
			$atts['text']
		);
	}

	public function __construct() {
		$this->_add_field(
			'text',
			array(
				'std' => __( 'Click me', 'pojo-shortcodes' ),
			)
		);
		
		$this->_add_field(
			'link',
			array(
				'std' => __( 'Link:', 'pojo-shortcodes' ),
			)
		);
		
		$this->_add_field(
			'target_link',
			array(
				'std' => 'same',
			)
		);
		
		$this->_add_field(
			'bg_color',
			array(
				'std' => '#fff',
			)
		);
		
		$this->_add_field(
			'bg_opacity',
			array(
				'std' => '100',
			)
		);
		
		$this->_add_field(
			'border_color',
			array(
				'std' => '#cccccc',
			)
		);
		
		$this->_add_field(
			'text_color',
			array(
				'std' => '#333333',
			)
		);
		
		$this->_add_field(
			'size',
			array(
				'std' => 'medium',
			)
		);
		
		$this->_add_field(
			'icon',
			array(
				'std' => '',
			)
		);
		
		$this->_add_field(
			'align',
			array(
				'std' => 'none',
			)
		);
		
		parent::__construct();
	}
	
}

