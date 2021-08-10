<?php

/**
 * The file that defines the core plugin Firebase API class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Cms_Firebase_Integration_Woocommerce_API
 * @subpackage Cms_Firebase_Integration_Woocommerce_API/includes
 */

/**
 * The core plugin Firebase API class.
 *
 * This is used to define Firebase APIs.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cms_Firebase_Integration_Woocommerce_API
 * @subpackage Cms_Firebase_Integration_Woocommerce_API/includes
 * @author     Ankit Jani <ankitj@cmsminds.com>
 */
class Cms_Firebase_Integration_Woocommerce_API {
    
    /**
	 * The API key that's responsible for communicating with Firebase Account.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cms_Firebase_Integration_Woocommerce_API_API_Key    $API_Key    Maintains Firebase account.
	 */
	protected $API_Key;

    /**
	 * The API endpoint that's responsible for communicating with Firebase API.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cms_Firebase_Integration_Woocommerce_API_API_url    $API_url    Firebase API url.
	 */
	protected $API_url;

    /**
	 * Define the core functionality of the Firebase API.
	 *
	 * Set the API Key that can be used throughout the Firebase API.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        
        if( '' !== get_option( 'wc_settings_tab_firebase_integration_api_key' ) ) {
		    $this->API_Key = get_option( 'wc_settings_tab_firebase_integration_api_key' );
            $this->API_url = 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/';
        }

	}

    /**
	 * Get the Firebase Account API Key.
	 *
	 * @since     1.0.0
	 * @return    string    The Firebase account API Key.
	 */
	public function cms_get_firebase_api_key() {
		return $this->API_Key;
	}

    /**
	 * Get the Firebase API URL.
	 *
	 * @since     1.0.0
	 * @return    string    The Firebase API URL.
	 */
	public function cms_get_firebase_api_endpoint() {
		return $this->API_url;
	}

    /**
	 * Call Firebase Account API.
	 *
	 * @since     1.0.0
     * @param     string   $method The Firebase API method which need to be called.
     * @param     string   $data The Firebase API payload.
	 * @return    array    The Firebase account API Response.
	 */
	public function cms_call_firebase_api( $method, $data ) {

        $API_Key = $this->cms_get_firebase_api_key();
        $API_url = $this->cms_get_firebase_api_endpoint();
        
        $final_endpoint = $API_url . $method . '?key=' . $API_Key;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $final_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return json_decode($response, true);
	}
}