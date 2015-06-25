<?php
/*
Plugin Name: Pojo Shortcodes
Plugin URI: http://pojo.me/
Description: ...
Author: Pojo Team
Author URI: http://pojo.me/
Version: 1.0.0
Text Domain: pojo-shortcodes
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'POJO_SHORTCODES__FILE__', __FILE__ );
define( 'POJO_SHORTCODES_BASE', plugin_basename( POJO_SHORTCODES__FILE__ ) );
define( 'POJO_SHORTCODES_URL', plugins_url( '/', POJO_SHORTCODES__FILE__ ) );
define( 'POJO_SHORTCODES_PATH', plugin_dir_path( POJO_SHORTCODES__FILE__ ) . '/' );
define( 'POJO_SHORTCODES_ASSETS_PATH', plugin_dir_path( POJO_SHORTCODES__FILE__ ) . 'assets/' );
define( 'POJO_SHORTCODES_ASSETS_URL', POJO_SHORTCODES_URL . 'assets/' );

final class Pojo_Shortcodes {

	/**
	 * @var Pojo_Shortcodes The one true Pojo_Shortcodes
	 * @since 1.0.0
	 */
	private static $_instance = null;

	/**
	 * @var Pojo_Shortcodes_Manager
	 */
	public $manager;

	public function load_textdomain() {
		load_plugin_textdomain( 'pojo-shortcodes', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pojo-shortcodes' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pojo-shortcodes' ), '1.0.0' );
	}

	/**
	 * @return Pojo_Shortcodes
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new Pojo_Shortcodes();

		return self::$_instance;
	}
	
	public function bootstrap() {
		// This plugin for Pojo Themes..
		// TODO: Add notice for non-pojo theme
		if ( ! class_exists( 'Pojo_Core' ) )
			return;

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 100 );

		include( POJO_SHORTCODES_PATH . 'includes/class-pojo-shortcodes-manager.php' );
		$this->manager = new Pojo_Shortcodes_Manager();
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'pojo-shortcodes', POJO_SHORTCODES_ASSETS_URL . 'css/front.css' );
	}

	private function __construct() {
		add_action( 'init', array( &$this, 'bootstrap' ) );
		add_action( 'plugins_loaded', array( &$this, 'load_textdomain' ) );
	}

}

Pojo_Shortcodes::instance();
// EOF