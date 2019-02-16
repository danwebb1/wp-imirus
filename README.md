# WP_Imirus_Integration
Wordpress plugin to integrate WooCommerce with iMirus publishing web service

REQUIREMENTS:
-Wordpress version 4.5 or newer
-WooCommerce 2.5.5 or newer

INSTALLATION:
Upload 'wp_imirus' to the '/wp-content/plugins/' directory
Activate the plugin through the 'Plugins' menu in WordPress
Click on the  menu item "Settings" and find 'WP iMirus Settings' submenu item
Enter your iMirus web service credentials and click Save

HOW IT WORKS:
A custom field has been added to all Woocommerce product posts. Enter the iMirus product ID associated with the woocommerce product in your store
When customer's purchase a product the plugin checks for the product code. If it is an iMirus product the plugin will send the appropriate
XML data to the iMirus webservice allowing your customers to access their digital product through the iMirus system. 

NOTE: In the plugin settings page (Settings->WP iMirus) you will need to provide you iMirus API authorization credentials as well as the URL for the HTML template used in the email. (See iMirus API documentation)

