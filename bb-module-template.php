<?php
/**
 * Plugin Name: Beaver Builder Module AddOns - Template.
 * Plugin URI: #
 * Description: #
 * Version: 1.0
 * Author: #
 * Author URI: #
 */
define( 'BB_MODULE_TEMPLATE_DIR', plugin_dir_path( __FILE__ ) );
define( 'BB_MODULE_TEMPLATE_URL', plugins_url( '/', __FILE__ ) );


class BB_Module_Addons_Template_Loader {
	
	/**
	 * Initializes the class once all plugins have loaded.
	 */
	static public function init() {

		add_action( 'plugins_loaded', __CLASS__ . '::setup_hooks' );

	}
	
	/**
	 * Setup hooks if the builder is installed and activated.
	 */
	static public function setup_hooks() {

		if ( ! class_exists( 'FLBuilder' ) ) return;	
		
		// Load custom modules.
		add_action( 'init', __CLASS__ . '::load_modules' );
		
		// Register custom fields.
		add_filter( 'fl_builder_custom_fields', __CLASS__ . '::register_fields' );
		
		// Enqueue custom field assets.
		add_action( 'init', __CLASS__ . '::enqueue_field_assets' );

	}
	
	/**
	 * Loads our custom modules.
	 */
	static public function load_modules() {

		$module_dir = BB_MODULE_TEMPLATE_DIR . 'modules';

		$modules = array(
			'basic-example',
			'example',
		);

		if ( $modules ) {

			foreach ( $modules as $value ) {

				require_once "$module_dir/$value/$value.php";

			}
			
		}

	}
	
	/**
	 * Registers our custom fields.
	 */
	static public function register_fields( $fields ) {

		$fields['my-custom-field'] = BB_MODULE_TEMPLATE_DIR . 'fields/my-custom-field.php';

		return $fields;

	}
	
	/**
	 * Enqueues our custom field assets only if the builder UI is active.
	 */
	static public function enqueue_field_assets() {

		if ( ! FLBuilderModel::is_builder_active() ) return;
		
		wp_enqueue_style( 'my-custom-fields', BB_MODULE_TEMPLATE_URL . 'assets/css/fields.css', array(), '' );
		wp_enqueue_script( 'my-custom-fields', BB_MODULE_TEMPLATE_URL . 'assets/js/fields.js', array(), '', true );

	}

}

BB_Module_Addons_Template_Loader::init();


