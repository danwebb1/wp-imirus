<?php
/**
 * This plugin class is used to create pages in the admin dashboard
 * which list recent posts according to their appropriate taxonomies 
 */
class WP_Imirus_Public_Admin {
	/**
	 * The string used to uniquely identify this plugin
	 * Set in WP_Imirus_Public_Admin 
	 * Used here for admin page url slug base
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_name;
	/**
	 *
	 * Set the plugin name for admin page slug base
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;
	}
	/**
	 * Register the actions and filters
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function create_admin_options() {
        add_action( 'admin_menu', array( $this, 'WP_imirus_admin_menu' ), 10, 0 );
        add_action( 'admin_init', array( $this, 'WP_imirus_register_settings'), 10, 0 );
        add_action( 'admin_notices', array( $this, 'WP_imirus_admin_notices'), 10, 0);

	}
	/**
	 * Create admin dashboard subpages
	 *
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */

     
	public function WP_imirus_admin_menu() {
			
            //set the method to add Admin Page 
            add_options_page( 'iMirus Settings', 'WP iMirus', 'manage_options', $this->plugin_name, array( $this, 'wp_imirus_options') );
    }
    
    /**
	 * Register settings
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    	public function WP_imirus_register_settings(){
        register_setting('WP_imirus_settings', 'WP_imirus_settings', array( $this, 'WP_imirus_settings_validate') );
    }

    /**
	 * Validate user entries
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function WP_imirus_settings_validate($args){
        if(!isset($args['WP_imirus_email']) || !is_email($args['WP_imirus_email'])){
            $args['wpse61431_email'] = '';
                   add_settings_error('WP_imirus_settings', 'WP_imirus_invalid_email', 'Please enter a valid email!', $type = 'error');   
        }
        return $args;
    }
    /**
	 * Validate user entries
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */

    public function WP_imirus_admin_notices(){
        settings_errors();
     }

	/**
	 * function to render admin dashboard pages
	 *
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
    public function wp_imirus_options(){

        if ( !current_user_can( 'manage_options' ) )  {//check if user has admin privileges
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        ?>
        <div class="wrap">
                <h1>WP iMirus Settings</h1>
            <strong>Enter your credentials for sending WooCommerce customer purchase data to iMirus</strong>
                <form method="post" action="options.php"> 
                        <?php settings_fields( 'WP_imirus_settings' );
                            do_settings_sections( __FILE__ );
                                                    $options = get_option( 'WP_imirus_settings' ); ?>
                                            <table class="form-table">
                                                <tr>
                                                <th scope="row">Email</th>
                                                    <td>
                                                    <fieldset>
                                                    <label>
                                                        <input name="WP_imirus_settings[WP_imirus_email]" type="text" id="WP_imirus_email" value="<?php echo (isset($options['WP_imirus_email']) && $options['WP_imirus_email'] != '') ? $options['WP_imirus_email'] : ''; ?>"/>
                                                        <br />
                                                        <span class="description">Please enter the authorization email for your <a href="http://www.imirus.com">iMirus account</a>.</span>
                                                    </label>
                                                    </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Password</th>
                                                    <td>
                                                    <fieldset>
                                                    <label>
                                                        <input name="WP_imirus_settings[WP_imirus_password]" type="password" id="WP_imirus_password" value="<?php echo (isset($options['WP_imirus_password']) && $options['WP_imirus_password'] != '') ? $options['WP_imirus_password'] : ''; ?>"/>
                                                    </label>
                                                    </fieldset>
                                                    </td>
                                                </tr>
												<th scope="row">Template URL</th>
                                                    <td>
                                                    <fieldset>
                                                    <label>
                                                        <input name="WP_imirus_settings[WP_imirus_template]" type="text" id="WP_imirus_template" value="<?php echo (isset($options['WP_imirus_template']) && $options['WP_imirus_template'] != '') ? $options['WP_imirus_template'] : ''; ?>"/>
                                                    </label>
                                                    </fieldset>
                                                    </td>
                                                </tr>
                                                </table>
                                            <input type="submit" value="Save" />
                                            </form>
        </div>

        <?php


    }
}