<?php
namespace Codexpert\CX_Plugin\API;

use mukto90\Ncrypt;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage API
 * @author Codexpert <hi@codexpert.io>
 */
class Pdf {

    private $langs;
    private $option_langs_list = []; 

    public function __construct(){
        $this->langs = get_option('cxi_all_languages_files');
        foreach( $this->langs as $key => $value ){
            if( !empty( $value ) ){
                array_push( $this->option_langs_list, $key );
            }
        }
    }

	public function token( $request ) {
        $hash    = strtolower( $request->get_param( 'hash' ) );
        $lang    = strtolower( $request->get_param( 'lang' ) );

        if( empty( $hash ) ) return "Invalid Request";
        if( empty( $lang ) ) return "Invalid Resuest";

        if( strlen( $hash ) !== 32 ){
            return "Hash must be 32 character";
        }

        if( in_array( $lang, $this->option_langs_list ) ) {

            $row_token = $hash . $lang;

            /**
             * Class for encript and token
             */
            $ncrypt = new Ncrypt();
            $token = $ncrypt->encrypt( $row_token );

            /**
             * Check page is exit or not
             */
            $page = get_page_by_path('view');
            if( !$page ){
                $new_page = array(
                    'post_title' => 'View', // Change this to your desired page title
                    'post_type' => 'page',
                    'post_name' => 'view',
                    'post_status' => 'publish',
                );
            
                wp_insert_post($new_page);
            }

            /**
             * Create New Page Url
             */
            $url = home_url() . "/view" . "/?token={$token}";
            
            return $url;
        }else{
            return "Sorry! This languages is not available Please try another languages";
        }
    }
}