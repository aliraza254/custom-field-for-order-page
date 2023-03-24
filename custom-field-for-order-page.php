<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://#
 * @since             1.0.0
 * @package           Custom_Field_For_Order_Page
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Field For Order Page
 * Plugin URI:        https://#
 * Description:       Custom Field for WooCommerce Order Detail Page.
 * Version:           1.0.0
 * Author:            Sahib Bilal
 * Author URI:        https://#
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-field-for-order-page
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_FIELD_FOR_ORDER_PAGE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-field-for-order-page-activator.php
 */
function activate_custom_field_for_order_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-field-for-order-page-activator.php';
	Custom_Field_For_Order_Page_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-field-for-order-page-deactivator.php
 */
function deactivate_custom_field_for_order_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-field-for-order-page-deactivator.php';
	Custom_Field_For_Order_Page_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_field_for_order_page' );
register_deactivation_hook( __FILE__, 'deactivate_custom_field_for_order_page' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-field-for-order-page.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_field_for_order_page() {

	$plugin = new Custom_Field_For_Order_Page();
	$plugin->run();

}
run_custom_field_for_order_page();
