<?php
/**
 * This class maps the woocommerce order data and credentials 
 * and packages it for the api
 */
include 'class-wp-imirus-woocommerce-order-data.php';
include 'class-wp-imirus-api.php';
include 'class-wp-imirus-api-helper.php';
include 'class-wp-imirus-xml-builder.php';

class WP_Imirus_Order_Mapper {

	/**
	 * Woocommerce Order Object
	 *
	 * @since 2.0.0
	 * @access public
	 * @var object
	 */
    public $order;

    /**
	 * Plugin admin options
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
    public $options;

    public function __construct( $order, $options ) 
    {
        $this->order = $order;
        $this->options = $options;

    }
     /**
	 * Map Woocommerce and customer data to Order object and send it to the API
	 *
	 * @since 2.0.0
	 * @access public
	 * @return callable
	 */
    public function map_order_data(){


            $woocommerce_data = new WP_Imirus_Woocommerce_Order_Data($this->order);
            $imirus_credentials = new WP_Imirus_API_Helper($this->options);

            $map_data = array(
                "auth_email"         => $imirus_credentials->get_auth_email(),
                "auth_password"      => $imirus_credentials->get_auth_password(),
                "product"            => $woocommerce_data->get_imirus_product_id(),
                "new_customer_email" => $woocommerce_data->get_new_customer_email(),
                "template"           => $imirus_credentials>get_template()
            );

            $xml = new WP_Imirus_XML_Builder($map_data);
            $xml->build_xml();
            $send_data = new WP_Imirus_API( $xml->get_xml() );
            $send_data->imirus_send();


    }
    

}