<?php
namespace Codexpert\CX_Plugin\App;

use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

/**
 * @package Plugin
 * @subpackage Settings
 * @author Codexpert <hi@codexpert.io>
 */
class Settings extends Base {

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
	
	public function init_menu() {
		
		$site_config = [
			'PHP Version'				=> PHP_VERSION,
			'WordPress Version' 		=> get_bloginfo( 'version' ),
			'WooCommerce Version'		=> is_plugin_active( 'woocommerce/woocommerce.php' ) ? get_option( 'woocommerce_version' ) : 'Not Active',
			'Memory Limit'				=> defined( 'WP_MEMORY_LIMIT' ) && WP_MEMORY_LIMIT ? WP_MEMORY_LIMIT : 'Not Defined',
			'Debug Mode'				=> defined( 'WP_DEBUG' ) && WP_DEBUG ? 'Enabled' : 'Disabled',
			'Active Plugins'			=> get_option( 'active_plugins' ),
		];

		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => "{$this->name} v{$this->version}",
			'header'        => $this->name,
			'capability' 	=> 'manage_options',
			'icon'       	=> 'dashicons-pdf',
			'sections'      => [
				'cxi_all_languages_files'	=> [
					'id'        => 'cxi_all_languages_files',
					'label'     => __( 'Upload All Languages PDF files', 'cx-plugin' ),
					'icon'      => 'dashicons-translation',
					'sticky'	=> false,
					'fields'    => [
						'bangla' => [
							'id'      		=> 'bangla',
							'label'     	=> __( 'Bangla' ),
							'type'      	=> 'file',
							'upload_button' => __( 'Choose File', 'cx-plugin' ),
							'select_button' => __( 'Select File', 'cx-plugin' ),
							'desc'      	=> __( 'Upload a PDF file.', 'cx-plugin' ),
							'disabled'  	=> false, // true|false
						],
						'english' => [
							'id'      		=> 'english',
							'label'     	=> __( 'English' ),
							'type'      	=> 'file',
							'upload_button' => __( 'Choose File', 'cx-plugin' ),
							'select_button' => __( 'Select File', 'cx-plugin' ),
							'desc'      	=> __( 'Upload a PDF file.', 'cx-plugin' ),
							'disabled'  	=> false, // true|false
						],
						'hindi' => [
							'id'      		=> 'hindi',
							'label'     	=> __( 'Hindi' ),
							'type'      	=> 'file',
							'upload_button' => __( 'Choose File', 'cx-plugin' ),
							'select_button' => __( 'Select File', 'cx-plugin' ),
							'desc'      	=> __( 'Upload a PDF file.', 'cx-plugin' ),
							'disabled'  	=> false, // true|false
						],

					]
				],
				
			],
		];

		new Settings_API( $settings );
	}
}