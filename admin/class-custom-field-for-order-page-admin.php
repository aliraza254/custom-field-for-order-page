<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Field_For_Order_Page
 * @subpackage Custom_Field_For_Order_Page/admin
 * @author     Sahib Bilal <itsbilalmahmood@gmail.com>
 */
class Custom_Field_For_Order_Page_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-field-for-order-page-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-field-for-order-page-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Get custom field data for the provided order ID
     *
     * @param WP_REST_Request $request REST request object
     *
     * @return array Custom field data
     */
    public function get_custom_field_data( $request ) {
        $order_id = $request['id'];
        $selected_options = get_post_meta( $order_id, 'custom_field', true );

        $options_data = array();
        foreach ( $selected_options as $option ) {
            switch ( $option ) {
                case 'line':
                    $options_data[] = array(
                        'name' => 'Line',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/linee.png',
                    );
                    break;
                case 'shopee':
                    $options_data[] = array(
                        'name' => 'Shopee',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/shopee.png',
                    );
                    break;
                case 'lazada':
                    $options_data[] = array(
                        'name' => 'Lazada',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/lazada.svg',
                    );
                    break;
                case 'website':
                    $options_data[] = array(
                        'name' => 'Website',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/website.png',
                    );
                    break;
                case 'instagram':
                    $options_data[] = array(
                        'name' => 'Instagram',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/instagram.webp',
                    );
                    break;
                case 'tiktok':
                    $options_data[] = array(
                        'name' => 'Tiktok',
                        'logo_url' => plugin_dir_url( __FILE__ ) . 'assets/images/tiktok.webp',
                    );
                    break;
            }
        }


        return $options_data;
    }

    /**
     * Register custom field API endpoint
     */
    public function custom_field_api() {
        register_rest_route( 'custom-field/v1', '/order/(?P<id>\d+)/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_custom_field_data'),
            'args' => array(
                'id' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                ),
            ),
        ) );
    }

    /**
     * Add custom field data to REST API response for orders
     *
     * @param array           $response REST API response
     * @param WC_Order        $order    Order object
     * @param WP_REST_Request $request  REST request object
     *
     * @return array Modified REST API response
     */
    public function add_custom_field_to_rest_api_response( $response, $order, $request ) {
        $response->data['custom_field'] = get_post_meta( $order->get_id(), 'custom_field', true );
        return $response;
    }


    /**
     * Register the CustomField for the admin area.
     *
     * @since    1.0.0
     */
    public function add_custom_field_to_order_admin( $order ) {
        $field_id = 'custom_field';
        $value = $order->get_meta( $field_id );
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
        <p class="form-field form-field-wide custom-field">
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
     * Save the CustomField for the admin area.
     *
     * @since    1.0.0
     */
    public function save_custom_field_to_order( $order_id )
    {
        $field_id = 'custom_field';
        if (isset($_POST[$field_id])) {
            $field_value = array_map( 'sanitize_text_field', $_POST[$field_id] );
            update_post_meta($order_id, $field_id, $field_value);
        }
    }

    /**
     * Admin Footer Function for the admin area.
     *
     * @since    1.0.0
     */
    public function admin_footer_function()
    {
        ?>
        <script>
            jQuery(document).ready(function($) {

                $('#custom_field').select2();

                var imageContainer = $('#selected-image-container');
                var imageUrls = {
                    'line': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/linee.png'],
                    'shopee': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/shopee.png'],
                    'lazada': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/lazada.svg'],
                    'website': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/website.png'],
                    'instagram': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/instagram.webp'],
                    'tiktok': ['<?php echo plugin_dir_url( __FILE__ ) ?>/assets/images/tiktok.webp'],
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
