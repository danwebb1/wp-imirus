<?php
/**
 * This class sends the woocommerce imirus order data to the 
 * imirus REST api
 */
class WP_Imirus_API{
    
    private $wpdb;

	/**
	 * XML to send
	 *
	 * @since 2.0.0
	 * @access public
	 * @var object
	 */
    public $xml;


    public function __construct( $xml ) 
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->xml = $xml;


    }
	/**
	 * convert xml to string
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
   // public function __toString() {
   //     return $this->xml;
   // }
     /**
	 * Send the order data to the API
	 *
	 * @since 2.0.0
	 * @access public
	 * @return callable
	 */
    public function imirus_send(){

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://www.imirus.com/fulfillment/service');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13');
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->xml );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        $result = curl_exec($ch);
        echo curl_getinfo($ch) . '<br/>';
        echo curl_errno($ch) . '<br/>';
        echo curl_error($ch) . '<br/>';
        curl_close($ch);
    
        return $this->store_results($result);
  
   }

    /**
	 * Save the API call results to the database
	 *
	 * @since 2.0.0
	 * @access public
	 * @return null
	 */
   public function store_results($result)
    {
            $this->wpdb->get_results("
            
                  INSERT into wp_imirus_log (Date_time, XML_SENT, Response)
                  Values ('".date('Y-m-d h:m:s')."', '".$this->xml."', '".$result."');
            
                  ");
            
            
              
    }


}



