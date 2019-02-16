<?php
/**
 * This plugin class is used to register the necessary custom fields in Woocommerce
 * In order to tie Woocommerce products to their Imirus product number
 */
class WP_Imirus_Register_Woocommerce_Custom_Fields {
    
    /**
	 * Register Woocommerce Custom Fields
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    public function register_fields(){
        //Add custom fields to WooCommerce product 
        add_action( 'woocommerce_product_options_general_product_data', array( $this, 'WP_imirus_add_custom_wc_fields'), 10, 0 );

    }
    /**
    * Save Custom Fields
    *
    * @since 2.0.0
    * @access public
    * @return void
    */
    public static function WP_imirus_save_custom_fields( $post_id ) {
            if ( ! empty( $_POST['_imirus_product_id'] ) ) {
                update_post_meta( $post_id, '_imirus_product_id', esc_attr( $_POST['_imirus_product_id'] ) );
            }
        }

    /**
	 * Add Custom Fields
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    public function WP_imirus_add_custom_wc_fields(){
        // Print a custom text field
        woocommerce_wp_text_input( array(
            'id' => '_imirus_product_id',
            'label' => 'iMirus Product ID',
            'description' => 'Enter the iMirus product ID associated with this product',
            'desc_tip' => 'true',
            'placeholder' => 'id'
        ) );
    }


}