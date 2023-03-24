<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/includes
 * @author     Sahib Bilal <itsbilalmahmood@gmail.com>
 */
class Custom_Field_For_Order_Page_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-field-for-order-page',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
