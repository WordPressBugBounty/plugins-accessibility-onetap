<?php
/**
 * Accessibility Settings Option for Onetap.
 *
 * @link       https://wponetap.com
 * @since      1.0.0
 *
 * @package    Accessibility_Onetap_Settings_Options
 * @subpackage Accessibility_Onetap_Settings_Options/admin
 */

/**
 * Accessibility Settings Option for Onetap.
 *
 * Handles the settings related to accessibility in the Onetap Pro plugin.
 *
 * @package    Accessibility_Onetap_Settings_Options
 * @subpackage Accessibility_Onetap_Settings_Options/admin
 * @author     OneTap <support@wponetap.com>
 */
class Accessibility_Onetap_Settings_Options {

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
	 * Settings api.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_api    The options of this plugin.
	 */
	private $settings_api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name      The name of this plugin.
	 * @param      string $version          The version of this plugin.
	 * @param      object $settings_manager The settings manager of this plugin.
	 */
	public function __construct( $plugin_name, $version, $settings_manager ) {

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		$this->settings_api = $settings_manager;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook The current admin page hook suffix passed by WordPress.
	 */
	public function enqueue_styles( $hook ) {

		// Check if the current admin page is one of the plugin's main pages.
		if ( 'toplevel_page_accessibility-onetap-settings' === $hook ||
			'onetap_page_accessibility-onetap-general-settings' === $hook ||
			'onetap_page_accessibility-onetap-alt-text' === $hook ||
			'onetap_page_accessibility-onetap-modules' === $hook ||
			'admin_page_onetap-module-labels' === $hook ||
			'onetap_page_accessibility-onetap-accessibility-status' === $hook
		) {

			wp_enqueue_style( $this->plugin_name . '-admin', ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/css/accessibility-onetap-admin-menu.min.css', array(), $this->version, 'all' );

		}

		// Always enqueue the global admin stylesheet for the plugin.
		wp_enqueue_style( $this->plugin_name . '-admin-global', ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/css/admin-global.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Registers the top-level admin menu page and adds a submenu page for 'OneTap'.
	 *
	 * This function uses the WordPress add_menu_page() and add_submenu_page() functions to create
	 * the necessary admin menu structure. It also sets up the callback functions for
	 * the top-level and submenu pages.
	 *
	 * @return void
	 */
	public function register_admin_menu_page() {
		add_menu_page(
			__( 'OneTap', 'accessibility-onetap' ), // Page title.
			__( 'OneTap', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-settings', // Menu slug.
			array( $this, 'callback_template_for_settings' ), // Callback function.
			ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/menu.svg', // URL icon SVG.
			30 // $position.
		);

		add_submenu_page(
			'accessibility-onetap-settings', // Parent menu slug.
			__( 'Widget', 'accessibility-onetap' ), // Page title.
			__( 'Widget', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-settings', // Menu slug.
			array( $this, 'callback_template_for_settings' ) // Callback function.
		);

		add_submenu_page(
			'accessibility-onetap-settings', // Parent menu slug.
			__( 'Modules', 'accessibility-onetap' ), // Page title.
			__( 'Modules', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-modules', // Menu slug.
			array( $this, 'callback_template_for_modules' ) // Callback function.
		);

		add_submenu_page(
			'accessibility-onetap-settings', // Parent menu slug.
			__( 'Statement', 'accessibility-onetap' ), // Page title.
			__( 'Statement', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-accessibility-status', // Menu slug.
			array( $this, 'callback_template_for_accessibility_status' ) // Callback function.
		);

		add_submenu_page(
			'accessibility-onetap-settings', // Parent menu slug.
			__( 'Settings', 'accessibility-onetap' ), // Page title.
			__( 'Settings', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-general-settings', // Menu slug.
			array( $this, 'callback_template_for_general_settings' ) // Callback function.
		);

		add_submenu_page(
			null, // Parent menu slug.
			__( 'Module Labels', 'accessibility-onetap' ), // Page title.
			__( 'Module Labels', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'onetap-module-labels', // Menu slug.
			array( $this, 'callback_template_for_module_labels' ) // Callback function.
		);

		add_submenu_page(
			'accessibility-onetap-settings', // Parent menu slug.
			__( 'Get PRO', 'accessibility-onetap' ), // Page title.
			__( 'Get PRO', 'accessibility-onetap' ), // Menu title.
			'manage_options', // Capability required.
			'accessibility-onetap-pro', // Menu slug.
			array( $this, 'callback_template_for_ge_pro' ) // Callback function.
		);
	}

	/**
	 * Loads the template for the 'Settings' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_settings() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/settings.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Modules' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_modules() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/modules.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Accessibility Status' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_accessibility_status() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/accessibility-status.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Alt Text' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_alt_text() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/alt-text.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Genearl Settings' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_general_settings() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/general-settings.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Module Labels' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_module_labels() {
		// Define the path to the template file.
		$template_path = plugin_dir_path( __FILE__ ) . 'partials/module-labels.php';

		// Check if the template file exists.
		if ( file_exists( $template_path ) ) {
			// Include the template file if it exists.
			include $template_path;
		}
	}

	/**
	 * Loads the template for the 'Get PRO' menu page in the plugin.
	 *
	 * This function constructs the path to the template file located
	 * in the plugin directory and includes it if it exists.
	 */
	public function callback_template_for_ge_pro() {
		echo '<div class="wrap"></div>';
	}

	/**
	 * Remove notifications.
	 */
	public function hide_notifications_for_onetap_page() {

		global $plugin_page;

		if (
			( is_admin() && get_admin_page_parent() === 'accessibility-onetap-settings' ) || 'accessibility-onetap-modules' === $plugin_page ||
			'accessibility-onetap-accessibility-status' === $plugin_page ||
			'accessibility-onetap-alt-text' === $plugin_page ||
			'accessibility-onetap-general-settings' === $plugin_page ||
			'onetap-module-labels' === $plugin_page
		) {
			remove_all_actions( 'admin_notices' );
		}
	}

	/**
	 * Initialize the admin settings.
	 *
	 * This method sets the sections and fields for the settings API and initializes them.
	 *
	 * @return void
	 */
	public function admin_init() {

		// Set the settings api.
		$this->settings_api->set_sections( $this->get_settings_api_sections() );
		$this->settings_api->set_fields( $this->get_settings_api_fields() );

		// Initialize settings api.
		$this->settings_api->admin_init();
	}

	/**
	 * Retrieve the settings sections for the plugin.
	 *
	 * This method returns an array of sections used in the settings API.
	 * Each section contains an ID and a title.
	 *
	 * @return array The array of settings sections.
	 */
	public function get_settings_api_sections() {
		$sections = array(
			array(
				'id'    => 'onetap_settings',
				'title' => __( 'Settings', 'accessibility-onetap' ),
			),
			array(
				'id'    => 'onetap_general_settings',
				'title' => __( 'General settings', 'accessibility-onetap' ),
			),
			array(
				'id'    => 'onetap_modules',
				'title' => __( 'Modules', 'accessibility-onetap' ),
			),
			array(
				'id'    => 'onetap_module_labels',
				'title' => __( 'Module Labels', 'accessibility-onetap' ),
			),
			array(
				'id'    => 'onetap_alt_text',
				'title' => __( 'Alt Text', 'accessibility-onetap' ),
			),
		);
		return $sections;
	}

	/**
	 * Sanitize and validate the license key.
	 *
	 * This function takes a new license key as input, checks if it differs from
	 * the old license key stored in the database. If the keys are different, it
	 * deletes the old license key option, indicating that the plugin needs to
	 * be reactivated with the new license.
	 *
	 * @param string $value The new license key to be sanitized.
	 * @return string The sanitized license key.
	 */
	public function sanitize_license( $value ) {
		// Retrieve the old license key from the database.
		$old = Accessibility_Onetap_Config::get_setting( 'license' );

		// Check if an old license key exists and if it differs from the new one.
		if ( $old && $old !== $value ) {
			// Delete the old license setting to force reactivation.
			delete_option( 'onetap_settings' )['license'];
		}

		// Sanitize the new license key before returning it.
		return sanitize_text_field( $value );
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public function get_settings_api_fields() {
		$settings_fields = array(
			'onetap_settings'         => array(
				array(
					'callback'                 => 'callback_template_radio_image',
					'default'                  => Accessibility_Onetap_Config::get_setting( 'icons' ),
					'first_control'            => true,
					'label'                    => __( 'Icons', 'accessibility-onetap' ),
					'name'                     => 'icons',
					'radio_image_list'         => array(
						'design1' => 'Original_Logo_Icon.svg',
						'design2' => 'Hand_Icon.svg',
						'design3' => 'Accessibility-Man-Icon.svg',
						'design4' => 'Settings-Filter-Icon.svg',
						'design5' => 'Switcher-Icon.svg',
						'design6' => 'Eye-Show-Icon.svg',
					),
					'sanitize_callback'        => 'sanitize_text_field',
					'setting_description'      => __( "Customize your accessibility button's color, icon, and size to match your brand.", 'accessibility-onetap' ) . ' <a href="https://wponetap.com/tutorial/customize-the-toolbar-icon/" target="_blank">' . __( 'See Documentation', 'accessibility-onetap' ) . '</a>',
					'hide_setting_description' => true,
					'setting_title'            => __( 'Widget Design', 'accessibility-onetap' ),
					'show_save_button'         => false,
					'type'                     => 'radio-image',
				),
				array(
					'callback'          => 'callback_template_radio_image',
					'default'           => Accessibility_Onetap_Config::get_setting( 'size' ),
					'first_control'     => false,
					'label'             => __( 'Icon Size', 'accessibility-onetap' ),
					'name'              => 'size',
					'radio_image_list'  => array(
						'design-size1' => 'Original_Logo_Icon_Size1.svg',
						'design-size2' => 'Original_Logo_Icon_Size2.svg',
						'design-size3' => 'Original_Logo_Icon_Size3.svg',
					),
					'sanitize_callback' => 'sanitize_text_field',
					'show_save_button'  => false,
					'type'              => 'radio-image',
				),
				array(
					'callback'          => 'callback_template_radio_image',
					'default'           => Accessibility_Onetap_Config::get_setting( 'border' ),
					'first_control'     => false,
					'last_control'      => true,
					'label'             => __( 'Add Border', 'accessibility-onetap' ),
					'name'              => 'border',
					'radio_image_list'  => array(
						'design-border1' => 'Original_Logo_Icon.svg',
						'design-border2' => 'Original_Logo_Icon.svg',
					),
					'sanitize_callback' => 'sanitize_text_field',
					'show_save_button'  => false,
					'type'              => 'radio-image',
				),
				array(
					'callback'            => 'callback_template_color',
					'color_list'          => array(
						'#535862',
						'#099250',
						'#1570ef',
						'#444ce7',
						'#6938ef',
						'#ba24d5',
						'#dd2590',
						'#e04f16',
					),
					'default'             => Accessibility_Onetap_Config::get_setting( 'color' ),
					'first_control'       => true,
					'last_control'        => true,
					'name'                => 'color',
					'sanitize_callback'   => 'sanitize_hex_color',
					'setting_description' => __( "Set your own branding colors to personalize the plugin's appearance.", 'accessibility-onetap' ) . ' <a href="https://wponetap.com/contrast-checker/" target="_blank">' . __( 'Free WCAG Contrast-Checker', 'accessibility-onetap' ) . '</a>',
					'setting_title'       => __( 'Widget Color', 'accessibility-onetap' ),
					'show_save_button'    => false,
					'type'                => 'color',
				),
				array(
					'callback'                 => 'callback_template_devices_tabs',
					'default'                  => false,
					'first_control'            => true,
					'last_control'             => false,
					'name'                     => 'device-positions',
					'sanitize_callback'        => 'sanitize_text_field',
					'setting_description'      => __( 'Adjust the position of widgets to fit your layout preferences.', 'accessibility-onetap' ) . ' <a href="https://wponetap.com/position/" target="_blank">' . __( 'See Documentation', 'accessibility-onetap' ) . '</a>',
					'hide_setting_description' => true,
					'setting_title'            => __( 'Widget Position ', 'accessibility-onetap' ),
					'show_save_button'         => false,
					'type'                     => 'devices-tabs',
				),
				array(
					'name'              => 'widge-position',
					'label'             => __( 'Widget Position', 'accessibility-onetap' ),
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'desktop',
					'type'              => 'select',
					'callback'          => 'callback_template_select',
					'default'           => Accessibility_Onetap_Config::get_setting( 'widget_position' ),
					'sanitize_callback' => 'sanitize_text_field',
					'select_options'    => array(
						'middle-right' => __( 'Middle right', 'accessibility-onetap' ),
						'middle-left'  => __( 'Middle left', 'accessibility-onetap' ),
						'bottom-right' => __( 'Bottom right', 'accessibility-onetap' ),
						'bottom-left'  => __( 'Bottom left', 'accessibility-onetap' ),
						'top-right'    => __( 'Top right', 'accessibility-onetap' ),
						'top-left'     => __( 'Top left', 'accessibility-onetap' ),
					),
				),
				array(
					'name'              => 'position-top-bottom',
					'label'             => __( 'Vertical (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'desktop',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_top_bottom' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'position-left-right',
					'label'             => __( 'Horizontal (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'desktop',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_left_right' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'widge-position-tablet',
					'label'             => __( 'Widget Position', 'accessibility-onetap' ),
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'tablet',
					'type'              => 'select',
					'callback'          => 'callback_template_select',
					'default'           => Accessibility_Onetap_Config::get_setting( 'widget_position_tablet' ),
					'sanitize_callback' => 'sanitize_text_field',
					'select_options'    => array(
						'middle-right' => __( 'Middle right', 'accessibility-onetap' ),
						'middle-left'  => __( 'Middle left', 'accessibility-onetap' ),
						'bottom-right' => __( 'Bottom right', 'accessibility-onetap' ),
						'bottom-left'  => __( 'Bottom left', 'accessibility-onetap' ),
						'top-right'    => __( 'Top right', 'accessibility-onetap' ),
						'top-left'     => __( 'Top left', 'accessibility-onetap' ),
					),
				),
				array(
					'name'              => 'position-top-bottom-tablet',
					'label'             => __( 'Vertical (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'tablet',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_top_bottom_tablet' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'position-left-right-tablet',
					'label'             => __( 'Horizontal (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'tablet',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_left_right_tablet' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'widge-position-mobile',
					'label'             => __( 'Widget Position', 'accessibility-onetap' ),
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'mobile',
					'type'              => 'select',
					'callback'          => 'callback_template_select',
					'default'           => Accessibility_Onetap_Config::get_setting( 'widget_position_mobile' ),
					'sanitize_callback' => 'sanitize_text_field',
					'select_options'    => array(
						'middle-right' => __( 'Middle right', 'accessibility-onetap' ),
						'middle-left'  => __( 'Middle left', 'accessibility-onetap' ),
						'bottom-right' => __( 'Bottom right', 'accessibility-onetap' ),
						'bottom-left'  => __( 'Bottom left', 'accessibility-onetap' ),
						'top-right'    => __( 'Top right', 'accessibility-onetap' ),
						'top-left'     => __( 'Top left', 'accessibility-onetap' ),
					),
				),
				array(
					'name'              => 'position-top-bottom-mobile',
					'label'             => __( 'Vertical (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'mobile',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_top_bottom_mobile' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'position-left-right-mobile',
					'label'             => __( 'Horizontal (Default 20px)', 'accessibility-onetap' ),
					'min'               => 1,
					'max'               => 350,
					'step'              => 1,
					'units'             => 'px',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'device_visibility' => 'mobile',
					'type'              => 'number-slider',
					'callback'          => 'callback_template_number_slider',
					'default'           => Accessibility_Onetap_Config::get_setting( 'position_left_right_mobile' ),
					'sanitize_callback' => 'absint',
				),
				array(
					'name'              => 'divider',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'divider',
					'callback'          => 'callback_template_divider',
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'              => 'toggle-device-position-desktop',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'device_visibility' => 'desktop',
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/hide-powered-by-onetap.svg',
					'is_pro'            => false,
					'feature_name'      => __( 'Hide On Desktop', 'accessibility-onetap' ),
					'feature_desc'      => __( 'When enabled, the icon will not be displayed on desktop devices.', 'accessibility-onetap' ),
					'switch_style'      => 'switch2',
					'default'           => Accessibility_Onetap_Config::get_setting( 'hide_on_desktop' ),
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'              => 'toggle-device-position-tablet',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'device_visibility' => 'tablet',
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/hide-powered-by-onetap.svg',
					'is_pro'            => false,
					'feature_name'      => __( 'Hide On Tablet', 'accessibility-onetap' ),
					'feature_desc'      => __( 'When enabled, the icon will not be displayed on tablet devices.', 'accessibility-onetap' ),
					'switch_style'      => 'switch2',
					'default'           => Accessibility_Onetap_Config::get_setting( 'hide_on_tablet' ),
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'              => 'toggle-device-position-mobile',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'device_visibility' => 'mobile',
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/hide-powered-by-onetap.svg',
					'is_pro'            => false,
					'feature_name'      => __( 'Hide On Mobile', 'accessibility-onetap' ),
					'feature_desc'      => __( 'When enabled, the icon will not be displayed on mobile devices.', 'accessibility-onetap' ),
					'switch_style'      => 'switch2',
					'default'           => Accessibility_Onetap_Config::get_setting( 'hide_on_mobile' ),
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'                     => 'language',
					'setting_title'            => __( 'Default Language', 'accessibility-onetap' ),
					'setting_description'      => __( "Choose your preferred language for the plugin's interface.", 'accessibility-onetap' ) . ' <a href="https://wponetap.com/language-options/" target="_blank">' . __( 'See Documentation', 'accessibility-onetap' ) . '</a>',
					'hide_setting_description' => true,
					'first_control'            => true,
					'last_control'             => true,
					'show_save_button'         => false,
					'type'                     => 'select',
					'callback'                 => 'callback_template_select',
					'default'                  => Accessibility_Onetap_Config::get_setting( 'language' ),
					'sanitize_callback'        => 'sanitize_text_field',
					'select_options'           => array(
						'en'    => __( 'English', 'accessibility-onetap' ),
						'de'    => __( 'Deutsch', 'accessibility-onetap' ),
						'es'    => __( 'Español', 'accessibility-onetap' ),
						'fr'    => __( 'Français', 'accessibility-onetap' ),
						'it'    => __( 'Italiano', 'accessibility-onetap' ),
						'pl'    => __( 'Polski', 'accessibility-onetap' ),
						'se'    => __( 'Svenska', 'accessibility-onetap' ),
						'fi'    => __( 'Suomi', 'accessibility-onetap' ),
						'pt'    => __( 'Português', 'accessibility-onetap' ),
						'ro'    => __( 'Română', 'accessibility-onetap' ),
						'si'    => __( 'Slovenščina', 'accessibility-onetap' ),
						'sk'    => __( 'Slovenčina', 'accessibility-onetap' ),
						'nl'    => __( 'Nederlands', 'accessibility-onetap' ),
						'dk'    => __( 'Dansk', 'accessibility-onetap' ),
						'gr'    => __( 'Ελληνικά', 'accessibility-onetap' ),
						'cz'    => __( 'Čeština', 'accessibility-onetap' ),
						'hu'    => __( 'Magyar', 'accessibility-onetap' ),
						'lt'    => __( 'Lietuvių', 'accessibility-onetap' ),
						'lv'    => __( 'Latviešu', 'accessibility-onetap' ),
						'ee'    => __( 'Eesti', 'accessibility-onetap' ),
						'hr'    => __( 'Hrvatski', 'accessibility-onetap' ),
						'ie'    => __( 'Gaeilge', 'accessibility-onetap' ),
						'bg'    => __( 'Български', 'accessibility-onetap' ),
						'no'    => __( 'Norsk', 'accessibility-onetap' ),
						'tr'    => __( 'Türkçe', 'accessibility-onetap' ),
						'id'    => __( 'Bahasa Indonesia', 'accessibility-onetap' ),
						'pt-br' => __( 'Português (Brasil)', 'accessibility-onetap' ),
						'ja'    => __( '日本語', 'accessibility-onetap' ),
						'ko'    => __( '한국어', 'accessibility-onetap' ),
						'zh'    => __( '简体中文', 'accessibility-onetap' ),
						'ar'    => __( 'العربية', 'accessibility-onetap' ),
						'ru'    => __( 'Русский', 'accessibility-onetap' ),
						'hi'    => __( 'हिन्दी', 'accessibility-onetap' ),
						'uk'    => __( 'Українська', 'accessibility-onetap' ),
						'sr'    => __( 'Srpski', 'accessibility-onetap' ),
					),
					'select_badge'             => __( 'Default', 'accessibility-onetap' ),
				),
				array(
					'name'              => 'submit',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'submit',
					'callback'          => 'callback_template_save_changes',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
			'onetap_general_settings' => array(
				array(
					'name'              => 'hide_powered_by_onetap',
					'setting_title'     => __( 'General Settings', 'accessibility-onetap' ),
					'feature_name'      => __( 'Hide "Powered by OneTap"', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Remove the "Powered by OneTap" text from the Toolbar on the frontend of your website.', 'accessibility-onetap' ),
					'first_control'     => true,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_general_setting( 'hide_powered_by_onetap' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'open_with_url',
					'feature_name'      => __( 'Open with URL', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Open the OneTap Toolbar with URL', 'accessibility-onetap' ),
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'copy_text'         => '#onetap-toolbar',
					'copyable_style'    => 'style1',
					'type'              => 'copyable_text',
					'callback'          => 'callback_template_copyable_text',
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'              => 'edit-module-labels',
					'feature_name'      => __( 'Edit Module Labels', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Open the OneTap Toolbar with URL', 'accessibility-onetap' ),
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'button_text'       => __( 'Edit Labels', 'accessibility-onetap' ),
					'button_link'       => home_url( '/wp-admin/admin.php?page=onetap-module-labels' ),
					'feature_style'     => 'style1',
					'type'              => 'feature_card',
					'callback'          => 'callback_template_feature_card',
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'name'              => 'alt-text-ai',
					'setting_title'     => __( 'Alt-Text AI', 'accessibility-onetap' ),
					'feature_name'      => __( 'Generate Alt-Text with Ai', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Save hours, boost SEO & Accessibility', 'accessibility-onetap' ),
					'first_control'     => true,
					'last_control'      => true,
					'show_save_button'  => false,
					'button_text'       => __( 'Start with AltPilot.ai', 'accessibility-onetap' ),
					'button_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/logo-altpilot.svg',
					'button_link'       => 'https://www.altpilot.ai/',
					'feature_style'     => 'style1',
					'type'              => 'feature_card',
					'callback'          => 'callback_template_feature_card',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
			'onetap_modules'          => array(
				array(
					'name'              => 'accessibility-profiles',
					'setting_title'     => __( 'Accessibility Profiles', 'accessibility-onetap' ),
					'feature_name'      => __( 'Accessibility Profiles', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Ready-to-use accessibility profiles for different user needs.', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/accessibility-profiles.svg',
					'first_control'     => true,
					'last_control'      => true,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'accessibility_profiles' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'bigger-text',
					'setting_title'     => __( 'Content Modules', 'accessibility-onetap' ),
					'feature_name'      => __( 'Bigger Text', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Easily enlarge text for improved readability and accessibility for all', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/bigger-text.svg',
					'first_control'     => true,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'bigger_text' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'cursor',
					'feature_name'      => __( 'Cursor', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Enhance visibility with a larger cursor for easier navigation and control', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/cursor.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'cursor' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'line-height',
					'feature_name'      => __( 'Line Height', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Adjust line spacing for better readability and improved text clarity', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/line-height.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'line_height' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'letter-spacing',
					'feature_name'      => __( 'Letter Spacing', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Adjust letter spacing for improved readability', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/letter-spacing.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'letter_spacing' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'readable-font',
					'feature_name'      => __( 'Readable Font', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Switch to a clearer, easy-to-read font for improved text accessibility', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/readable-font.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'readable_font' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'dyslexic-font',
					'feature_name'      => __( 'Dyslexic Font', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Use a specialized font designed to enhance readability for dyslexic users', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/dyslexic-font.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'dyslexic_font' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'text-align',
					'feature_name'      => __( 'Text Align', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Adjust text alignment for improved structure and readability', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/text-align.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'text_align' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'text-magnifier',
					'feature_name'      => __( 'Text Magnifier', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Magnify selected text for enhanced readability and accessibility', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/text-magnifier.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'text_magnifier' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'highlight-links',
					'feature_name'      => __( 'Highlight Links', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Easily identify clickable links with visual enhancements for better navigation', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-links.svg',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'highlight_links' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'invert-colors',
					'setting_title'     => __( 'Color Modules', 'accessibility-onetap' ),
					'feature_name'      => __( 'Invert Colors', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Swap text and background colors for better contrast and readability', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/invert-colors.svg',
					'first_control'     => true,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'invert_colors' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'brightness',
					'feature_name'      => __( 'Brightness', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Adjust screen brightness to reduce glare and enhance text visibility', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/brightness.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'brightness' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'contrast',
					'feature_name'      => __( 'Contrast', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Fine-tune color contrast for clearer text and improved readability', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/contrast.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'contrast' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'grayscale',
					'feature_name'      => __( 'Grayscale', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Convert display to black and white for reduced visual clutter and better focus', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/grayscale.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'grayscale' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'saturnation',
					'feature_name'      => __( 'Saturation', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Adjust color saturation for a more vivid or subdued visual experience', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/saturation.svg',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'saturation' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'reading-line',
					'setting_title'     => __( 'Orientation Modules', 'accessibility-onetap' ),
					'feature_name'      => __( 'Reading Line', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Highlight the current line to track reading progress and improve focus', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/reading-line.svg',
					'first_control'     => true,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'reading_line' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'keyboard-navigation',
					'feature_name'      => __( 'Keyboard Navigation', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Navigate the site using only the keyboard', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/keyboard-navigation.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'keyboard_navigation' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'highlight-titles',
					'feature_name'      => __( 'Highlight Titles', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Highlight titles for better recognition', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-titles.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'highlight_titles' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'reading-mask',
					'feature_name'      => __( 'Reading Mask', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Use a mask to focus on a specific area of text and reduce distractions', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/reading-mask.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'reading_mask' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'hide-images',
					'feature_name'      => __( 'Hide Images', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Remove distracting images for a cleaner, more focused browsing experience', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/hide-images.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'hide_images' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'highlight-all',
					'feature_name'      => __( 'Highlight All', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Highlight elements when hovered over', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-all.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'highlight_all' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'read-page',
					'feature_name'      => __( 'Read Page', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Automatically read aloud the page content for hands-free accessibility', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/read-page.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'read_page' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'mute-sounds',
					'feature_name'      => __( 'Mute Sounds', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Easily mute website sounds for a distraction-free browsing experience', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/mute-sounds.svg',
					'first_control'     => false,
					'last_control'      => false,
					'show_save_button'  => false,
					'is_pro'            => true,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'mute_sounds' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
				array(
					'name'              => 'stop-animations',
					'feature_name'      => __( 'Stop Animations', 'accessibility-onetap' ),
					'feature_desc'      => __( 'Disable animations to reduce distractions', 'accessibility-onetap' ),
					'switch_icon'       => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/stop-animations.svg',
					'first_control'     => false,
					'last_control'      => true,
					'show_save_button'  => false,
					'type'              => 'switch',
					'callback'          => 'callback_template_switch',
					'default'           => Accessibility_Onetap_Config::get_module( 'stop_animations' ),
					'sanitize_callback' => 'sanitize_text_field',
					'switch_style'      => 'switch1',
				),
			),
			'onetap_module_labels'    => array(
				array(
					'name'                => 'bigger-text',
					'setting_title'       => __( 'Content Modules', 'accessibility-onetap' ),
					'feature_name'        => __( 'Bigger Text', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Easily enlarge text for improved readability and accessibility for all', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/bigger-text.svg',
					'first_control'       => true,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'cursor',
					'feature_name'        => __( 'Cursor', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Enhance visibility with a larger cursor for easier navigation and control', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/cursor.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'line-height',
					'feature_name'        => __( 'Line Height', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Adjust line spacing for better readability and improved text clarity', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/line-height.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'letter-spacing',
					'feature_name'        => __( 'Letter Spacing', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Adjust letter spacing for improved readability', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/letter-spacing.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'readable-font',
					'feature_name'        => __( 'Readable Font', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Switch to a clearer, easy-to-read font for improved text accessibility', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/readable-font.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'dyslexic-font',
					'feature_name'        => __( 'Dyslexic Font', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Use a specialized font designed to enhance readability for dyslexic users', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/dyslexic-font.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'text-align',
					'feature_name'        => __( 'Text Align', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Adjust text alignment for improved structure and readability', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/text-align.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'text-magnifier',
					'feature_name'        => __( 'Text Magnifier', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Magnify selected text for enhanced readability and accessibility', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/text-magnifier.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'highlight-links',
					'feature_name'        => __( 'Highlight Links', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Easily identify clickable links with visual enhancements for better navigation', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-links.svg',
					'first_control'       => false,
					'last_control'        => true,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'invert-colors',
					'setting_title'       => __( 'Color Modules', 'accessibility-onetap' ),
					'feature_name'        => __( 'Invert Colors', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Swap text and background colors for better contrast and readability', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/invert-colors.svg',
					'first_control'       => true,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'brightness',
					'feature_name'        => __( 'Brightness', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Adjust screen brightness to reduce glare and enhance text visibility', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/brightness.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'contrast',
					'feature_name'        => __( 'Contrast', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Fine-tune color contrast for clearer text and improved readability', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/contrast.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'grayscale',
					'feature_name'        => __( 'Grayscale', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Convert display to black and white for reduced visual clutter and better focus', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/grayscale.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'saturation',
					'feature_name'        => __( 'Saturation', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Adjust color saturation for a more vivid or subdued visual experience', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/saturation.svg',
					'first_control'       => false,
					'last_control'        => true,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'reading-line',
					'setting_title'       => __( 'Orientation Modules', 'accessibility-onetap' ),
					'feature_name'        => __( 'Reading Line', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Highlight the current line to track reading progress and improve focus', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/reading-line.svg',
					'first_control'       => true,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'keyboard-navigation',
					'feature_name'        => __( 'Keyboard Navigation', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Navigate the site using only the keyboard', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/keyboard-navigation.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'highlight-titles',
					'feature_name'        => __( 'Highlight Titles', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Highlight titles for better recognition', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-titles.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'reading-mask',
					'feature_name'        => __( 'Reading Mask', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Use a mask to focus on a specific area of text and reduce distractions', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/reading-mask.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'hide-images',
					'feature_name'        => __( 'Hide Images', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Remove distracting images for a cleaner, more focused browsing experience', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/hide-images.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'highlight-all',
					'feature_name'        => __( 'Highlight All', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Highlight elements when hovered over', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/highlight-all.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'read-page',
					'feature_name'        => __( 'Read Page', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Automatically read aloud the page content for hands-free accessibility', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/read-page.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'mute-sounds',
					'feature_name'        => __( 'Mute Sounds', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Easily mute website sounds for a distraction-free browsing experience', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/mute-sounds.svg',
					'first_control'       => false,
					'last_control'        => false,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
				array(
					'name'                => 'stop-animations',
					'feature_name'        => __( 'Stop Animations', 'accessibility-onetap' ),
					'feature_desc'        => __( 'Disable animations to reduce distractions', 'accessibility-onetap' ),
					'module_labels_icon'  => ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/stop-animations.svg',
					'first_control'       => false,
					'last_control'        => true,
					'show_save_button'    => false,
					'is_pro'              => true,
					'type'                => 'module-labels',
					'status'              => false,
					'callback'            => 'callback_template_module_labels',
					'default'             => '',
					'sanitize_callback'   => 'sanitize_text_field',
					'module_labels_style' => 'style1',
				),
			),
			'onetap_alt_text'         => array(
				array(
					'name'              => 'image_alt_text',
					'setting_title'     => __( 'Edit Alt Text', 'accessibility-onetap' ),
					'first_control'     => true,
					'last_control'      => true,
					'show_save_button'  => false,
					'type'              => 'alt-text',
					'callback'          => 'callback_template_image_alt_list',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		);

		return $settings_fields;
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	public function get_pages() {
		$pages         = get_pages();
		$pages_options = array();
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

	/**
	 * Handles the plugin updater functionality.
	 *
	 * This method checks if the current user has the appropriate capabilities
	 * or if the code is being run during a cron job for privileged users.
	 * It retrieves the license key from the database and initializes the
	 * plugin updater using the Easy Digital Downloads (EDD) updater class.
	 *
	 * @return void
	 */
	public function initialize_plugin_updater() {
		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;

		// Check if the current user has the capability to manage options or if this is a cron job.
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return; // Exit if the user does not have permission and it's not a cron job.
		}

		// Retrieve our settings from the DB.
		$settings = get_option( 'onetap_settings' );

		// Check if the settings are an array and contain the 'license' key.
		$license_key = '';
		if ( is_array( $settings ) && isset( $settings['license'] ) ) {
			$license_key = trim( $settings['license'] );
		}

		// Setup the updater.
		$edd_updater = new Onetap_Plugin_Updater(
			ACCESSIBILITY_PLUGIN_ONETAP_PRO_STORE_URL,
			__FILE__,
			array(
				'version' => ACCESSIBILITY_PLUGIN_ONETAP_PRO_VERSION, // Current version number.
				'license' => $license_key, // License key retrieved from the database.
				'item_id' => ACCESSIBILITY_PLUGIN_ONETAP_PRO_PRODUCT_ID, // ID of the product.
				'author'  => 'OneTap', // Author of this plugin.
				'beta'    => false, // Indicates whether this is a beta version.
			)
		);
	}

	/**
	 * Toggle the license activation state for the accessibility plugin.
	 *
	 * This function activates or deactivates the license based on the toggle
	 * setting in the plugin options. It communicates with the Easy Digital
	 * Downloads (EDD) server to update the license status.
	 *
	 * @return void
	 */
	public function toggle_license() {
		// Retrieve the plugin settings from the database.
		$settings = get_option( 'onetap_settings' );

		// Get the license key from the settings; trim any whitespace.
		$license = isset( $settings['license'] ) ? trim( $settings['license'] ) : '';

		// Check if the activation button was pressed.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['onetap_license_activate'] ) ) {
			// Set up API parameters for activating the license.
			$api_params = $this->prepare_api_params( 'activate_license', $license );

			// Send the request to activate the license.
			$response = wp_remote_post(
				ACCESSIBILITY_PLUGIN_ONETAP_PRO_STORE_URL, // EDD store URL.
				array(
					'timeout'   => 15, // Request timeout in seconds.
					'sslverify' => true, // Ensure SSL verification for secure communication.
					'body'      => $api_params, // Body of the request containing parameters.
				)
			);

			// Process the response to determine if the activation was successful.
			$this->handle_license_response( $response, 'valid' );
		}

		// Check if the deactivation button was pressed.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['onetap_license_deactivate'] ) ) {
			// Set up API parameters for deactivating the license.
			$api_params = $this->prepare_api_params( 'deactivate_license', $license );

			// Send the request to deactivate the license.
			$response = wp_remote_post(
				ACCESSIBILITY_PLUGIN_ONETAP_PRO_STORE_URL, // EDD store URL.
				array(
					'timeout'   => 15, // Request timeout in seconds.
					'sslverify' => true, // Ensure SSL verification for secure communication.
					'body'      => $api_params, // Body of the request containing parameters.
				)
			);

			// Process the response to determine if the deactivation was successful.
			$this->handle_license_response( $response, 'invalid', true );
		}
	}

	/**
	 * Prepare API parameters for license activation or deactivation.
	 *
	 * @param string $action The action to perform (activate or deactivate).
	 * @param string $license The license key to activate or deactivate.
	 * @return array The prepared API parameters.
	 */
	private function prepare_api_params( $action, $license ) {
		return array(
			'edd_action'  => $action,
			'license'     => $license, // License key to activate or deactivate.
			'item_id'     => ACCESSIBILITY_PLUGIN_ONETAP_PRO_PRODUCT_ID, // Product ID.
			'item_name'   => rawurlencode( ACCESSIBILITY_PLUGIN_ONETAP_PRO_PRODUCT_NAME ), // Encoded product name.
			'url'         => esc_url( home_url() ), // Site URL, sanitized for security.
			'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production', // Environment type.
		);
	}

	/**
	 * Handle the license response from the EDD server.
	 *
	 * @param WP_Error|array $response The response from the EDD server.
	 * @param string         $valid_status The status to set if successful (valid/invalid).
	 * @param bool           $is_deactivation Whether this call is for deactivation.
	 * @return void
	 */
	private function handle_license_response( $response, $valid_status, $is_deactivation = false ) {
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( $license_data && $license_data->success ) {
			// Update the license status in the database.
			if ( $is_deactivation ) {
				delete_option( 'onetap_license_status' ); // Remove the status on successful deactivation.
			} else {
				update_option( 'onetap_license_status', $valid_status ); // Set status to valid on successful activation.
			}
		}
	}
}
