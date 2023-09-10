<?php
namespace Codexpert\CX_Plugin\App;

use Codexpert\Plugin\Base;
use Codexpert\CX_Plugin\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author Codexpert <hi@codexpert.io>
 */
class Front extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct() {
		$this->plugin	= CXP;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	public function add_admin_bar( $admin_bar ) {
		if( ! current_user_can( 'manage_options' ) ) return;

		$admin_bar->add_menu( [
			'id'    => $this->slug,
			'title' => $this->name,
			'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
			'meta'  => [
				'title' => $this->name,            
			],
		] );
	}

	public function head() {}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '' : '.min';

		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/front{$min}.css", CXP_FILE ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/front{$min}.js", CXP_FILE ), [ 'jquery' ], $this->version, true );
		
		$localized = [
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'_wpnonce'		=> wp_create_nonce(),
			'rest_nonce'	=> wp_create_nonce( 'wp_rest' ),
		];
		
		wp_localize_script( $this->slug, 'CXP', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function modal() {
		echo '
		<div id="cx-plugin-modal" style="display: none">
			<img id="cx-plugin-modal-loader" src="' . esc_attr( CXP_ASSETS . '/img/loader.gif' ) . '" />
		</div>';
	}
}