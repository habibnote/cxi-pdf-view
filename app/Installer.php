<?php
namespace Codexpert\CX_Plugin\App;

use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Installer
 * @author Codexpert <hi@codexpert.io>
 */
class Installer extends Base {

	public $plugin;
	public $slug;
	public $name;
	public $version;

	/**
	 * Constructor function
	 */
	public function __construct() {
		$this->plugin	= CXP;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {

		/**
		 * Schedule an event
		 */
		if ( ! wp_next_scheduled( 'codexpert-daily' ) ) {
		    wp_schedule_event( time(), 'daily', 'codexpert-daily' );
		}
	}

	/**
	 * Uninstaller. Runs once when the plugin in deactivated.
	 *
	 * @since 1.0
	 */
	public function uninstall() {
		
		/**
		 * Remove scheduled hooks
		 */
		wp_clear_scheduled_hook( 'codexpert-daily' );
	}

	public function upgrade() {
		if( $this->version == get_option( "{$this->slug}_db-version" ) ) return;
		update_option( "{$this->slug}_db-version", $this->version, false );

		// upgrader actions
	}
}