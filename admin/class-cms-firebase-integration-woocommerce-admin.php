<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Cms_Firebase_Integration_Woocommerce
 * @subpackage Cms_Firebase_Integration_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cms_Firebase_Integration_Woocommerce
 * @subpackage Cms_Firebase_Integration_Woocommerce/admin
 * @author     Ankit Jani <ankitj@cmsminds.com>
 */
class Cms_Firebase_Integration_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * retrun void
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cms-firebase-integration-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * retrun void
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cms-firebase-integration-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 */
	public function cms_add_settings_tab( $settings_tabs ) {
		$settings_tabs['settings_tab_firebase_integration'] = __( 'Firebase Integration', 'woocommerce-settings-tab-firebase-integration' );
        return $settings_tabs;
	}
	
	/**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function cms_settings_tab() {
        woocommerce_admin_fields( self::cms_get_settings() );
    }

	/**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function cms_update_settings() {
        woocommerce_update_options( self::cms_get_settings() );
    }


    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function cms_get_settings() {

        $settings = array(
            'section_title' => array(
                'name'     => __( 'Firebase Integration', 'woocommerce-settings-tab-firebase-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_firebase_integration_section_title'
            ),
            'title' => array(
                'name' => __( 'API Key', 'woocommerce-settings-tab-firebase-integration' ),
                'type' => 'text',
                'desc' => __( 'Add your firebase account API Key', 'woocommerce-settings-tab-firebase-integration' ),
                'id'   => 'wc_settings_tab_firebase_integration_api_key'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_firebase_integration_section_end'
            )
        );

        return apply_filters( 'wc_settings_tab_firebase_integration_settings', $settings );
    }

}
