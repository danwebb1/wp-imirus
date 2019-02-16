<?php
/**
 * This plugin class is used to install database table for debgging
 * 
 */
class WP_Imirus_Install {

    protected static $instance;


    public static function init()
    {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    
    /**
	 * Install plugin data models
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    public static function on_activation(){
        if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) and current_user_can( 'activate_plugins' ) ) {
            // Stop activation redirect and show error
            wp_die('Sorry, but this plugin requires the WooCommerce to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
        }
        self::install_db();
    }

    /**
	 * method to install databse tables
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    public static function install_db()
    {
	    global $wpdb;

        $table_name = $wpdb->prefix . 'imirus_log';
    
        $charset_collate = $wpdb->get_charset_collate();
    
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            ID int(5) NOT NULL AUTO_INCREMENT,
            Date_time varchar(55) DEFAULT '' NOT NULL,
            XML_SENT varchar(500) DEFAULT '' NOT NULL,
            Response varchar(200) DEFAULT '' NOT NULL,
            PRIMARY KEY id (id)
          ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta( $sql );
        add_option('WP_imirus_db_version', $WP_imirus_db_version);
    
      
    }

    /**
	 * Uninstall plugin data models
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
    public static function on_uninstall()
    {
	global $wpdb;
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        check_admin_referer( 'bulk-plugins' );

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
            return;

            $table_name = $wpdb->prefix . 'imirus_log';

            $charset_collate = $wpdb->get_charset_collate();
            
            $sql = "DROP TABLE $table_name;";
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
    }


}