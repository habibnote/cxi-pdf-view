<?php
/**
 * Plugin Name: CXI PDF View
 * Description: Just another plugin by Md. Habib
 * Plugin URI: https://me.habibnote.com
 * Author: Md. Habibur Rahman
 * Author URI: https://me.habibnote.com
 * Version: 0.9
 * Requires at least: 5.0
 * Tested up to: 6.3
 * Requires PHP: 7.4
 * Text Domain: cxi-pdf-view
 * Domain Path: /languages
 *
 * CX_Plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * CX_Plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace Codexpert\CXI_PDF_view;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author Codexpert <hi@codexpert.io>
 */
final class Plugin {
	
	/**
	 * The Plugin
	 * 
	 * @access private
	 */
	private $plugin;
	
	/**
	 * Plugin instance
	 * 
	 * @access private
	 * 
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * The constructor method
	 * 
	 * @access private
	 * 
	 * @since 0.9
	 */
	private function __construct() {
		
		/**
		 * Includes required files
		 */
		$this->include();

		/**
		 * Defines contants
		 */
		$this->define();

		/**
		 * Runs actual hooks
		 */
		$this->hook();
	}

	/**
	 * Includes files
	 * 
	 * @access private
	 * 
	 * @uses composer
	 * @uses psr-4
	 */
	private function include() {
		require_once( dirname( __FILE__ ) . '/inc/functions.php' );
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	}

	/**
	 * Define variables and constants
	 * 
	 * @access private
	 * 
	 * @uses get_plugin_data
	 * @uses plugin_basename
	 */
	private function define() {

		/**
		 * Define some constants
		 * 
		 * @since 0.9
		 */
		define( 'CXP_FILE', __FILE__ );
		define( 'CXP_DIR', dirname( CXP_FILE ) );
		define( 'CXP_ASSETS', plugins_url( 'assets', CXP_FILE ) );
		define( 'CXP_DEBUG', apply_filters( 'cx-plugin_debug', true ) );

		/**
		 * The plugin data
		 * 
		 * @since 0.9
		 * @var $plugin
		 */
		$this->plugin					= get_plugin_data( CXP_FILE );
		$this->plugin['basename']		= plugin_basename( CXP_FILE );
		$this->plugin['file']			= CXP_FILE;
		$this->plugin['doc_id']			= 1960;
		$this->plugin['server']			= 'https://my.pluggable.io';
		$this->plugin['icon']			= CXP_ASSETS . '/img/icon.png';
		$this->plugin['depends']		= [];
		
		// set plugin data instance
		define( 'CXP', apply_filters( 'cx-plugin_instance', $this->plugin ) );

		do_action( 'cx-plugin_loaded' );
	}

	/**
	 * Hooks
	 * 
	 * @access private
	 * 
	 * Executes main plugin features
	 *
	 * To add an action, use $instance->action()
	 * To apply a filter, use $instance->filter()
	 * To register a shortcode, use $instance->register()
	 * To add a hook for logged in users, use $instance->priv()
	 * To add a hook for non-logged in users, use $instance->nopriv()
	 * 
	 * @return void
	 */
	private function hook() {

		if( is_admin() ) :

			/**
			 * The installer
			 */
			$installer = new App\Installer();
			$installer->activate( 'install' );
			$installer->deactivate( 'uninstall' );
			$installer->action( 'admin_footer', 'upgrade' );

			/**
			 * Admin facing hooks
			 */
			$admin = new App\Admin();
			$admin->action( 'admin_footer', 'modal' );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'admin_menu', 'admin_menu' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->action( 'save_post', 'update_cache', 10, 3 );
			$admin->action( 'admin_footer_text', 'footer_text' );

			/**
			 * Settings related hooks
			 */
			$settings = new App\Settings();
			$settings->action( 'plugins_loaded', 'init_menu' );

		else : // ! is_admin() ?

			/**
			 * Shortcode related hooks
			 */
			$shortcode = new App\Shortcode();
			$shortcode->register( 'cxi-pdf-view', 'cxi_shortcode' );

			/**
			 * Custom REST API related hooks
			 */
			$api = new App\API();
			$api->action( 'rest_api_init', 'register_endpoints' );

		endif;

	}

	/**
	 * Instantiate the plugin
	 * 
	 * @access public
	 * 
	 * @return $_instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();