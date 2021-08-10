<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Cms_Firebase_Integration_Woocommerce
 * @subpackage Cms_Firebase_Integration_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cms_Firebase_Integration_Woocommerce
 * @subpackage Cms_Firebase_Integration_Woocommerce/public
 * @author     Ankit Jani <ankitj@cmsminds.com>
 */
class Cms_Firebase_Integration_Woocommerce_Public extends Cms_Firebase_Integration_Woocommerce_API {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		parent::__construct();
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cms_Firebase_Integration_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cms_Firebase_Integration_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cms-firebase-integration-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cms_Firebase_Integration_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cms_Firebase_Integration_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-validate-script', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), '1.19.2', false );
		wp_enqueue_script( 'jquery-additional-methods-script', plugin_dir_url( __FILE__ ) . 'js/additional-methods.min.js', array( 'jquery' ), '1.19.2', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cms-firebase-integration-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_url', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	 * Display Firebase login information message before checkout form.
	 *
	 * @since    1.0.0
	 */
	function cms_add_firebase_infomation_wccheckout( ) {
		$logged_in_class = ( is_user_logged_in() ) ? 'user-logged-in' : '';
		$loader_src = plugin_dir_url( __FILE__ ) . 'images/wpspin.gif';
		$html = '<div class="woocommerce-firebase-login-toggle ' . $logged_in_class . '">';
				$html .= '<div class="woocommerce-info"><a href="#" class="showfirebaselogin">Login with Firebase?</a></div>';
		$html .= '</div>';
		$html .= '<div class="cms-firebse-login-notices"></div>';
		$html .= '<form class="woocommerce-form woocommerce-firebse-login" method="post">';
		$html .= '<p class="form-row form-row-first">
					<label for="firebase_email">Email&nbsp;<span class="required">*</span></label>
					<input type="text" class="input-text" name="firebase_email" id="firebase_email" />
				</p>';
		$html .= '<p class="form-row form-row-last">
					<label for="firebase_password">Password&nbsp;<span class="required">*</span></label>
					<input class="input-text" type="password" name="firebase_password" id="firebase_password" />
				</p>';
		$html .= '<div class="clear"></div>';
		$html .= '<p class="form-row">
					' . wp_nonce_field( 'firebase_form_naction', 'firebase_form_nfield' ) . '
					<button type="submit" class="woocommerce-button button woocommerce-form-firebse-login__submit" name="login" value="Login">Login</button>
					<img class="cms-firebse-login-loader" src="' . $loader_src . '" />
				</p>';
		$html .= '</form>';

		echo $html;
	}


	function cms_call_firebase_api( $method, $data ){
		return parent::cms_call_firebase_api( $method, $data );
	}

	/**
	 * Call Firebase API
	 */
	public function cms_firebase_form_submit() {
		$return_data = array();

		if ( ! empty( $_POST ) ) {
			if ( ! isset( $_POST['firebase_form_nfield'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['firebase_form_nfield'] ) ), 'firebase_form_naction' ) ) {
				$return_data['error'] = 'Sorry, your nonce did not verify.';
			} else {
				$firebase_email    = ( ! empty( $_POST['firebase_email'] ) ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['firebase_email'] ) ) ) : '';
				$firebase_password = ( ! empty( $_POST['firebase_password'] ) ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['firebase_password'] ) ) ) : '';

				$data = '{"email":"' . $firebase_email . '","password":"' . $firebase_password . '","returnSecureToken":true}';

				$firebase_reponse = $this->cms_call_firebase_api( 'verifyPassword', $data );
				
				if ( isset( $firebase_reponse['email'] ) ) {

					$user  = get_user_by( "email", $firebase_reponse['email'] );
					if ( ! $user ) {
						$user = get_user_by( 'login', $firebase_reponse['email'] );
						if ( $user ) {
							$user_id = $user->ID;
							wp_set_auth_cookie( $user_id, true );
							$return_data['success'] = true;
						} else {
							$user_password = wp_generate_password( 10, false );
		
							$userdata = array(
								'user_login' => $firebase_reponse['email'],
								'user_pass'  => $user_password,
								'user_email' => $firebase_reponse['email'],
								'role'       => 'customer',
							);
			
							$user_id = wp_insert_user( $userdata );
			
							if ( ! is_wp_error( $user_id ) ) 
							{
								wp_set_auth_cookie( $user_id, true );
								$return_data['success'] = true;
							}
							else{
								$return_data['error'] = $user_id->get_error_message();
							}
						}
					}
					else{
						$user_id = $user->ID;
						wp_set_auth_cookie( $user_id, true );
						$return_data['success'] = true;
					}
				}
				else{
					if( 'EMAIL_NOT_FOUND' == $firebase_reponse['error']['message'] ) {
						$return_data['error'] = 'Your email not found with Firebase. Please enter correct email!';
					}

					if( 'INVALID_PASSWORD' == $firebase_reponse['error']['message'] ) {
						$return_data['error'] = 'Please enter correct password!';
					}
				}
			}
			echo wp_json_encode( $return_data );
		}
		die();
	}

}
