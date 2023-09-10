<?php
namespace Codexpert\CX_Plugin\App;

use Codexpert\Plugin\Base;
use Codexpert\CX_Plugin\API\Pdf;


/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Common
 * @author Codexpert <hi@codexpert.io>
 */
class API extends Base {

	public $plugin;
	public $slug;
	public $version;
	public $namespace;

	/**
	 * Constructor function
	 */
	public function __construct() {
		$this->plugin		= CXP;
		$this->slug			= $this->plugin['TextDomain'];
		$this->version		= $this->plugin['Version'];

		$this->namespace	= apply_filters( "{$this->slug}_rest_route_namespace", sprintf( '%1$s/v%2$d', $this->slug, 1 ) );
	}

	public function register_endpoints() {

		/**
		 * generate Token API
		 */
		register_rest_route( $this->namespace, '/generate', [
			'methods'   => 'POST',
			'callback'  => [ new Pdf, 'token' ],
		] );
	}
}