<?php
/**
 * This class gets imirus api credentials from wp_options table
 */
class WP_Imirus_API_Helper {
    /**
	 * api credentials email
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
    public $AUTH_email;
    /**
	 * api credentials password
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
    public$AUTH_password;

    /**
	 * email template for api to use
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
    public $template;

    /**
	 * Plugin admin options
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
    public $options;

    public function __construct( $options ) 
    {
        $this->options = $options;

    }

    /**
	 * get imirus authorization email
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function get_auth_email()
    {
        if(isset($this->options['WP_imirus_email']) && $this->options['WP_imirus_email'] != '')
            $this->AUTH_email = $this->options['WP_imirus_email'];

        return $this->AUTH_email;
            
    }

    /**
	 * get imirus authorization password
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function get_auth_password()
    {
        if(isset($this->options['WP_imirus_password']) && $this->options['WP_imirus_password'] != '')
            $this->AUTH_password = $this->options['WP_imirus_password'];
            
        return $this->AUTH_password;
    }

    /**
	 * get imirus email template URL
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function get_template()
    {
        if(isset($this->options['WP_imirus_template']) && $this->options['WP_imirus_template'] != '')
            $this->template = $this->options['WP_imirus_template'];
        
        return $this->template;
            
        
    }

    

}