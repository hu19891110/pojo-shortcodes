<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Pojo_Shortcodes_Manager {
	
	public $shortcodes = array(
		'column',
	);
	
	protected $_instances = array();

	public function get_item( $shortcode ) {
		if ( isset( $this->_instances[ $shortcode ] ) )
			return $this->_instances[ $shortcode ];
		
		return false;
	}
	
	public function __construct() {
		include( POJO_SHORTCODES_PATH . 'includes/abstract-class-pojo-shortcodes-item-base.php' );
		
		foreach ( $this->shortcodes as $shortcode ) {
			include( POJO_SHORTCODES_PATH . 'items/' . $shortcode . '.php' );
			$item_class = 'Pojo_Shortcodes_Item_' . ucfirst( $shortcode );
			
			$this->_instances[ $shortcode ] = new $item_class;
		}
	}
	
}