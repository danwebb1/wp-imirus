<?php 
/*
Plugin Name: WP iMirus
Description: Simple integration for WooCommerce and iMirus
Author: Dan Webb
Version: 2.0
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-imirus-public.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-imirus-install.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-imirus-register-woocommerce-custom-fields.php';

register_activation_hook(   __FILE__, array( 'WP_Imirus_Install', 'on_activation' ) );
register_uninstall_hook(    __FILE__, array( 'WP_Imirus_Install', 'on_uninstall' ) );

add_action( 'plugins_loaded', array( 'WP_Imirus_Install', 'init' ) );


//action to call imirus function when product purchase is successful
add_action( 'woocommerce_thankyou', 'imirus_process_order' );
//method for saving custom field
 add_action( 'woocommerce_process_product_meta', array('WP_Imirus_Register_Woocommerce_Custom_Fields', 'WP_imirus_save_custom_fields') );

/**
 * Begins execution of the API integration
 *
 * @since 2.0.0
 */
function imirus_process_order( $order_id ){
	//Get WooCommerce Order Object
	$order = new WC_order( $order_id );
	//get Imirus API credentials
	$options = get_option( 'WP_imirus_settings');
    include 'includes/class-wp-imirus-order-mapper.php';

	$integration = new WP_Imirus_Order_Mapper( $order, $options );
	$integration->map_order_data();
}


/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function run_wp_imirus_public() {
	$plugin = new WP_Imirus_Public( __FILE__ );
	$plugin->run();
}
run_wp_imirus_public();
