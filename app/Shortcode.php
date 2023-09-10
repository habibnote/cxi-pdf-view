<?php
namespace Codexpert\CXI_PDF_view\App;

use Codexpert\Plugin\Base;
use mukto90\Ncrypt;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Shortcode
 * @author Codexpert <hi@codexpert.io>
 */
class Shortcode extends Base {

    public $plugin;
    public $slug;
    public $name;
    public $version;

    /**
     * Constructor function
     */
    public function __construct() {
        $this->plugin   = CXP;
        $this->slug     = $this->plugin['TextDomain'];
        $this->name     = $this->plugin['Name'];
        $this->version  = $this->plugin['Version'];
    }

    /**
     * Shortcode
     */
    public function cxi_shortcode() {

        $token = $_GET['token'];

        /**
         * Class for decript and token
         */
        if( !empty($token) ){
            $ncrypt = new Ncrypt();
            $decript_token = $ncrypt->decrypt( $token );
            $lang = substr( $decript_token, 32 );

            /**
             * get all saved pdf from database opton table
             */
            $all_pdf_urls = get_option( 'cxi_all_languages_files' );

            //get specific pdf
            $lang_pdf_url = $all_pdf_urls[$lang];
            
            //Print pdf
            return "<iframe src='{$lang_pdf_url}' width='100%' height='800px'></iframe>";
        }
        
    }
}