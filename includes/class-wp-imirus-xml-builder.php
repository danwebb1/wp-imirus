
<?php
/**
 * This class srenders the XML with iMirus API credentials and WooCommerce Product Data 
 * to send to the fulfillment service
 */
class WP_Imirus_XML_Builder{
	/**
	 * Woocommerce and API crednetial Data
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
    public $map_data = array();

    /**
	 * XML object
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
    protected $xml_data;

    public function __construct( $map_data ) 
    {
        $this->map_data = $map_data;

    }

    /**
	 * Build XML template
	 *
	 * @since 2.0.0
	 * @access public
	 * @return string
	 */
    public function build_xml(){
        
        $xml =new XMLWriter();
        $xml->openMemory();
        $xml->startElement("fulfillment");
            $xml->writeAttribute("blocking", "true");
            $xml->writeAttribute("version", "1.0");
        $xml->startElement("authentication");
            $xml->startElement("username");
            $xml->text($this->map_data["auth_email"]);
            $xml->endElement();
            $xml->startElement("password");
            $xml->text($this->map_data["auth_password"]);
            $xml->endElement();
        $xml->endElement();
        $xml->startElement("grant");
            $xml->writeAttribute("sendEmail", "true");
            $xml->writeAttribute("emailSubject", "New Order");
            $xml->writeAttribute("emailSender", "noreply@imirus.com");
            $xml->writeAttribute("emailTemplate", $this->map_data["template"]);
            $xml->writeAttribute("mode", "inclusive");
            $xml->writeAttribute("create", "true");
            $xml->writeAttribute("emailMode", "all");
            $xml->writeAttribute("modify", "false");
            $xml->startElement("subscription");
                $xml->writeAttribute("id", $this->map_data["product"]);
                $xml->writeAttribute("assignCurrentIssue", "true");
            $xml->endElement();
            $xml->startElement("user");
                $xml->writeAttribute("email", $this->map_data["new_customer_email"]);
            $xml->endElement();
            $xml->endElement();
            $xml->endElement(); 
            $xml->endElement();
            $data = $xml->outputMemory(true);
            $xml->flush();
        
        $this->xml_data = $data;
    }

   /**
	 * get XML
	 *
	 * @since 2.0.0
	 * @access public
	 * @return string
	 */

    public function get_xml()
    {
        if($this->xml_data)
            return $this->xml_data;
        else
            return false;
    }
        
}