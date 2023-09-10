<?php
namespace Codexpert\CXI_PDF_view\API;

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

        /**
         * getting all languages as a array
         */
        foreach( $this->langs as $key => $value ){
            if( !empty( $value ) ){
                array_push( $this->option_langs_list, $key );
            }
        }
    }

    /**
     * Get API request and take response
     */
	public function token( $request ) {
        //intial param
        $hash    = strtolower( $request->get_param( 'hash' ) );
        $lang    = strtolower( $request->get_param( 'lang' ) );

        //Check if empty or not
        if( empty( $hash ) ) return "Invalid Param";
        if( empty( $lang ) ) return "Invalid Param";

        //Check has is equal to 32
        if( strlen( $hash ) !== 32 ){
            return "Hash must be 32 character";
        }

        //Check pdf exit or not
        if( in_array( $lang, $this->option_langs_list ) ) {
            $row_token = $hash . $lang;

            /**
             * Class for encript and token
             */
            $ncrypt = new Ncrypt();
            $token = $ncrypt->encrypt( $row_token );

            /**
             * Check page is exit or not
             * 
             * if not than it will create first
             */
            $page = get_page_by_path( 'view' );
            if( !$page ){
                $new_page = array(
                    'post_title'    => 'View', // Change this to your desired page title
                    'post_type'     => 'page',
                    'post_name'     => 'view',
                    'post_status'   => 'publish',
                );
            
                //Create a page
                wp_insert_post($new_page);
            }

            /**
             * Create New Page Url 
             */
            $url = home_url() . "/view" . "/?token={$token}";


            $response = array(
                'status'       => 200,
                'massage'      => 'succes',
                'page_url'     => $url,
            );

            return $response;

        }else{
            return "Sorry! This languages is not available Please try another languages";
        }
    }
}