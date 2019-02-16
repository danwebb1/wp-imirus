<?php
/**
 * This class grabs woocommerce order data
 * and sends it to data mapper class
 */
class WP_Imirus_Woocommerce_Order_Data {

	private $wpdb;

	/**
	 * Woocommerce Order Object
	 *
	 * @since 2.0.0
	 * @access public
	 * @var object
	 */
	public $order;
	
	/**
	 * Imirus Product ID
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
    public $imirus_product_id;
	
	/**
	 * Woocommerce Product ID
	 *
	 * @since 2.0.0
	 * @access public
	 * @var int
	 */
	public $wc_product_id;

	/**
	 * Woocommerce Order ID
	 *
	 * @since 2.0.0
	 * @access public
	 * @var int
	 */
	public $wc_order_id;

	/**
	 * Customer email
	 *
	 * @since 2.0.0
	 * @access public
	 * @var object
	 */
    public $new_customer_email;


    public function __construct( $order ) 
    {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->order = $order;

    }
     /**
	 * Get Woocommerce order details
	 *
	 * @since 2.0.0
	 * @access public
	 * @return object
	 */
    
    private function get_wc_product_id(){

        $order_details = $this->wpdb->get_row("SELECT wp_woocommerce_order_itemmeta.*,wp_woocommerce_order_items.*
                                        FROM wp_woocommerce_order_items 
                                        JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_itemmeta.order_item_id = wp_woocommerce_order_items.order_item_id
                                        WHERE order_id = '".$this->order->get_id()."' and meta_key = '_product_id'
                                        ORDER BY wp_woocommerce_order_itemmeta.meta_key");

		 $this->wc_product_id = $order_details->meta_value;
		 return $this->wc_product_id;
    }
     /**
	 * get imirus product ID
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function get_imirus_product_id(){

        $product = $this->wpdb->get_row("SELECT * from wp_postmeta where post_id = '".$this->get_wc_product_id()."' and meta_key = '_imirus_product_id'");

		$this->imirus_product_id = $product->meta_value;
		return $this->imirus_product_id;
		
	}

     /**
	 * Get new customer email
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function get_new_customer_email(){

        $new_customer_email = $this->wpdb->get_row("SELECT * from wp_postmeta where post_id = '".$this->order->get_id()."' and meta_key = '_billing_email'");

		$this->new_customer_email = $new_customer_email->meta_value; 
		return $this->new_customer_email;
	  
	}


}
