<?php
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
class WP_Imirus_Public {

	/**
	 * The string used to uniquely identify this plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_name;
	/**
	 * The plugin_url
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_url;
	/**
	 * The plugin_path
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_path;
	/**
	 * Current version of the plugin
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $version;
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name, url, path and plugin version that can be used throughout the plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function __construct( $plugin_root ) {

		$this->plugin_name = 'wp-imirus-public';
		$this->plugin_url = plugin_dir_url( $plugin_root );
		$this->plugin_path = plugin_dir_path( $plugin_root );
		$this->version = '2.0.0';
	}
	/**
	 * Register the actions and filters
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function run() {
		// include dependencies
		add_action( 'after_setup_theme', array( $this, 'setup_dependencies' ), 20, 0 );
		// register woocommerce custom fields
		add_action( 'after_setup_theme', array( $this, 'register_woocommerce_custom_fields' ), 20, 0 );

	}
	/**
	 * Include dependencies
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function setup_dependencies() {
		if ( is_admin() ) {
			// Include dependencies
            require_once( $this->plugin_path . 'includes/admin/class-wp-imirus-admin.php' );
			$admin = new WP_Imirus_Public_Admin( $this->plugin_name );
			$admin->create_admin_options();
		}
	}
	/**
	 * register woocommerce custom fields
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function register_woocommerce_custom_fields(){
		if ( is_admin() ) {
			require_once( $this->plugin_path . 'includes/class-wp-imirus-register-woocommerce-custom-fields.php' );
			$register = new WP_Imirus_Register_Woocommerce_Custom_Fields();
			$register->register_fields();

		}
	}

}
