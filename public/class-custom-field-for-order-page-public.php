<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/public
 * @author     Sahib Bilal <itsbilalmahmood@gmail.com>
 */
class Custom_Field_For_Order_Page_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Field_For_Order_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Field_For_Order_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-field-for-order-page-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Field_For_Order_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Field_For_Order_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-field-for-order-page-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the CustomField for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function add_custom_field_to_checkout( $checkout ) {
        $options = array(
            '' => 'Select Option',
            'line' => 'Line',
            'shopee' => 'Shopee',
            'lazada' => 'Lazada',
            'website' => 'Website',
            'instagram' => 'Instagram',
            'tiktok' => 'Tiktok'
        );
        ?>
        <p class="form-row form-row-wide">
            <label for="custom_field"><?php _e( 'Custom Field', 'custom-woo-field' ); ?></label>
            <select id="custom_field" name="custom_field[]" multiple>
                <?php foreach ( $options as $key => $label ) : ?>
                    <option value="<?php echo $key; ?>" <?php selected( !empty($value) && in_array( $key, $value ) ); ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <div id="selected-image-container" style="align-items: center; flex-wrap: wrap; clear: both; display: flex;"></div>
        <?php
    }

    /**
     * Save the CustomField Values for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function save_custom_field_to_order_meta_data( $order ) {
        $custom_field_value = isset( $_POST['custom_field'] ) ? $_POST['custom_field'] : '';
        $order->update_meta_data( 'custom_field', $custom_field_value );
    }

    /**
     * Wp Footer Function for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function wp_footer_function()
    {
        ?>
        <script>
            jQuery(document).ready(function($) {

                $('#custom_field').select2();

                document.addEventListener( 'DOMContentLoaded', function() {
                    var select = document.getElementById( 'custom_field' );
                    select.setAttribute( 'required', 'required' );
                }, false );

                var imageContainer = $('#selected-image-container');
                var imageUrls = {
                    'line': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/linee.png'],
                    'shopee': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/shopee.png'],
                    'lazada': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/lazada.svg'],
                    'website': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/website.png'],
                    'instagram': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/instagram.webp'],
                    'tiktok': ['<?php echo plugin_dir_url( __FILE__ ) ?>//assets/images/tiktok.webp'],
                };

                $('select[name="custom_field[]"]').on('change', function() {
                    var selectedOptions = $(this).val() || [];
                    imageContainer.empty();

                    for (var i = 0; i < selectedOptions.length; i++) {
                        var optionValue = selectedOptions[i];
                        var imageUrlsForOption = imageUrls[optionValue] || [];

                        for (var j = 0; j < imageUrlsForOption.length; j++) {
                            var imageUrl = imageUrlsForOption[j];
                            var imgElement = $('<img style="width: 60px">').attr('src', imageUrl);
                            imageContainer.append(imgElement);
                        }
                    }
                });
            });
        </script>
        <?php
    }

}
