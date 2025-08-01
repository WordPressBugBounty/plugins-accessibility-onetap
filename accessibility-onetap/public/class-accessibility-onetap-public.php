<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wponetap.com
 * @since      1.0.0
 *
 * @package    Accessibility_Onetap
 * @subpackage Accessibility_Onetap/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Accessibility_Onetap
 * @subpackage Accessibility_Onetap/public
 * @author     OneTap <support@wponetap.com>
 */
class Accessibility_Onetap_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// Enqueue the main plugin stylesheet for the front-end.
		wp_enqueue_style( $this->plugin_name, plugins_url( $this->plugin_name ) . '/assets/css/accessibility-onetap-front-end.min.css', array(), $this->version, 'all' );

		// Enqueue the Elementor icons stylesheet.
		wp_enqueue_style( $this->plugin_name . '-eicons', plugins_url( $this->plugin_name ) . '/assets/fonts/eicons/css/elementor-icons.min.css', array(), $this->version, 'all' );

		// Get the plugin settings, specifically the color option.
		$settings = get_option( 'onetap_settings' );

		// Use the user-defined color setting, or fall back to the default if not set.
		$setting_color                          = isset( $settings['color'] ) ? esc_html( $settings['color'] ) : Accessibility_Onetap_Config::get_setting( 'color' );
		$setting_position_top_bottom            = isset( $settings['position-top-bottom'] ) ? absint( $settings['position-top-bottom'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom' );
		$setting_position_left_right            = isset( $settings['position-left-right'] ) ? absint( $settings['position-left-right'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right' );
		$setting_widget_position                = isset( $settings['widge-position'] ) ? esc_html( $settings['widge-position'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position' );
		$setting_position_top_bottom_tablet     = isset( $settings['position-top-bottom-tablet'] ) ? absint( $settings['position-top-bottom-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom_tablet' );
		$setting_position_left_right_tablet     = isset( $settings['position-left-right-tablet'] ) ? absint( $settings['position-left-right-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right_tablet' );
		$setting_widget_position_tablet         = isset( $settings['widge-position-tablet'] ) ? esc_html( $settings['widge-position-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position_tablet' );
		$setting_position_top_bottom_mobile     = isset( $settings['position-top-bottom-mobile'] ) ? absint( $settings['position-top-bottom-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom_mobile' );
		$setting_position_left_right_mobile     = isset( $settings['position-left-right-mobile'] ) ? absint( $settings['position-left-right-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right_mobile' );
		$setting_widget_position_mobile         = isset( $settings['widge-position-mobile'] ) ? esc_html( $settings['widge-position-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position_mobile' );
		$setting_toggle_device_position_desktop = isset( $settings['toggle-device-position-desktop'] ) ? esc_html( $settings['toggle-device-position-desktop'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_desktop' );
		$setting_toggle_device_position_tablet  = isset( $settings['toggle-device-position-tablet'] ) ? esc_html( $settings['toggle-device-position-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_tablet' );
		$setting_toggle_device_position_mobile  = isset( $settings['toggle-device-position-mobile'] ) ? esc_html( $settings['toggle-device-position-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_mobile' );
		$setting_hide_powered_by_onetap         = isset( $settings['hide-powered-by-onetap'] ) ? esc_html( $settings['hide-powered-by-onetap'] ) : Accessibility_Onetap_Config::get_setting( 'hide_powered_by_onetap' );

		// Define custom CSS to apply the color setting to specific elements.
		$style = "
		.onetap-container-toggle .onetap-toggle svg,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-site-container .onetap-site-info .onetap-image svg,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-active .onetap-icon .onetap-icon-animation svg,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv1 .onetap-icon .onetap-icon-animation svg, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv2 .onetap-icon .onetap-icon-animation svg, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv3 .onetap-icon .onetap-icon-animation svg {
			fill: {$setting_color} !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top::before,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-reset-settings button,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv1 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level1,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top::before, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-reset-settings button, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv2 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level1, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv2 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level2,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv3 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level1, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv3 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level2, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv3 .onetap-title p.onetap-option-levels span.onetap-level.onetap-level3,
		.onetap-container-toggle .onetap-toggle img,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-site-container .onetap-site-info .onetap-title span,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-site-container .onetap-site-info .onetap-information,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .toolbar-hide-duration .box-hide-duration .box-btn-action button.hide-toolbar {
			background: {$setting_color} !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .toolbar-hide-duration .box-hide-duration form label input {
			accent-color: {$setting_color} !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-reset-settings button {
			border-color: {$setting_color} !important;
		}
		.onetap-container-toggle .onetap-toggle img.design-border1 {
			box-shadow: 0 0 0 4px {$setting_color};
		}	
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature:hover {
			border-color: {$setting_color} !important;
			box-shadow: 0 0 0 1px {$setting_color} !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature:focus {
			border-width: 2px !important;
			outline: none !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature:hover .onetap-title span,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-active .onetap-title span,
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv1 .onetap-title span, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv2 .onetap-title span, nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature.onetap-lv3 .onetap-title span {
			color: {$setting_color} !important;
		}
		nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings .onetap-features-container .onetap-features .onetap-box-feature:focus {
			border-color: {$setting_color} !important;
		}
		";

		// Mobile.
		if ( 'on' === $setting_toggle_device_position_mobile ) {
			$style .= '
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle.hide-on-mobile {
					display: none !important;
				}
			}			
			';
		}

		if ( 'middle-right' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right_mobile}px !important;
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom_mobile}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'middle-left' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right_mobile}px !important;				
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom_mobile}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}
			}
			";
		} elseif ( 'bottom-right' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right_mobile}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom_mobile}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'bottom-left' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right_mobile}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom_mobile}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'top-right' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom_mobile}px !important;
					right: 0 !important;
					margin-right: {$setting_position_left_right_mobile}px !important;				
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'top-left' === $setting_widget_position_mobile ) {
			$style .= "
			@media only screen and (max-width: 576px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom_mobile}px !important;
					left: 0 !important;
					margin-left: {$setting_position_left_right_mobile}px !important;					
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		}

		// Tablet.
		if ( 'on' === $setting_toggle_device_position_tablet ) {
			$style .= '
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle.hide-on-tablet {
					display: none !important;
				}
			}			
			';
		}

		if ( 'middle-right' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right_tablet}px !important;
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom_tablet}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'middle-left' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right_tablet}px !important;				
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom_tablet}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}
			}
			";
		} elseif ( 'bottom-right' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right_tablet}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom_tablet}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'bottom-left' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right_tablet}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom_tablet}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}			
			}			
			";
		} elseif ( 'top-right' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom_tablet}px !important;
					right: 0 !important;
					margin-right: {$setting_position_left_right_tablet}px !important;				
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'top-left' === $setting_widget_position_tablet ) {
			$style .= "
			@media only screen and (min-width: 576px) and (max-width: 991.98px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom_tablet}px !important;
					left: 0 !important;
					margin-left: {$setting_position_left_right_tablet}px !important;					
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}			
			}			
			";
		}

		// Desktop.
		if ( 'on' === $setting_toggle_device_position_desktop ) {
			$style .= '
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle.hide-on-desktop {
					display: none !important;
				}
			}			
			';
		}

		if ( 'middle-right' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right}px !important;
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'middle-left' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right}px !important;				
					bottom: 50% !important;
					margin-bottom: {$setting_position_top_bottom}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}
			}
			";
		} elseif ( 'bottom-right' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					right: 0 !important;
					margin-right: {$setting_position_left_right}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'bottom-left' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					left: 0 !important;
					margin-left: {$setting_position_left_right}px !important;					
					bottom: 0 !important;
					margin-bottom: {$setting_position_top_bottom}px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}			
			}			
			";
		} elseif ( 'top-right' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom}px !important;
					right: 0 !important;
					margin-right: {$setting_position_left_right}px !important;				
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					right: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					right: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					right: 20px !important;
				}			
			}			
			";
		} elseif ( 'top-left' === $setting_widget_position ) {
			$style .= "
			@media only screen and (min-width: 992px) {
				.onetap-container-toggle .onetap-toggle {
					top: 0 !important;
					margin-top: {$setting_position_top_bottom}px !important;
					left: 0 !important;
					margin-left: {$setting_position_left_right}px !important;					
				}
				nav.onetap-accessibility.onetap-plugin-onetap {
					left: -580px !important;
				}
				nav.onetap-accessibility.onetap-plugin-onetap.onetap-toggle-open {
					left: 0 !important;
				}			
				nav.onetap-accessibility.onetap-plugin-onetap .onetap-container .onetap-accessibility-settings header.onetap-header-top .onetap-close {
					left: calc(530px - 20px) !important;
				}			
			}			
			";
		}

		if ( 'on' === $setting_hide_powered_by_onetap ) {
			$style .= '
			header.onetap-header-top .onetap-site-container .onetap-site-info .onetap-desc {
				display: none !important;
			}
			';
		}

		// Add the custom inline CSS to the previously enqueued plugin stylesheet.
		wp_add_inline_style( $this->plugin_name, $style );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Construct the file path of the plugin.
		$plugin_file = WP_PLUGIN_DIR . '/accessibility-onetap/accessibility-onetap.php';

		// Check if the plugin file exists.
		$plugin_version = '1.0.0';
		if ( file_exists( $plugin_file ) ) {
			// Include the necessary WordPress file for plugin data retrieval.
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			// Retrieve the plugin data.
			$plugin_info = get_plugin_data( $plugin_file );

			// Extract relevant plugin information.
			$plugin_version = $plugin_info['Version'];
		}

		// Register the script but do not enqueue it yet.
		wp_register_script(
			$this->plugin_name, // Handle for the script.
			plugins_url( $this->plugin_name ) . '/assets/js/script.min.js', // URL to the script file.
			array( 'jquery' ), // Dependencies, in this case, jQuery.
			$this->version, // Script version for cache-busting.
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			) // An array of additional script loading strategies.
		);

		// Enqueue the script after it has been registered.
		wp_enqueue_script( $this->plugin_name );

		// Get the 'onetap_settings' option from the database.
		$settings                               = get_option( 'onetap_settings' );
		$setting_language                       = isset( $settings['language'] ) ? esc_html( $settings['language'] ) : Accessibility_Onetap_Config::get_setting( 'language' );
		$setting_color                          = isset( $settings['color'] ) ? esc_html( $settings['color'] ) : Accessibility_Onetap_Config::get_setting( 'color' );
		$setting_position_top_bottom            = isset( $settings['position-top-bottom'] ) ? absint( $settings['position-top-bottom'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom' );
		$setting_position_left_right            = isset( $settings['position-left-right'] ) ? absint( $settings['position-left-right'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right' );
		$setting_widget_position                = isset( $settings['widge-position'] ) ? esc_html( $settings['widge-position'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position' );
		$setting_position_top_bottom_tablet     = isset( $settings['position-top-bottom-tablet'] ) ? absint( $settings['position-top-bottom-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom_tablet' );
		$setting_position_left_right_tablet     = isset( $settings['position-left-right-tablet'] ) ? absint( $settings['position-left-right-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right_tablet' );
		$setting_widget_position_tablet         = isset( $settings['widge-position-tablet'] ) ? esc_html( $settings['widge-position-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position_tablet' );
		$setting_position_top_bottom_mobile     = isset( $settings['position-top-bottom-mobile'] ) ? absint( $settings['position-top-bottom-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'position_top_bottom_mobile' );
		$setting_position_left_right_mobile     = isset( $settings['position-left-right-mobile'] ) ? absint( $settings['position-left-right-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'position_left_right_mobile' );
		$setting_widget_position_mobile         = isset( $settings['widge-position-mobile'] ) ? esc_html( $settings['widge-position-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'widget_position_mobile' );
		$setting_toggle_device_position_desktop = isset( $settings['toggle-device-position-desktop'] ) ? esc_html( $settings['toggle-device-position-desktop'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_desktop' );
		$setting_toggle_device_position_tablet  = isset( $settings['toggle-device-position-tablet'] ) ? esc_html( $settings['toggle-device-position-tablet'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_tablet' );
		$setting_toggle_device_position_mobile  = isset( $settings['toggle-device-position-mobile'] ) ? esc_html( $settings['toggle-device-position-mobile'] ) : Accessibility_Onetap_Config::get_setting( 'hide_on_mobile' );
		$setting_hide_powered_by_onetap         = isset( $settings['hide-powered-by-onetap'] ) ? esc_html( $settings['hide-powered-by-onetap'] ) : Accessibility_Onetap_Config::get_setting( 'hide_powered_by_onetap' );

		// Get the 'onetap_modules' option from the database.
		$modules                     = get_option( 'apop_modules' );
		$modules_bigger_text         = isset( $modules['bigger-text'] ) ? esc_html( $modules['bigger-text'] ) : Accessibility_Onetap_Config::get_module( 'bigger_text' );
		$modules_cursor              = isset( $modules['cursor'] ) ? esc_html( $modules['cursor'] ) : Accessibility_Onetap_Config::get_module( 'cursor' );
		$modules_line_height         = isset( $modules['line-height'] ) ? esc_html( $modules['line-height'] ) : Accessibility_Onetap_Config::get_module( 'line_height' );
		$modules_letter_spacing      = isset( $modules['letter-spacing'] ) ? esc_html( $modules['letter-spacing'] ) : Accessibility_Onetap_Config::get_module( 'letter_spacing' );
		$modules_readable_font       = isset( $modules['readable-font'] ) ? esc_html( $modules['readable-font'] ) : Accessibility_Onetap_Config::get_module( 'readable_font' );
		$modules_dyslexic_font       = isset( $modules['dyslexic-font'] ) ? esc_html( $modules['dyslexic-font'] ) : Accessibility_Onetap_Config::get_module( 'dyslexic_font' );
		$modules_text_align          = isset( $modules['text-align'] ) ? esc_html( $modules['text-align'] ) : Accessibility_Onetap_Config::get_module( 'text_align' );
		$modules_text_magnifier      = isset( $modules['text-magnifier'] ) ? esc_html( $modules['text-magnifier'] ) : Accessibility_Onetap_Config::get_module( 'text_magnifier' );
		$modules_highlight_links     = isset( $modules['highlight-links'] ) ? esc_html( $modules['highlight-links'] ) : Accessibility_Onetap_Config::get_module( 'highlight_links' );
		$modules_invert_colors       = isset( $modules['invert-colors'] ) ? esc_html( $modules['invert-colors'] ) : Accessibility_Onetap_Config::get_module( 'invert_colors' );
		$modules_brightness          = isset( $modules['brightness'] ) ? esc_html( $modules['brightness'] ) : Accessibility_Onetap_Config::get_module( 'brightness' );
		$modules_contrast            = isset( $modules['contrast'] ) ? esc_html( $modules['contrast'] ) : Accessibility_Onetap_Config::get_module( 'contrast' );
		$modules_grayscale           = isset( $modules['grayscale'] ) ? esc_html( $modules['grayscale'] ) : Accessibility_Onetap_Config::get_module( 'grayscale' );
		$modules_saturnation         = isset( $modules['saturation'] ) ? esc_html( $modules['saturation'] ) : Accessibility_Onetap_Config::get_module( 'saturation' );
		$modules_reading_line        = isset( $modules['reading-line'] ) ? esc_html( $modules['reading-line'] ) : Accessibility_Onetap_Config::get_module( 'reading_line' );
		$modules_keyboard_navigation = isset( $modules['keyboard-navigation'] ) ? esc_html( $modules['keyboard-navigation'] ) : Accessibility_Onetap_Config::get_module( 'keyboard_navigation' );
		$modules_highlight_titles    = isset( $modules['highlight-titles'] ) ? esc_html( $modules['highlight-titles'] ) : Accessibility_Onetap_Config::get_module( 'highlight_titles' );
		$modules_reading_mask        = isset( $modules['reading-mask'] ) ? esc_html( $modules['reading-mask'] ) : Accessibility_Onetap_Config::get_module( 'reading_mask' );
		$modules_hide_images         = isset( $modules['hide-images'] ) ? esc_html( $modules['hide-images'] ) : Accessibility_Onetap_Config::get_module( 'hide_images' );
		$modules_highlight_all       = isset( $modules['highlight-all'] ) ? esc_html( $modules['highlight-all'] ) : Accessibility_Onetap_Config::get_module( 'highlight_all' );
		$modules_read_page           = isset( $modules['read-page'] ) ? esc_html( $modules['read-page'] ) : Accessibility_Onetap_Config::get_module( 'read_page' );
		$modules_mute_sounds         = isset( $modules['mute-sounds'] ) ? esc_html( $modules['mute-sounds'] ) : Accessibility_Onetap_Config::get_module( 'mute_sounds' );
		$modules_stop_animations     = isset( $modules['stop-animations'] ) ? esc_html( $modules['stop-animations'] ) : Accessibility_Onetap_Config::get_module( 'stop_animations' );

		$list_languages = array(
			'en'    => 'English',
			'de'    => 'Deutsch',
			'es'    => 'Español',
			'fr'    => 'Français',
			'it'    => 'Italiano',
			'pl'    => 'Polski',
			'se'    => 'Svenska',
			'fi'    => 'Suomi',
			'pt'    => 'Português',
			'ro'    => 'Română',
			'si'    => 'Slovenščina',
			'sk'    => 'Slovenčina',
			'nl'    => 'Nederlands',
			'dk'    => 'Dansk',
			'gr'    => 'Ελληνικά',
			'cz'    => 'Čeština',
			'hu'    => 'Magyar',
			'lt'    => 'Lietuvių',
			'lv'    => 'Latviešu',
			'ee'    => 'Eesti',
			'hr'    => 'Hrvatski',
			'ie'    => 'Gaeilge',
			'bg'    => 'Български',
			'no'    => 'Norsk',
			'tr'    => 'Türkçe',
			'id'    => 'Bahasa Indonesia',
			'pt-br' => 'Português (Brasil)',
			'ja'    => '日本語',
			'ko'    => '한국어',
			'zh'    => '简体中文',
			'ar'    => 'العربية',
			'ru'    => 'Русский',
			'hi'    => 'हिन्दी',
			'uk'    => 'Українська',
			'sr'    => 'Srpski',
		);

		wp_localize_script(
			$this->plugin_name,
			'accessibilityOnetapAjaxObject',
			array(
				'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
				'nonce'       => wp_create_nonce( 'ajax-nonce' ),
				'languages'   => array(
					'en'    => array(
						'global'                 => array(
							'back' => 'Back',
						),
						'hideToolbar'            => array(
							'title'   => 'How long do you want to hide the accessibility toolbar?',
							'radio1'  => 'Only for this session',
							'radio2'  => '24 hours',
							'radio3'  => 'A Week',
							'button1' => 'Not Now',
							'button2' => 'Hide Toolbar',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browser needs to be updated',
							'desc'  => 'Your browser doesn’t support speech output. Please update your browser or use one with speech synthesis enabled (e.g. Chrome, Edge, Safari).',
							'link'  => 'How to Update?',
						),
						'header'                 => array(
							'language'      => 'English',
							'listLanguages' => $list_languages,
							'title'         => 'Accessibility Adjustments',
							'desc'          => 'Powered by',
							'anchor'        => 'OneTap',
							'statement'     => 'Statement',
							'hideToolbar'   => 'Hide Toolbar',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Select your accessibility profile',
							'visionImpairedMode' => array(
								'title' => 'Vision Impaired Mode',
								'desc'  => "Enhances website's visuals",
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'seizureSafeProfile' => array(
								'title' => 'Seizure Safe Profile',
								'desc'  => 'Clear flashes & reduces color',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD Friendly Mode',
								'desc'  => 'Focused browsing, distraction-free',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'blindnessMode'      => array(
								'title' => 'Blindness Mode',
								'desc'  => 'Reduces distractions, improves focus',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsy Safe Mode',
								'desc'  => 'Dims colors and stops blinking',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
						),
						'content'                => array(
							'biggerText'    => 'Bigger Text',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Line Height',
							'letterSpacing' => 'Letter Spacing',
							'readableFont'  => 'Readable Font',
							'dyslexicFont'  => 'Dyslexic Font',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Align Text',
							'textMagnifier'  => 'Text Magnifier',
							'highlightLinks' => 'Highlight Links',
						),
						'colors'                 => array(
							'invertColors' => 'Invert Colors',
							'brightness'   => 'Brightness',
							'contrast'     => 'Contrast',
							'grayscale'    => 'Grayscale',
							'saturation'   => 'Saturation',
						),
						'orientation'            => array(
							'readingLine'        => 'Reading Line',
							'keyboardNavigation' => 'Keyboard Navigation',
							'highlightTitles'    => 'Highlight Titles',
							'readingMask'        => 'Reading Mask',
							'hideImages'         => 'Hide Images',
							'highlightAll'       => 'Highlight All',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Read Page',
							'muteSounds'     => 'Mute Sounds',
							'stopAnimations' => 'Stop Animations',
						),
						'divider'                => array(
							'content'    => 'content',
							'colors'     => 'colors',
							'navigation' => 'orientation',
						),
						'resetSettings'          => 'Reset Settings',
						'footer'                 => array(
							'accessibilityStatement' => 'Accessibility statement',
							'version'                => 'Version ' . $plugin_version,
						),
					),
					'de'    => array(
						'global'                 => array(
							'back' => 'Zurück',
						),
						'hideToolbar'            => array(
							'title'   => 'Wie lange möchten Sie die Barrierefreiheits-Symbolleiste ausblenden?',
							'radio1'  => 'Nur für diese Sitzung',
							'radio2'  => '24 Stunden',
							'radio3'  => 'Eine Woche',
							'button1' => 'Nicht jetzt',
							'button2' => 'Symbolleiste ausblenden',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browser muss aktualisiert werden',
							'desc'  => 'Ihr Browser unterstützt keine Sprachausgabe. Bitte aktualisieren Sie Ihren Browser oder verwenden Sie einen mit aktivierter Sprachsynthese (z. B. Chrome, Edge, Safari).',
							'link'  => 'Wie aktualisieren?',
						),
						'header'                 => array(
							'language'      => 'Deutsch',
							'listLanguages' => $list_languages,
							'title'         => 'Barrierefreie Anpassungen',
							'desc'          => 'Unterstützt durch',
							'anchor'        => 'OneTap',
							'statement'     => 'Erklärung',
							'hideToolbar'   => 'Symbolleiste ausblenden',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Wählen Sie Ihr Barrierefreiheitsprofil',
							'visionImpairedMode' => array(
								'title' => 'Sehbehinderungsmodus',
								'desc'  => 'Verbessert die visuellen Elemente der Website',
								'on'    => 'AN',
								'off'   => 'AUS',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil für Anfallsicherheit',
								'desc'  => 'Reduziert Farbblitze und klarere Farben',
								'on'    => 'AN',
								'off'   => 'AUS',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-freundlicher Modus',
								'desc'  => 'Fokussiertes Surfen ohne Ablenkungen',
								'on'    => 'AN',
								'off'   => 'AUS',
							),
							'blindnessMode'      => array(
								'title' => 'Blindheitsmodus',
								'desc'  => 'Reduziert Ablenkungen, verbessert die Konzentration',
								'on'    => 'AN',
								'off'   => 'AUS',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsie-sicherer Modus',
								'desc'  => 'Dimmt Farben und stoppt das Blinken',
								'on'    => 'AN',
								'off'   => 'AUS',
							),
						),
						'content'                => array(
							'biggerText'    => 'Größerer Text',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Zeilenhöhe',
							'letterSpacing' => 'Buchstabenabstand',
							'readableFont'  => 'Lesbare Schriftart',
							'dyslexicFont'  => 'Dyslexische Schriftart',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Textausrichtung',
							'textMagnifier'  => 'Textvergrößerung',
							'highlightLinks' => 'Links hervorheben',
						),
						'colors'                 => array(
							'invertColors' => 'Farben umkehren',
							'brightness'   => 'Helligkeit',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Graustufen',
							'saturation'   => 'Sättigung',
						),
						'orientation'            => array(
							'readingLine'        => 'Leselinie',
							'keyboardNavigation' => 'Tastaturnavigation',
							'highlightTitles'    => 'Titel hervorheben',
							'readingMask'        => 'Lese-Maske',
							'hideImages'         => 'Bilder ausblenden',
							'highlightAll'       => 'Alles hervorheben',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Seite lesen',
							'muteSounds'     => 'Geräusche stummschalten',
							'stopAnimations' => 'Animationen stoppen',
						),
						'divider'                => array(
							'content'    => 'Inhalt',
							'colors'     => 'Farben',
							'navigation' => 'Navigation',
						),
						'resetSettings'          => 'Einstellungen zurücksetzen',
						'footer'                 => array(
							'accessibilityStatement' => 'Barrierefreiheits-Erklärung',
							'version'                => 'Version ' . $plugin_version,
						),
					),
					'es'    => array(
						'global'                 => array(
							'back' => 'Volver',
						),
						'hideToolbar'            => array(
							'title'   => '¿Cuánto tiempo desea ocultar la barra de accesibilidad?',
							'radio1'  => 'Solo para esta sesión',
							'radio2'  => '24 horas',
							'radio3'  => 'Una semana',
							'button1' => 'Ahora no',
							'button2' => 'Ocultar barra',
						),
						'unsupportedPageReader'  => array(
							'title' => 'El navegador necesita actualización',
							'desc'  => 'Tu navegador no admite salida de voz. Actualiza tu navegador o usa uno con síntesis de voz habilitada (por ejemplo, Chrome, Edge, Safari).',
							'link'  => '¿Cómo actualizar?',
						),
						'header'                 => array(
							'language'      => 'Español',
							'listLanguages' => $list_languages,
							'title'         => 'Ajustes de Accesibilidad',
							'desc'          => 'Desarrollado por',
							'anchor'        => 'OneTap',
							'statement'     => 'Declaración',
							'hideToolbar'   => 'Ocultar barra de herramientas',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Seleccione su perfil de accesibilidad',
							'visionImpairedMode' => array(
								'title' => 'Modo para personas con discapacidad visual',
								'desc'  => 'Mejora los elementos visuales del sitio web',
								'on'    => 'ENC',
								'off'   => 'APG',
							),
							'seizureSafeProfile' => array(
								'title' => 'Perfil seguro para convulsiones',
								'desc'  => 'Reduce los destellos y mejora los colores',
								'on'    => 'ENC',
								'off'   => 'APG',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Modo amigable para el TDAH',
								'desc'  => 'Navegación enfocada sin distracciones',
								'on'    => 'ENC',
								'off'   => 'APG',
							),
							'blindnessMode'      => array(
								'title' => 'Modo para ceguera',
								'desc'  => 'Reduce las distracciones y mejora el enfoque',
								'on'    => 'ENC',
								'off'   => 'APG',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Modo seguro para epilepsia',
								'desc'  => 'Reduce los colores y detiene el parpadeo',
								'on'    => 'ENC',
								'off'   => 'APG',
							),
						),
						'content'                => array(
							'biggerText'    => 'Texto más grande',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Altura de línea',
							'letterSpacing' => 'Espaciado de letras',
							'readableFont'  => 'Fuente legible',
							'dyslexicFont'  => 'Fuente para dislexia',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Alineación de texto',
							'textMagnifier'  => 'Lupa de texto',
							'highlightLinks' => 'Resaltar enlaces',
						),
						'colors'                 => array(
							'invertColors' => 'Invertir colores',
							'brightness'   => 'Brillo',
							'contrast'     => 'Contraste',
							'grayscale'    => 'Escala de grises',
							'saturation'   => 'Saturación',
						),
						'orientation'            => array(
							'readingLine'        => 'Línea de lectura',
							'keyboardNavigation' => 'Navegación por teclado',
							'highlightTitles'    => 'Resaltar títulos',
							'readingMask'        => 'Máscara de lectura',
							'hideImages'         => 'Ocultar imágenes',
							'highlightAll'       => 'Resaltar todo',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Leer página',
							'muteSounds'     => 'Silenciar sonidos',
							'stopAnimations' => 'Detener animaciones',
						),
						'divider'                => array(
							'content'    => 'Contenido',
							'colors'     => 'Colores',
							'navigation' => 'Navegación',
						),
						'resetSettings'          => 'Restablecer configuraciones',
						'footer'                 => array(
							'accessibilityStatement' => 'Declaración de accesibilidad',
							'version'                => 'Versión ' . $plugin_version,
						),
					),
					'fr'    => array(
						'global'                 => array(
							'back' => 'Retour',
						),
						'hideToolbar'            => array(
							'title'   => 'Combien de temps souhaitez-vous masquer la barre d’accessibilité ?',
							'radio1'  => 'Seulement pour cette session',
							'radio2'  => '24 heures',
							'radio3'  => 'Une semaine',
							'button1' => 'Pas maintenant',
							'button2' => 'Masquer la barre',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Le navigateur doit être mis à jour',
							'desc'  => 'Votre navigateur ne prend pas en charge la synthèse vocale. Veuillez le mettre à jour ou utiliser un navigateur compatible (par exemple Chrome, Edge, Safari).',
							'link'  => 'Comment le mettre à jour ?',
						),
						'header'                 => array(
							'language'      => 'Français',
							'listLanguages' => $list_languages,
							'title'         => 'Réglages d\'accessibilité',
							'desc'          => 'Développé par',
							'anchor'        => 'OneTap',
							'statement'     => 'Déclaration',
							'hideToolbar'   => 'Masquer la barre d’outils',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Sélectionnez votre profil d\'accessibilité',
							'visionImpairedMode' => array(
								'title' => 'Mode pour malvoyants',
								'desc'  => 'Améliore les éléments visuels du site web',
								'on'    => 'ACT',
								'off'   => 'DÉSACT',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil sécurisé pour les crises',
								'desc'  => 'Réduit les éclairs et améliore les couleurs',
								'on'    => 'ACT',
								'off'   => 'DÉSACT',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Mode adapté pour le TDAH',
								'desc'  => 'Navigation concentrée sans distractions',
								'on'    => 'ACT',
								'off'   => 'DÉSACT',
							),
							'blindnessMode'      => array(
								'title' => 'Mode pour la cécité',
								'desc'  => 'Réduit les distractions et améliore la concentration',
								'on'    => 'ACT',
								'off'   => 'DÉSACT',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Mode sécurisé pour l\'épilepsie',
								'desc'  => 'Réduit les couleurs et arrête les clignotements',
								'on'    => 'ACT',
								'off'   => 'DÉSACT',
							),
						),
						'content'                => array(
							'biggerText'    => 'Texte plus grand',
							'cursor'        => 'Curseur',
							'lineHeight'    => 'Hauteur de ligne',
							'letterSpacing' => 'Espacement des lettres',
							'readableFont'  => 'Police lisible',
							'dyslexicFont'  => 'Police pour dyslexie',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Alignement du texte',
							'textMagnifier'  => 'Loupe de texte',
							'highlightLinks' => 'Surligner les liens',
						),
						'colors'                 => array(
							'invertColors' => 'Inverser les couleurs',
							'brightness'   => 'Luminosité',
							'contrast'     => 'Contraste',
							'grayscale'    => 'Niveaux de gris',
							'saturation'   => 'Saturation',
						),
						'orientation'            => array(
							'readingLine'        => 'Ligne de lecture',
							'keyboardNavigation' => 'Navigation au clavier',
							'highlightTitles'    => 'Surligner les titres',
							'readingMask'        => 'Masque de lecture',
							'hideImages'         => 'Masquer les images',
							'highlightAll'       => 'Surligner tout',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Lire la page',
							'muteSounds'     => 'Couper les sons',
							'stopAnimations' => 'Arrêter les animations',
						),
						'divider'                => array(
							'content'    => 'Contenu',
							'colors'     => 'Couleurs',
							'navigation' => 'Navigation',
						),
						'resetSettings'          => 'Réinitialiser les paramètres',
						'footer'                 => array(
							'accessibilityStatement' => 'Déclaration d\'accessibilité',
							'version'                => 'Version ' . $plugin_version,
						),
					),
					'it'    => array(
						'global'                 => array(
							'back' => 'Indietro',
						),
						'hideToolbar'            => array(
							'title'   => 'Per quanto tempo vuoi nascondere la barra di accessibilità?',
							'radio1'  => 'Solo per questa sessione',
							'radio2'  => '24 ore',
							'radio3'  => 'Una settimana',
							'button1' => 'Non ora',
							'button2' => 'Nascondi barra',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Il browser deve essere aggiornato',
							'desc'  => 'Il tuo browser non supporta la sintesi vocale. Aggiorna il browser o utilizza uno che supporti la sintesi vocale (es. Chrome, Edge, Safari).',
							'link'  => 'Come aggiornare?',
						),
						'header'                 => array(
							'language'      => 'Italiano',
							'listLanguages' => $list_languages,
							'title'         => 'Impostazioni di accessibilità',
							'desc'          => 'Sviluppato da',
							'anchor'        => 'OneTap',
							'statement'     => 'Dichiarazione',
							'hideToolbar'   => 'Nascondi barra degli strumenti',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Seleziona il tuo profilo di accessibilità',
							'visionImpairedMode' => array(
								'title' => 'Modalità per disabilità visive',
								'desc'  => 'Migliora gli elementi visivi del sito web',
								'on'    => 'ATTIVO',
								'off'   => 'DISATTIVO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profilo sicuro per crisi',
								'desc'  => 'Riduce i lampi e migliora i colori',
								'on'    => 'ATTIVO',
								'off'   => 'DISATTIVO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Modalità adatta per ADHD',
								'desc'  => 'Navigazione concentrata senza distrazioni',
								'on'    => 'ATTIVO',
								'off'   => 'DISATTIVO',
							),
							'blindnessMode'      => array(
								'title' => 'Modalità per cecità',
								'desc'  => 'Riduce le distrazioni e migliora la concentrazione',
								'on'    => 'ATTIVO',
								'off'   => 'DISATTIVO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Modalità sicura per epilessia',
								'desc'  => 'Riduce i colori e ferma i lampeggiamenti',
								'on'    => 'ATTIVO',
								'off'   => 'DISATTIVO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Testo più grande',
							'cursor'        => 'Cursore',
							'lineHeight'    => 'Altezza della linea',
							'letterSpacing' => 'Spaziatura delle lettere',
							'readableFont'  => 'Carattere leggibile',
							'dyslexicFont'  => 'Carattere per dislessia',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Allinea il testo',
							'textMagnifier'  => 'Lente di ingrandimento del testo',
							'highlightLinks' => 'Evidenzia i link',
						),
						'colors'                 => array(
							'invertColors' => 'Inverti i colori',
							'brightness'   => 'Luminosità',
							'contrast'     => 'Contrasto',
							'grayscale'    => 'Tonalità di grigio',
							'saturation'   => 'Saturazione',
						),
						'orientation'            => array(
							'readingLine'        => 'Linea di lettura',
							'keyboardNavigation' => 'Navigazione con tastiera',
							'highlightTitles'    => 'Evidenzia i titoli',
							'readingMask'        => 'Maschera di lettura',
							'hideImages'         => 'Nascondi le immagini',
							'highlightAll'       => 'Evidenzia tutto',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Leggi la pagina',
							'muteSounds'     => 'Disattiva i suoni',
							'stopAnimations' => 'Ferma le animazioni',
						),
						'divider'                => array(
							'content'    => 'Contenuto',
							'colors'     => 'Colori',
							'navigation' => 'Navigazione',
						),
						'resetSettings'          => 'Ripristina le impostazioni',
						'footer'                 => array(
							'accessibilityStatement' => 'Dichiarazione di accessibilità',
							'version'                => 'Versione ' . $plugin_version,
						),
					),
					'pl'    => array(
						'global'                 => array(
							'back' => 'Wstecz',
						),
						'hideToolbar'            => array(
							'title'   => 'Na jak długo chcesz ukryć pasek dostępności?',
							'radio1'  => 'Tylko na tę sesję',
							'radio2'  => '24 godziny',
							'radio3'  => 'Tydzień',
							'button1' => 'Nie teraz',
							'button2' => 'Ukryj pasek',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Przeglądarka wymaga aktualizacji',
							'desc'  => 'Twoja przeglądarka nie obsługuje syntezy mowy. Zaktualizuj przeglądarkę lub użyj takiej, która obsługuje syntezę mowy (np. Chrome, Edge, Safari).',
							'link'  => 'Jak zaktualizować?',
						),
						'header'                 => array(
							'language'      => 'Polski',
							'listLanguages' => $list_languages,
							'title'         => 'Ustawienia dostępności',
							'desc'          => 'Zbudowane przez',
							'anchor'        => 'OneTap',
							'statement'     => 'Oświadczenie',
							'hideToolbar'   => 'Ukryj pasek narzędzi',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Wybierz swój profil dostępności',
							'visionImpairedMode' => array(
								'title' => 'Tryb dla osób z zaburzeniami wzroku',
								'desc'  => 'Poprawia wygląd strony',
								'on'    => 'WŁĄCZONE',
								'off'   => 'WYŁĄCZONE',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil bezpieczny dla osób z padaczką',
								'desc'  => 'Zmniejsza migające światła i poprawia kolory',
								'on'    => 'WŁĄCZONE',
								'off'   => 'WYŁĄCZONE',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Tryb przyjazny dla osób z ADHD',
								'desc'  => 'Skoncentrowana nawigacja, bez rozpraszania',
								'on'    => 'WŁĄCZONE',
								'off'   => 'WYŁĄCZONE',
							),
							'blindnessMode'      => array(
								'title' => 'Tryb dla osób niewidomych',
								'desc'  => 'Zmniejsza rozproszenia, poprawia koncentrację',
								'on'    => 'WŁĄCZONE',
								'off'   => 'WYŁĄCZONE',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Tryb bezpieczny dla osób z padaczką',
								'desc'  => 'Zmienia kolory i zatrzymuje miganie',
								'on'    => 'WŁĄCZONE',
								'off'   => 'WYŁĄCZONE',
							),
						),
						'content'                => array(
							'biggerText'    => 'Większy tekst',
							'cursor'        => 'Kursor',
							'lineHeight'    => 'Wysokość linii',
							'letterSpacing' => 'Odstępy między literami',
							'readableFont'  => 'Czytelna czcionka',
							'dyslexicFont'  => 'Czcionka dla dyslektyków',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Wyrównaj tekst',
							'textMagnifier'  => 'Lupa tekstu',
							'highlightLinks' => 'Wyróżnij linki',
						),
						'colors'                 => array(
							'invertColors' => 'Odwróć kolory',
							'brightness'   => 'Jasność',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Skala szarości',
							'saturation'   => 'Nasycenie',
						),
						'orientation'            => array(
							'readingLine'        => 'Linia czytania',
							'keyboardNavigation' => 'Nawigacja klawiaturą',
							'highlightTitles'    => 'Wyróżnij tytuły',
							'readingMask'        => 'Maska czytania',
							'hideImages'         => 'Ukryj obrazy',
							'highlightAll'       => 'Wyróżnij wszystko',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Przeczytaj stronę',
							'muteSounds'     => 'Wycisz dźwięki',
							'stopAnimations' => 'Zatrzymaj animacje',
						),
						'divider'                => array(
							'content'    => 'Treść',
							'colors'     => 'Kolory',
							'navigation' => 'Nawigacja',
						),
						'resetSettings'          => 'Resetuj ustawienia',
						'footer'                 => array(
							'accessibilityStatement' => 'Deklaracja dostępności',
							'version'                => 'Wersja ' . $plugin_version,
						),
					),
					'se'    => array(
						'global'                 => array(
							'back' => 'Tillbaka',
						),
						'hideToolbar'            => array(
							'title'   => 'Hur länge vill du dölja tillgänglighetsverktygsfältet?',
							'radio1'  => 'Endast för denna session',
							'radio2'  => '24 timmar',
							'radio3'  => 'En vecka',
							'button1' => 'Inte nu',
							'button2' => 'Dölj verktygsfältet',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Webbläsaren behöver uppdateras',
							'desc'  => 'Din webbläsare stöder inte talsyntes. Uppdatera din webbläsare eller använd en som stöder talsyntes (t.ex. Chrome, Edge, Safari).',
							'link'  => 'Hur uppdaterar man?',
						),
						'header'                 => array(
							'language'      => 'Svenska',
							'listLanguages' => $list_languages,
							'title'         => 'Tillgänglighetsinställningar',
							'desc'          => 'Byggd av',
							'anchor'        => 'OneTap',
							'statement'     => 'Uttalande',
							'hideToolbar'   => 'Dölj verktygsfält',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Välj din tillgänglighetsprofil',
							'visionImpairedMode' => array(
								'title' => 'Synnedsättningläge',
								'desc'  => 'Förbättrar webbplatsens visuella element',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'seizureSafeProfile' => array(
								'title' => 'Säker profil för anfall',
								'desc'  => 'Minskar blinkningar och förbättrar färger',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-vänligt läge',
								'desc'  => 'Fokuserad surfning utan distraktioner',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'blindnessMode'      => array(
								'title' => 'Blindläge',
								'desc'  => 'Minskar distraktioner och förbättrar fokus',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsisäkert läge',
								'desc'  => 'Dämpar färger och stoppar blinkningar',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
						),
						'content'                => array(
							'biggerText'    => 'Större text',
							'cursor'        => 'Muspekare',
							'lineHeight'    => 'Radhöjd',
							'letterSpacing' => 'Bokstavsavstånd',
							'readableFont'  => 'Läslig font',
							'dyslexicFont'  => 'Font för dyslexi',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Justera text',
							'textMagnifier'  => 'Textförstorare',
							'highlightLinks' => 'Markera länkar',
						),
						'colors'                 => array(
							'invertColors' => 'Invertera färger',
							'brightness'   => 'Ljusstyrka',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Gråskala',
							'saturation'   => 'Mättnad',
						),
						'orientation'            => array(
							'readingLine'        => 'Läsrad',
							'keyboardNavigation' => 'Tangentbordsnavigering',
							'highlightTitles'    => 'Markera titlar',
							'readingMask'        => 'Läsmask',
							'hideImages'         => 'Dölj bilder',
							'highlightAll'       => 'Markera alla',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Läs sida',
							'muteSounds'     => 'Stäng av ljud',
							'stopAnimations' => 'Stoppa animationer',
						),
						'divider'                => array(
							'content'    => 'Innehåll',
							'colors'     => 'Färger',
							'navigation' => 'Navigering',
						),
						'resetSettings'          => 'Återställ inställningar',
						'footer'                 => array(
							'accessibilityStatement' => 'Tillgänglighetsdeklaration',
							'version'                => 'Version ' . $plugin_version,
						),
					),
					'fi'    => array(
						'global'                 => array(
							'back' => 'Takaisin',
						),
						'hideToolbar'            => array(
							'title'   => 'Kuinka kauan haluat piilottaa saavutettavuuspalkin?',
							'radio1'  => 'Vain tälle istunnolle',
							'radio2'  => '24 tuntia',
							'radio3'  => 'Viikko',
							'button1' => 'Ei nyt',
							'button2' => 'Piilota palkki',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Selain täytyy päivittää',
							'desc'  => 'Selaimesi ei tue puhesynteesiä. Päivitä selain tai käytä sellaista, joka tukee puhesynteesiä (esim. Chrome, Edge, Safari).',
							'link'  => 'Kuinka päivitetään?',
						),
						'header'                 => array(
							'language'      => 'Suomi',
							'listLanguages' => $list_languages,
							'title'         => 'Saavutettavuusasetukset',
							'desc'          => 'Rakennettu',
							'anchor'        => 'OneTap',
							'statement'     => 'Lausunto',
							'hideToolbar'   => 'Piilota työkalupalkki',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Valitse saavutettavuusprofiilisi',
							'visionImpairedMode' => array(
								'title' => 'Näkövammaisten tila',
								'desc'  => 'Parantaa verkkosivuston visuaalisia elementtejä',
								'on'    => 'PÄÄLLÄ',
								'off'   => 'POIS',
							),
							'seizureSafeProfile' => array(
								'title' => 'Kouristuksia estävä profiili',
								'desc'  => 'Vähentää vilkkuvia valoja ja parantaa värejä',
								'on'    => 'PÄÄLLÄ',
								'off'   => 'POIS',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-ystävällinen tila',
								'desc'  => 'Keskittynyt selaaminen ilman häiriöitä',
								'on'    => 'PÄÄLLÄ',
								'off'   => 'POIS',
							),
							'blindnessMode'      => array(
								'title' => 'Sokeus tila',
								'desc'  => 'Vähentää häiriöitä ja parantaa keskittymistä',
								'on'    => 'PÄÄLLÄ',
								'off'   => 'POIS',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsiaturvallinen tila',
								'desc'  => 'Häiritsee värejä ja estää vilkkumisen',
								'on'    => 'PÄÄLLÄ',
								'off'   => 'POIS',
							),
						),
						'content'                => array(
							'biggerText'    => 'Suurempi teksti',
							'cursor'        => 'Hiiren osoitin',
							'lineHeight'    => 'Riviväli',
							'letterSpacing' => 'Kirjainväli',
							'readableFont'  => 'Lukukelpoinen fontti',
							'dyslexicFont'  => 'Dyslektikon fontti',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Tekstin tasaus',
							'textMagnifier'  => 'Tekstin suurennuslasia',
							'highlightLinks' => 'Korosta linkkejä',
						),
						'colors'                 => array(
							'invertColors' => 'Käännä värit',
							'brightness'   => 'Kirkkaus',
							'contrast'     => 'Kontrasti',
							'grayscale'    => 'Harmaasävy',
							'saturation'   => 'Kylläisyys',
						),
						'orientation'            => array(
							'readingLine'        => 'Lukulinja',
							'keyboardNavigation' => 'Näppäimistö navigointi',
							'highlightTitles'    => 'Korosta otsikoita',
							'readingMask'        => 'Lukemismaski',
							'hideImages'         => 'Piilota kuvat',
							'highlightAll'       => 'Korosta kaikki',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Lue sivu',
							'muteSounds'     => 'Mykistä äänet',
							'stopAnimations' => 'Pysäytä animaatiot',
						),
						'divider'                => array(
							'content'    => 'Sisältö',
							'colors'     => 'Värit',
							'navigation' => 'Navigointi',
						),
						'resetSettings'          => 'Nollaa asetukset',
						'footer'                 => array(
							'accessibilityStatement' => 'Saavutettavuuslausunto',
							'version'                => 'Versio ' . $plugin_version,
						),
					),
					'pt'    => array(
						'global'                 => array(
							'back' => 'Voltar',
						),
						'hideToolbar'            => array(
							'title'   => 'Por quanto tempo deseja ocultar a barra de acessibilidade?',
							'radio1'  => 'Apenas para esta sessão',
							'radio2'  => '24 horas',
							'radio3'  => 'Uma semana',
							'button1' => 'Agora não',
							'button2' => 'Ocultar barra',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Selain täytyy päivittää',
							'desc'  => 'Selaimesi ei tue puhesynteesiä. Päivitä selain tai käytä sellaista, joka tukee puhesynteesiä (esim. Chrome, Edge, Safari).',
							'link'  => 'Kuinka päivitetään?',
						),
						'header'                 => array(
							'language'      => 'Português',
							'listLanguages' => $list_languages,
							'title'         => 'Configurações de Acessibilidade',
							'desc'          => 'Construído por',
							'anchor'        => 'OneTap',
							'statement'     => 'Declaração',
							'hideToolbar'   => 'Ocultar barra de ferramentas',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Escolha seu perfil de acessibilidade',
							'visionImpairedMode' => array(
								'title' => 'Modo de Deficiência Visual',
								'desc'  => 'Melhora os elementos visuais do site',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Perfil Seguro para Convulsões',
								'desc'  => 'Reduz luzes piscando e melhora as cores',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Modo Amigável para TDAH',
								'desc'  => 'Navegação focada sem distrações',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'blindnessMode'      => array(
								'title' => 'Modo para Deficientes Visuais',
								'desc'  => 'Reduz distrações e melhora a concentração',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Modo Seguro para Epilepsia',
								'desc'  => 'Diminui as cores e para os flashes',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Texto Maior',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Altura da Linha',
							'letterSpacing' => 'Espaçamento das Letras',
							'readableFont'  => 'Fonte Legível',
							'dyslexicFont'  => 'Fonte para Dislexia',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Alinhar Texto',
							'textMagnifier'  => 'Lupa de Texto',
							'highlightLinks' => 'Destacar Links',
						),
						'colors'                 => array(
							'invertColors' => 'Inverter Cores',
							'brightness'   => 'Brilho',
							'contrast'     => 'Contraste',
							'grayscale'    => 'Escala de Cinza',
							'saturation'   => 'Saturação',
						),
						'orientation'            => array(
							'readingLine'        => 'Linha de Leitura',
							'keyboardNavigation' => 'Navegação pelo Teclado',
							'highlightTitles'    => 'Destacar Títulos',
							'readingMask'        => 'Máscara de Leitura',
							'hideImages'         => 'Esconder Imagens',
							'highlightAll'       => 'Destacar Tudo',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Ler Página',
							'muteSounds'     => 'Silenciar Sons',
							'stopAnimations' => 'Parar Animações',
						),
						'divider'                => array(
							'content'    => 'Conteúdo',
							'colors'     => 'Cores',
							'navigation' => 'Navegação',
						),
						'resetSettings'          => 'Redefinir Configurações',
						'footer'                 => array(
							'accessibilityStatement' => 'Declaração de Acessibilidade',
							'version'                => 'Versão ' . $plugin_version,
						),
					),
					'ro'    => array(
						'global'                 => array(
							'back' => 'Înapoi',
						),
						'hideToolbar'            => array(
							'title'   => 'Cât timp doriți să ascundeți bara de accesibilitate?',
							'radio1'  => 'Doar pentru această sesiune',
							'radio2'  => '24 de ore',
							'radio3'  => 'O săptămână',
							'button1' => 'Nu acum',
							'button2' => 'Ascunde bara',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browserul trebuie actualizat',
							'desc'  => 'Browserul tău nu suportă ieșirea vocală. Te rugăm să-l actualizezi sau să folosești unul care acceptă sinteza vocală (de exemplu, Chrome, Edge, Safari).',
							'link'  => 'Cum se actualizează?',
						),
						'header'                 => array(
							'language'      => 'Română',
							'listLanguages' => $list_languages,
							'title'         => 'Setări de Accesibilitate',
							'desc'          => 'Creat de',
							'anchor'        => 'OneTap',
							'statement'     => 'Declarație',
							'hideToolbar'   => 'Ascunde bara de instrumente',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Alegeți profilul de accesibilitate',
							'visionImpairedMode' => array(
								'title' => 'Mod pentru deficiențe de vedere',
								'desc'  => 'Îmbunătățește elementele vizuale ale site-ului',
								'on'    => 'ACTIVAT',
								'off'   => 'DEZACTIVAT',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil sigur pentru crize',
								'desc'  => 'Reduce luminile intermitente și îmbunătățește culorile',
								'on'    => 'ACTIVAT',
								'off'   => 'DEZACTIVAT',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Mod prietenos pentru TDAH',
								'desc'  => 'Navigare concentrată fără distrageri',
								'on'    => 'ACTIVAT',
								'off'   => 'DEZACTIVAT',
							),
							'blindnessMode'      => array(
								'title' => 'Mod pentru orbire',
								'desc'  => 'Reduce distragerile și îmbunătățește concentrarea',
								'on'    => 'ACTIVAT',
								'off'   => 'DEZACTIVAT',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Mod sigur pentru epilepsie',
								'desc'  => 'Reduce culorile și oprește clipirea',
								'on'    => 'ACTIVAT',
								'off'   => 'DEZACTIVAT',
							),
						),
						'content'                => array(
							'biggerText'    => 'Text mai mare',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Înălțimea liniei',
							'letterSpacing' => 'Spațierea literelor',
							'readableFont'  => 'Font lizibil',
							'dyslexicFont'  => 'Font pentru dislexie',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Aliniere text',
							'textMagnifier'  => 'Lupă text',
							'highlightLinks' => 'Subliniază link-uri',
						),
						'colors'                 => array(
							'invertColors' => 'Inversare culori',
							'brightness'   => 'Luminozitate',
							'contrast'     => 'Contrast',
							'grayscale'    => 'Nuante de gri',
							'saturation'   => 'Saturație',
						),
						'orientation'            => array(
							'readingLine'        => 'Linie de citire',
							'keyboardNavigation' => 'Navigare cu tastatura',
							'highlightTitles'    => 'Subliniază titluri',
							'readingMask'        => 'Mască de citire',
							'hideImages'         => 'Ascunde imagini',
							'highlightAll'       => 'Subliniază tot',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Citește pagina',
							'muteSounds'     => 'Opresc sunetele',
							'stopAnimations' => 'Oprire animații',
						),
						'divider'                => array(
							'content'    => 'Conținut',
							'colors'     => 'Culori',
							'navigation' => 'Navigare',
						),
						'resetSettings'          => 'Resetați setările',
						'footer'                 => array(
							'accessibilityStatement' => 'Declarație de accesibilitate',
							'version'                => 'Versiune ' . $plugin_version,
						),
					),
					'si'    => array(
						'global'                 => array(
							'back' => 'Nazaj',
						),
						'hideToolbar'            => array(
							'title'   => 'Kako dolgo želite skriti orodno vrstico za dostopnost?',
							'radio1'  => 'Samo za to sejo',
							'radio2'  => '24 ur',
							'radio3'  => 'En teden',
							'button1' => 'Ne zdaj',
							'button2' => 'Skrij orodno vrstico',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Brskalnik je treba posodobiti',
							'desc'  => 'Vaš brskalnik ne podpira govorne sinteze. Posodobite svoj brskalnik ali uporabite takšnega, ki podpira govor (npr. Chrome, Edge, Safari).',
							'link'  => 'Kako posodobiti?',
						),
						'header'                 => array(
							'language'      => 'Slovenščina',
							'listLanguages' => $list_languages,
							'title'         => 'Nastavitve dostopnosti',
							'desc'          => 'Narejeno',
							'anchor'        => 'OneTap',
							'statement'     => 'Izjava',
							'hideToolbar'   => 'Skrij orodno vrstico',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Izberite svoj dostopnostni profil',
							'visionImpairedMode' => array(
								'title' => 'Način za motnje vida',
								'desc'  => 'Izboljša vizualne elemente spletnega mesta',
								'on'    => 'UKLOP',
								'off'   => 'IZKLOP',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil za varnost pred napadi',
								'desc'  => 'Zmanjša utripajoče luči in izboljša barve',
								'on'    => 'UKLOP',
								'off'   => 'IZKLOP',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Način, prijazen za ADHD',
								'desc'  => 'Osredotočena navigacija brez motenj',
								'on'    => 'UKLOP',
								'off'   => 'IZKLOP',
							),
							'blindnessMode'      => array(
								'title' => 'Način za slepoto',
								'desc'  => 'Zmanjša motnje in izboljša osredotočenost',
								'on'    => 'UKLOP',
								'off'   => 'IZKLOP',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Način varnosti pred epilepsijo',
								'desc'  => 'Zmanjša barve in ustavi utripanje',
								'on'    => 'UKLOP',
								'off'   => 'IZKLOP',
							),
						),
						'content'                => array(
							'biggerText'    => 'Večji besedilo',
							'cursor'        => 'Kazalec',
							'lineHeight'    => 'Višina vrstice',
							'letterSpacing' => 'Razmik med črkami',
							'readableFont'  => 'Bralna pisava',
							'dyslexicFont'  => 'Pisava za disleksijo',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Poravnava besedila',
							'textMagnifier'  => 'Lupa besedila',
							'highlightLinks' => 'Poudari povezave',
						),
						'colors'                 => array(
							'invertColors' => 'Obrni barve',
							'brightness'   => 'Svetlost',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Siva skala',
							'saturation'   => 'Saturacija',
						),
						'orientation'            => array(
							'readingLine'        => 'Bralna linija',
							'keyboardNavigation' => 'Navigacija s tipkovnico',
							'highlightTitles'    => 'Poudari naslove',
							'readingMask'        => 'Maska za branje',
							'hideImages'         => 'Skrij slike',
							'highlightAll'       => 'Poudari vse',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Preberi stran',
							'muteSounds'     => 'Utišaj zvoke',
							'stopAnimations' => 'Zaustavi animacije',
						),
						'divider'                => array(
							'content'    => 'Vsebina',
							'colors'     => 'Barve',
							'navigation' => 'Navigacija',
						),
						'resetSettings'          => 'Ponastavi nastavitve',
						'footer'                 => array(
							'accessibilityStatement' => 'Izjava o dostopnosti',
							'version'                => 'Različica ' . $plugin_version,
						),
					),
					'sk'    => array(
						'global'                 => array(
							'back' => 'Späť',
						),
						'hideToolbar'            => array(
							'title'   => 'Ako dlho chcete skryť panel prístupnosti?',
							'radio1'  => 'Len pre toto sedenie',
							'radio2'  => '24 hodín',
							'radio3'  => 'Jeden týždeň',
							'button1' => 'Nie teraz',
							'button2' => 'Skryť panel',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Prehliadač je potrebné aktualizovať',
							'desc'  => 'Váš prehliadač nepodporuje výstup reči. Aktualizujte prehliadač alebo použite taký, ktorý podporuje syntézu reči (napr. Chrome, Edge, Safari).',
							'link'  => 'Ako aktualizovať?',
						),
						'header'                 => array(
							'language'      => 'Slovenčina',
							'listLanguages' => $list_languages,
							'title'         => 'Nastavenia prístupnosti',
							'desc'          => 'Vytvorené',
							'anchor'        => 'OneTap',
							'statement'     => 'Vyhlásenie',
							'hideToolbar'   => 'Skryť panel nástrojov',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Vyberte svoj profil prístupnosti',
							'visionImpairedMode' => array(
								'title' => 'Režim pre zrakové postihnutie',
								'desc'  => 'Vylepšuje vizuálne prvky stránky',
								'on'    => 'AKTIVOVANÉ',
								'off'   => 'DEAKTIVOVANÉ',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil pre bezpečnosť pred záchvatmi',
								'desc'  => 'Znižuje blikanie a zlepšuje farby',
								'on'    => 'AKTIVOVANÉ',
								'off'   => 'DEAKTIVOVANÉ',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Režim priateľský k ADHD',
								'desc'  => 'Zameraná navigácia bez rozptýlení',
								'on'    => 'AKTIVOVANÉ',
								'off'   => 'DEAKTIVOVANÉ',
							),
							'blindnessMode'      => array(
								'title' => 'Režim pre slepotu',
								'desc'  => 'Znižuje rozptýlenia a zlepšuje koncentráciu',
								'on'    => 'AKTIVOVANÉ',
								'off'   => 'DEAKTIVOVANÉ',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Režim bezpečný pre epilepsiu',
								'desc'  => 'Znižuje farby a zastavuje blikanie',
								'on'    => 'AKTIVOVANÉ',
								'off'   => 'DEAKTIVOVANÉ',
							),
						),
						'content'                => array(
							'biggerText'    => 'Bigger text',
							'cursor'        => 'Kurzor',
							'lineHeight'    => 'Výška riadku',
							'letterSpacing' => 'Medzera medzi písmenami',
							'readableFont'  => 'Čitateľný font',
							'dyslexicFont'  => 'Font pre dyslexiu',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Zarovnanie textu',
							'textMagnifier'  => 'Lupa textu',
							'highlightLinks' => 'Zvýrazniť odkazy',
						),
						'colors'                 => array(
							'invertColors' => 'Invertovať farby',
							'brightness'   => 'Jas',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Šedý odtieň',
							'saturation'   => 'Saturácia',
						),
						'orientation'            => array(
							'readingLine'        => 'Čítacia línia',
							'keyboardNavigation' => 'Navigácia pomocou klávesnice',
							'highlightTitles'    => 'Zvýrazniť nadpisy',
							'readingMask'        => 'Maska na čítanie',
							'hideImages'         => 'Skryť obrázky',
							'highlightAll'       => 'Zvýrazniť všetko',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Prečítajte stránku',
							'muteSounds'     => 'Stlmiť zvuky',
							'stopAnimations' => 'Zastaviť animácie',
						),
						'divider'                => array(
							'content'    => 'Obsah',
							'colors'     => 'Farby',
							'navigation' => 'Navigácia',
						),
						'resetSettings'          => 'Obnoviť nastavenia',
						'footer'                 => array(
							'accessibilityStatement' => 'Vyhlásenie o prístupnosti',
							'version'                => 'Verzia ' . $plugin_version,
						),
					),
					'nl'    => array(
						'global'                 => array(
							'back' => 'Terug',
						),
						'hideToolbar'            => array(
							'title'   => 'Hoe lang wilt u de toegankelijkheidstoolbalk verbergen?',
							'radio1'  => 'Alleen voor deze sessie',
							'radio2'  => '24 uur',
							'radio3'  => 'Een week',
							'button1' => 'Niet nu',
							'button2' => 'Verberg werkbalk',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browser moet worden bijgewerkt',
							'desc'  => 'Je browser ondersteunt geen spraaksynthese. Werk je browser bij of gebruik een browser die spraaksynthese ondersteunt (bijv. Chrome, Edge, Safari).',
							'link'  => 'Hoe bijwerken?',
						),
						'header'                 => array(
							'language'      => 'Nederlands',
							'listLanguages' => $list_languages,
							'title'         => 'Toegankelijkheidsinstellingen',
							'desc'          => 'Gemaakt door',
							'anchor'        => 'OneTap',
							'statement'     => 'Verklaring',
							'hideToolbar'   => 'Werkbalk verbergen',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Kies je toegankelijkheidsprofiel',
							'visionImpairedMode' => array(
								'title' => 'Modus voor visuele beperkingen',
								'desc'  => 'Verbetert de visuele elementen van de website',
								'on'    => 'INGESCHAKELD',
								'off'   => 'UITGESCHAKELD',
							),
							'seizureSafeProfile' => array(
								'title' => 'Veiligheidsprofiel voor aanvallen',
								'desc'  => 'Vermindert knipperende lichten en verbetert de kleuren',
								'on'    => 'INGESCHAKELD',
								'off'   => 'UITGESCHAKELD',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-vriendelijke modus',
								'desc'  => 'Gefocuste navigatie zonder afleidingen',
								'on'    => 'INGESCHAKELD',
								'off'   => 'UITGESCHAKELD',
							),
							'blindnessMode'      => array(
								'title' => 'Modus voor blindheid',
								'desc'  => 'Vermindert afleidingen en verbetert de focus',
								'on'    => 'INGESCHAKELD',
								'off'   => 'UITGESCHAKELD',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Veilige modus voor epilepsie',
								'desc'  => 'Vermindert kleuren en stopt knipperen',
								'on'    => 'INGESCHAKELD',
								'off'   => 'UITGESCHAKELD',
							),
						),
						'content'                => array(
							'biggerText'    => 'Grotere tekst',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Regelhoogte',
							'letterSpacing' => 'Letterafstand',
							'readableFont'  => 'Leesbaar lettertype',
							'dyslexicFont'  => 'Lettertype voor dyslexie',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Tekstuitlijning',
							'textMagnifier'  => 'Tekst vergrootglas',
							'highlightLinks' => 'Markeer links',
						),
						'colors'                 => array(
							'invertColors' => 'Kleuren omdraaien',
							'brightness'   => 'Helderheid',
							'contrast'     => 'Contrast',
							'grayscale'    => 'Grijstinten',
							'saturation'   => 'Verzadiging',
						),
						'orientation'            => array(
							'readingLine'        => 'Leeslijn',
							'keyboardNavigation' => 'Navigatie via toetsenbord',
							'highlightTitles'    => 'Markeer titels',
							'readingMask'        => 'Leesmasker',
							'hideImages'         => 'Verberg afbeeldingen',
							'highlightAll'       => 'Markeer alles',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Lees pagina',
							'muteSounds'     => 'Geluiden dempen',
							'stopAnimations' => 'Stop animaties',
						),
						'divider'                => array(
							'content'    => 'Inhoud',
							'colors'     => 'Kleuren',
							'navigation' => 'Navigatie',
						),
						'resetSettings'          => 'Instellingen herstellen',
						'footer'                 => array(
							'accessibilityStatement' => 'Toegankelijkheidsverklaring',
							'version'                => 'Versie ' . $plugin_version,
						),
					),
					'dk'    => array(
						'global'                 => array(
							'back' => 'Tilbage',
						),
						'hideToolbar'            => array(
							'title'   => 'Hvor længe vil du skjule tilgængelighedsværktøjslinjen?',
							'radio1'  => 'Kun for denne session',
							'radio2'  => '24 timer',
							'radio3'  => 'En uge',
							'button1' => 'Ikke nu',
							'button2' => 'Skjul værktøjslinje',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browseren skal opdateres',
							'desc'  => 'Din browser understøtter ikke taleoutput. Opdater din browser, eller brug en med understøttelse af talesyntese (f.eks. Chrome, Edge, Safari).',
							'link'  => 'Sådan opdaterer du?',
						),
						'header'                 => array(
							'language'      => 'Dansk',
							'listLanguages' => $list_languages,
							'title'         => 'Tilgængelighedsindstillinger',
							'desc'          => 'Oprettet af',
							'anchor'        => 'OneTap',
							'statement'     => 'Erklæring',
							'hideToolbar'   => 'Skjul værktøjslinje',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Vælg din tilgængelighedsprofil',
							'visionImpairedMode' => array(
								'title' => 'Tilstand for synshandicap',
								'desc'  => 'Forbedrer de visuelle elementer på siden',
								'on'    => 'TÆNDT',
								'off'   => 'SLUKKET',
							),
							'seizureSafeProfile' => array(
								'title' => 'Sikkerhedsprofil for anfald',
								'desc'  => 'Reducerer blink og forbedrer farverne',
								'on'    => 'TÆNDT',
								'off'   => 'SLUKKET',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-venlig tilstand',
								'desc'  => 'Fokuseret navigation uden forstyrrelser',
								'on'    => 'TÆNDT',
								'off'   => 'SLUKKET',
							),
							'blindnessMode'      => array(
								'title' => 'Tilstand for blindhed',
								'desc'  => 'Reducerer distraktioner og forbedrer fokus',
								'on'    => 'TÆNDT',
								'off'   => 'SLUKKET',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Sikker tilstand for epilepsi',
								'desc'  => 'Reducerer farver og stopper blinkning',
								'on'    => 'TÆNDT',
								'off'   => 'SLUKKET',
							),
						),
						'content'                => array(
							'biggerText'    => 'Større tekst',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Linjehøjde',
							'letterSpacing' => 'Bogstavafstand',
							'readableFont'  => 'Læsbar skrifttype',
							'dyslexicFont'  => 'Skrifttype til dysleksi',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Tekstjustering',
							'textMagnifier'  => 'Tekstforstørrelse',
							'highlightLinks' => 'Fremhæv links',
						),
						'colors'                 => array(
							'invertColors' => 'Inverter farver',
							'brightness'   => 'Lysstyrke',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Gråtoner',
							'saturation'   => 'Mætning',
						),
						'orientation'            => array(
							'readingLine'        => 'Læselinje',
							'keyboardNavigation' => 'Tastaturnavigation',
							'highlightTitles'    => 'Fremhæv titler',
							'readingMask'        => 'Læsemask',
							'hideImages'         => 'Skjul billeder',
							'highlightAll'       => 'Fremhæv alt',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Læs side',
							'muteSounds'     => 'Lydløs',
							'stopAnimations' => 'Stop animationer',
						),
						'divider'                => array(
							'content'    => 'Indhold',
							'colors'     => 'Farver',
							'navigation' => 'Navigation',
						),
						'resetSettings'          => 'Nulstil indstillinger',
						'footer'                 => array(
							'accessibilityStatement' => 'Erklæring om tilgængelighed',
							'version'                => 'Version ' . $plugin_version,
						),
					),
					'gr'    => array(
						'global'                 => array(
							'back' => 'Πίσω',
						),
						'hideToolbar'            => array(
							'title'   => 'Για πόσο καιρό θέλετε να αποκρύψετε τη γραμμή προσβασιμότητας;',
							'radio1'  => 'Μόνο για αυτή τη συνεδρία',
							'radio2'  => '24 ώρες',
							'radio3'  => 'Μία εβδομάδα',
							'button1' => 'Όχι τώρα',
							'button2' => 'Απόκρυψη γραμμής εργαλείων',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Το πρόγραμμα περιήγησης χρειάζεται ενημέρωση',
							'desc'  => 'Το πρόγραμμα περιήγησής σας δεν υποστηρίζει έξοδο ομιλίας. Ενημερώστε το ή χρησιμοποιήστε ένα πρόγραμμα περιήγησης με ενεργοποιημένη σύνθεση φωνής (π.χ. Chrome, Edge, Safari).',
							'link'  => 'Πώς να το ενημερώσετε;',
						),
						'header'                 => array(
							'language'      => 'Ελληνικά',
							'listLanguages' => $list_languages,
							'title'         => 'Ρυθμίσεις Προσβασιμότητας',
							'desc'          => 'Δημιουργήθηκε από',
							'anchor'        => 'OneTap',
							'statement'     => 'Δήλωση',
							'hideToolbar'   => 'Απόκρυψη γραμμής εργαλείων',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Επιλέξτε το προφίλ προσβασιμότητας σας',
							'visionImpairedMode' => array(
								'title' => 'Λειτουργία για άτομα με αναπηρία όρασης',
								'desc'  => 'Βελτιώνει τα οπτικά στοιχεία της σελίδας',
								'on'    => 'ΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
								'off'   => 'ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
							),
							'seizureSafeProfile' => array(
								'title' => 'Προφίλ ασφαλείας για επιληψία',
								'desc'  => 'Μειώνει τις αναλαμπές και βελτιώνει τα χρώματα',
								'on'    => 'ΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
								'off'   => 'ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Λειτουργία φιλική προς ADHD',
								'desc'  => 'Εστιασμένη πλοήγηση χωρίς περισπασμούς',
								'on'    => 'ΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
								'off'   => 'ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
							),
							'blindnessMode'      => array(
								'title' => 'Λειτουργία για τύφλωση',
								'desc'  => 'Μειώνει τις περισπασμούς και βελτιώνει τη συγκέντρωση',
								'on'    => 'ΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
								'off'   => 'ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Ασφαλής λειτουργία για επιληψία',
								'desc'  => 'Μειώνει τα χρώματα και σταματά τις αναλαμπές',
								'on'    => 'ΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
								'off'   => 'ΑΠΕΝΕΡΓΟΠΟΙΗΜΕΝΟ',
							),
						),
						'content'                => array(
							'biggerText'    => 'Μεγαλύτερη γραμματοσειρά',
							'cursor'        => 'Δείκτης',
							'lineHeight'    => 'Ύψος γραμμής',
							'letterSpacing' => 'Απόσταση γραμμάτων',
							'readableFont'  => 'Ευανάγνωστη γραμματοσειρά',
							'dyslexicFont'  => 'Γραμματοσειρά για δυσλεξία',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Στοίχιση κειμένου',
							'textMagnifier'  => 'Μεγεθυντικό φακό κειμένου',
							'highlightLinks' => 'Επισήμανση συνδέσμων',
						),
						'colors'                 => array(
							'invertColors' => 'Αντιστροφή χρωμάτων',
							'brightness'   => 'Φωτεινότητα',
							'contrast'     => 'Αντίθεση',
							'grayscale'    => 'Ασπρόμαυρο',
							'saturation'   => 'Κορεσμός',
						),
						'orientation'            => array(
							'readingLine'        => 'Γραμμή ανάγνωσης',
							'keyboardNavigation' => 'Πλοήγηση μέσω πληκτρολογίου',
							'highlightTitles'    => 'Επισήμανση τίτλων',
							'readingMask'        => 'Μάσκα ανάγνωσης',
							'hideImages'         => 'Απόκρυψη εικόνων',
							'highlightAll'       => 'Επισήμανση όλων',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Διαβάστε τη σελίδα',
							'muteSounds'     => 'Απενεργοποίηση ήχου',
							'stopAnimations' => 'Σταματήστε τις κινούμενες εικόνες',
						),
						'divider'                => array(
							'content'    => 'Περιεχόμενο',
							'colors'     => 'Χρώματα',
							'navigation' => 'Πλοήγηση',
						),
						'resetSettings'          => 'Επαναφορά ρυθμίσεων',
						'footer'                 => array(
							'accessibilityStatement' => 'Δήλωση προσβασιμότητας',
							'version'                => 'Έκδοση ' . $plugin_version,
						),
					),
					'cz'    => array(
						'global'                 => array(
							'back' => 'Zpět',
						),
						'hideToolbar'            => array(
							'title'   => 'Na jak dlouho chcete skrýt panel usnadnění?',
							'radio1'  => 'Pouze pro tuto relaci',
							'radio2'  => '24 hodin',
							'radio3'  => 'Jeden týden',
							'button1' => 'Teď ne',
							'button2' => 'Skrýt panel',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Prohlížeč je třeba aktualizovat',
							'desc'  => 'Váš prohlížeč nepodporuje výstup řeči. Aktualizujte jej nebo použijte prohlížeč, který podporuje syntézu řeči (např. Chrome, Edge, Safari).',
							'link'  => 'Jak aktualizovat?',
						),
						'header'                 => array(
							'language'      => 'Čeština',
							'listLanguages' => $list_languages,
							'title'         => 'Nastavení přístupnosti',
							'desc'          => 'Vytvořeno',
							'anchor'        => 'OneTap',
							'statement'     => 'Prohlášení',
							'hideToolbar'   => 'Skrýt panel nástrojů',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Vyberte svůj přístupnostní profil',
							'visionImpairedMode' => array(
								'title' => 'Režim pro zrakově postižené',
								'desc'  => 'Zlepšuje vizuální prvky na stránce',
								'on'    => 'ZAŠKRTNUTO',
								'off'   => 'NEZAŠKRTNUTO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Bezpečný profil pro epilepsii',
								'desc'  => 'Snižuje blikání a zlepšuje barvy',
								'on'    => 'ZAŠKRTNUTO',
								'off'   => 'NEZAŠKRTNUTO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Režim přátelský k ADHD',
								'desc'  => 'Soustředěná navigace bez rozptýlení',
								'on'    => 'ZAŠKRTNUTO',
								'off'   => 'NEZAŠKRTNUTO',
							),
							'blindnessMode'      => array(
								'title' => 'Režim pro slepotu',
								'desc'  => 'Snižuje rozptýlení a zlepšuje soustředění',
								'on'    => 'ZAŠKRTNUTO',
								'off'   => 'NEZAŠKRTNUTO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Bezpečný režim pro epilepsii',
								'desc'  => 'Snižuje barvy a zastavuje blikání',
								'on'    => 'ZAŠKRTNUTO',
								'off'   => 'NEZAŠKRTNUTO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Větší písmo',
							'cursor'        => 'Ukazatel',
							'lineHeight'    => 'Výška řádku',
							'letterSpacing' => 'Mezera mezi písmeny',
							'readableFont'  => 'Čitelný font',
							'dyslexicFont'  => 'Font pro dyslexii',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Zarovnání textu',
							'textMagnifier'  => 'Lupa na text',
							'highlightLinks' => 'Zvýraznění odkazů',
						),
						'colors'                 => array(
							'invertColors' => 'Invertovat barvy',
							'brightness'   => 'Jas',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Šedé tóny',
							'saturation'   => 'Sytost',
						),
						'orientation'            => array(
							'readingLine'        => 'Čtecí linka',
							'keyboardNavigation' => 'Navigace klávesnicí',
							'highlightTitles'    => 'Zvýraznit titulky',
							'readingMask'        => 'Čtecí maska',
							'hideImages'         => 'Skrýt obrázky',
							'highlightAll'       => 'Zvýraznit vše',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Přečíst stránku',
							'muteSounds'     => 'Ztlumit zvuky',
							'stopAnimations' => 'Zastavit animace',
						),
						'divider'                => array(
							'content'    => 'Obsah',
							'colors'     => 'Barvy',
							'navigation' => 'Navigace',
						),
						'resetSettings'          => 'Obnovit nastavení',
						'footer'                 => array(
							'accessibilityStatement' => 'Prohlášení o přístupnosti',
							'version'                => 'Verze ' . $plugin_version,
						),
					),
					'hu'    => array(
						'global'                 => array(
							'back' => 'Vissza',
						),
						'hideToolbar'            => array(
							'title'   => 'Meddig szeretné elrejteni az akadálymentesítési eszköztárat?',
							'radio1'  => 'Csak erre a munkamenetre',
							'radio2'  => '24 óra',
							'radio3'  => 'Egy hét',
							'button1' => 'Most nem',
							'button2' => 'Eszköztár elrejtése',
						),
						'unsupportedPageReader'  => array(
							'title' => 'A böngészőt frissíteni kell',
							'desc'  => 'A böngésző nem támogatja a beszédhang-kimenetet. Frissítse a böngészőt, vagy használjon olyat, amely támogatja a beszédfelismerést (pl. Chrome, Edge, Safari).',
							'link'  => 'Hogyan frissítsem?',
						),
						'header'                 => array(
							'language'      => 'Magyar',
							'listLanguages' => $list_languages,
							'title'         => 'Hozzáférhetőségi beállítások',
							'desc'          => 'Készítette',
							'anchor'        => 'OneTap',
							'statement'     => 'Nyilatkozat',
							'hideToolbar'   => 'Eszköztár elrejtése',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Válassza ki hozzáférhetőségi profilját',
							'visionImpairedMode' => array(
								'title' => 'Látássérült mód',
								'desc'  => 'Javítja az oldal vizuális elemeit',
								'on'    => 'BE',
								'off'   => 'KI',
							),
							'seizureSafeProfile' => array(
								'title' => 'Biztonságos profil epilepsziásoknak',
								'desc'  => 'Csökkenti a villogást és javítja a színeket',
								'on'    => 'BE',
								'off'   => 'KI',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-barát mód',
								'desc'  => 'Fókuszált navigáció zavaró tényezők nélkül',
								'on'    => 'BE',
								'off'   => 'KI',
							),
							'blindnessMode'      => array(
								'title' => 'Vak mód',
								'desc'  => 'Csökkenti a zavaró tényezőket és javítja a fókuszt',
								'on'    => 'BE',
								'off'   => 'KI',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Biztonságos epilepsziás mód',
								'desc'  => 'Csökkenti a színeket és megállítja a villogást',
								'on'    => 'BE',
								'off'   => 'KI',
							),
						),
						'content'                => array(
							'biggerText'    => 'Nagyobb szöveg',
							'cursor'        => 'Kurzor',
							'lineHeight'    => 'Sormagasság',
							'letterSpacing' => 'Betűköz',
							'readableFont'  => 'Olvasható betűtípus',
							'dyslexicFont'  => 'Diszlexiás betűtípus',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Szöveg igazítása',
							'textMagnifier'  => 'Szöveg nagyító',
							'highlightLinks' => 'Linkek kiemelése',
						),
						'colors'                 => array(
							'invertColors' => 'Színek megfordítása',
							'brightness'   => 'Fényerő',
							'contrast'     => 'Kontraszt',
							'grayscale'    => 'Szürkeárnyalat',
							'saturation'   => 'Telítettség',
						),
						'orientation'            => array(
							'readingLine'        => 'Olvasási vonal',
							'keyboardNavigation' => 'Billentyűzet navigáció',
							'highlightTitles'    => 'Címek kiemelése',
							'readingMask'        => 'Olvasási maszk',
							'hideImages'         => 'Képek elrejtése',
							'highlightAll'       => 'Mindent kiemelni',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Oldal olvasása',
							'muteSounds'     => 'Hangok némítása',
							'stopAnimations' => 'Animációk leállítása',
						),
						'divider'                => array(
							'content'    => 'Tartalom',
							'colors'     => 'Színek',
							'navigation' => 'Navigáció',
						),
						'resetSettings'          => 'Beállítások visszaállítása',
						'footer'                 => array(
							'accessibilityStatement' => 'Hozzáférhetőségi nyilatkozat',
							'version'                => 'Verzió ' . $plugin_version,
						),
					),
					'lt'    => array(
						'global'                 => array(
							'back' => 'Atgal',
						),
						'hideToolbar'            => array(
							'title'   => 'Kiek laiko norite slėpti prieinamumo įrankių juostą?',
							'radio1'  => 'Tik šiai sesijai',
							'radio2'  => '24 valandos',
							'radio3'  => 'Savaitė',
							'button1' => 'Ne dabar',
							'button2' => 'Slėpti juostą',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Naršyklę reikia atnaujinti',
							'desc'  => 'Jūsų naršyklė nepalaiko kalbos sintezės. Atnaujinkite naršyklę arba naudokite tokią, kuri palaiko kalbos sintezę (pvz., Chrome, Edge, Safari).',
							'link'  => 'Kaip atnaujinti?',
						),
						'header'                 => array(
							'language'      => 'Lietuvių',
							'listLanguages' => $list_languages,
							'title'         => 'Prieigos nustatymai',
							'desc'          => 'Sukūrė',
							'anchor'        => 'OneTap',
							'statement'     => 'Pareiškimas',
							'hideToolbar'   => 'Slėpti įrankių juostą',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Pasirinkite savo prieigos profilį',
							'visionImpairedMode' => array(
								'title' => 'Regėjimo sutrikimo režimas',
								'desc'  => 'Gerina vizualinius elementus puslapyje',
								'on'    => 'ĮJUNGTA',
								'off'   => 'IŠJUNGTA',
							),
							'seizureSafeProfile' => array(
								'title' => 'Saugi profilis epilepsijai',
								'desc'  => 'Mažina mirgėjimą ir gerina spalvas',
								'on'    => 'ĮJUNGTA',
								'off'   => 'IŠJUNGTA',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD draugiškas režimas',
								'desc'  => 'Fokusavimas be trikdžių',
								'on'    => 'ĮJUNGTA',
								'off'   => 'IŠJUNGTA',
							),
							'blindnessMode'      => array(
								'title' => 'Aklojo režimas',
								'desc'  => 'Mažina trikdžius ir gerina dėmesį',
								'on'    => 'ĮJUNGTA',
								'off'   => 'IŠJUNGTA',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsijai saugus režimas',
								'desc'  => 'Mažina spalvas ir sustabdo mirgėjimą',
								'on'    => 'ĮJUNGTA',
								'off'   => 'IŠJUNGTA',
							),
						),
						'content'                => array(
							'biggerText'    => 'Didesnis tekstas',
							'cursor'        => 'Kursorius',
							'lineHeight'    => 'Eilutės aukštis',
							'letterSpacing' => 'Rašto tarpai',
							'readableFont'  => 'Lengvai skaitomas šriftas',
							'dyslexicFont'  => 'Dysleksijai pritaikytas šriftas',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Teksto išlygiavimas',
							'textMagnifier'  => 'Teksto didinamoji lupa',
							'highlightLinks' => 'Nuorodų paryškinimas',
						),
						'colors'                 => array(
							'invertColors' => 'Inversuoti spalvas',
							'brightness'   => 'Šviesumas',
							'contrast'     => 'Kontrastas',
							'grayscale'    => 'Pilka spalvų gama',
							'saturation'   => 'Sotinimas',
						),
						'orientation'            => array(
							'readingLine'        => 'Skaitymo linija',
							'keyboardNavigation' => 'Klaviatūros navigacija',
							'highlightTitles'    => 'Antraščių paryškinimas',
							'readingMask'        => 'Skaitymo uždanga',
							'hideImages'         => 'Slėpti nuotraukas',
							'highlightAll'       => 'Paryškinti viską',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Skaityti puslapį',
							'muteSounds'     => 'Nutilinti garsus',
							'stopAnimations' => 'Sustabdyti animacijas',
						),
						'divider'                => array(
							'content'    => 'Turinys',
							'colors'     => 'Spalvos',
							'navigation' => 'Navigacija',
						),
						'resetSettings'          => 'Atstatyti nustatymus',
						'footer'                 => array(
							'accessibilityStatement' => 'Prieigos deklaracija',
							'version'                => 'Versija ' . $plugin_version,
						),
					),
					'lv'    => array(
						'global'                 => array(
							'back' => 'Atpakaļ',
						),
						'hideToolbar'            => array(
							'title'   => 'Cik ilgi vēlaties paslēpt piekļūstamības rīkjoslu?',
							'radio1'  => 'Tikai šai sesijai',
							'radio2'  => '24 stundas',
							'radio3'  => 'Nedēļu',
							'button1' => 'Ne tagad',
							'button2' => 'Paslēpt rīkjoslu',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Pārlūkprogramma ir jāatjaunina',
							'desc'  => 'Jūsu pārlūkprogramma neatbalsta runas sintezatoru. Lūdzu, atjauniniet pārlūkprogrammu vai izmantojiet tādu, kas atbalsta runas sintēzi (piemēram, Chrome, Edge, Safari).',
							'link'  => 'Kā atjaunināt?',
						),
						'header'                 => array(
							'language'      => 'Latviešu',
							'listLanguages' => $list_languages,
							'title'         => 'Piekļuves iestatījumi',
							'desc'          => 'Izveidojis',
							'anchor'        => 'OneTap',
							'statement'     => 'Paziņojums',
							'hideToolbar'   => 'Slēpt rīkjoslu',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Izvēlieties savu piekļuves profilu',
							'visionImpairedMode' => array(
								'title' => 'Redzes traucējumu režīms',
								'desc'  => 'Uzlabos vizuālos elementus lapā',
								'on'    => 'IESLĒGTS',
								'off'   => 'IZSLĒGTS',
							),
							'seizureSafeProfile' => array(
								'title' => 'Drošais profils epilepsijas gadījumā',
								'desc'  => 'Samazina mirgošanu un uzlabo krāsas',
								'on'    => 'IESLĒGTS',
								'off'   => 'IZSLĒGTS',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD draudzīgs režīms',
								'desc'  => 'Fokusēta navigācija bez traucējumiem',
								'on'    => 'IESLĒGTS',
								'off'   => 'IZSLĒGTS',
							),
							'blindnessMode'      => array(
								'title' => 'Aklo režīms',
								'desc'  => 'Samazina traucējošos elementus un uzlabo fokusu',
								'on'    => 'IESLĒGTS',
								'off'   => 'IZSLĒGTS',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Drošais režīms epilepsijas gadījumā',
								'desc'  => 'Samazina krāsas un aptur mirgošanu',
								'on'    => 'IESLĒGTS',
								'off'   => 'IZSLĒGTS',
							),
						),
						'content'                => array(
							'biggerText'    => 'Lielāks teksts',
							'cursor'        => 'Kursors',
							'lineHeight'    => 'Rindas augstums',
							'letterSpacing' => 'Burbu attālums',
							'readableFont'  => 'Lasāms fonts',
							'dyslexicFont'  => 'Dysleksijas fonts',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Teksta izlīdzinājums',
							'textMagnifier'  => 'Teksta palielinātājs',
							'highlightLinks' => 'Saistītās saites izcelšana',
						),
						'colors'                 => array(
							'invertColors' => 'Krāsu inversija',
							'brightness'   => 'Spilgtums',
							'contrast'     => 'Kontrasts',
							'grayscale'    => 'Pelēktoņu režīms',
							'saturation'   => 'Saturācija',
						),
						'orientation'            => array(
							'readingLine'        => 'Lasīšanas līnija',
							'keyboardNavigation' => 'Navigācija, izmantojot tastatūru',
							'highlightTitles'    => 'Virsrakstu izcelšana',
							'readingMask'        => 'Lasīšanas maska',
							'hideImages'         => 'Slēpt attēlus',
							'highlightAll'       => 'Izcelt visu',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Lasīt lapu',
							'muteSounds'     => 'Izslēgt skaņas',
							'stopAnimations' => 'Pārtraukt animācijas',
						),
						'divider'                => array(
							'content'    => 'Saturs',
							'colors'     => 'Krāsas',
							'navigation' => 'Navigācija',
						),
						'resetSettings'          => 'Atiestatīt iestatījumus',
						'footer'                 => array(
							'accessibilityStatement' => 'Piekļuves deklarācija',
							'version'                => 'Versija ' . $plugin_version,
						),
					),
					'ee'    => array(
						'global'                 => array(
							'back' => 'Tagasi',
						),
						'hideToolbar'            => array(
							'title'   => 'Kui kauaks soovite juurdepääsetavuse tööriistariba peita?',
							'radio1'  => 'Ainult selleks seansiks',
							'radio2'  => '24 tundi',
							'radio3'  => 'Üheks nädalaks',
							'button1' => 'Mitte praegu',
							'button2' => 'Peida tööriistariba',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Brauserit tuleb uuendada',
							'desc'  => 'Teie brauser ei toeta kõneväljundit. Palun uuendage oma brauserit või kasutage sellist, mis toetab kõnesüntesaatorit (nt Chrome, Edge, Safari).',
							'link'  => 'Kuidas uuendada?',
						),
						'header'                 => array(
							'language'      => 'Eesti',
							'listLanguages' => $list_languages,
							'title'         => 'Juurdepääsu seaded',
							'desc'          => 'Loodud',
							'anchor'        => 'OneTap',
							'statement'     => 'Avaldus',
							'hideToolbar'   => 'Peida tööriistariba',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Valige oma ligipääsu profiil',
							'visionImpairedMode' => array(
								'title' => 'Nägemispuude režiim',
								'desc'  => 'Parandab visuaalseid elemente lehelt',
								'on'    => 'SEES',
								'off'   => 'VÄLJAS',
							),
							'seizureSafeProfile' => array(
								'title' => 'Epilepsiatõve profiil',
								'desc'  => 'Vähendab vilkumist ja parandab värve',
								'on'    => 'SEES',
								'off'   => 'VÄLJAS',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD sõbralik režiim',
								'desc'  => 'Parandab fookust ilma segajateta',
								'on'    => 'SEES',
								'off'   => 'VÄLJAS',
							),
							'blindnessMode'      => array(
								'title' => 'Pimeduse režiim',
								'desc'  => 'Vähendab häirivaid elemente ja parandab tähelepanu',
								'on'    => 'SEES',
								'off'   => 'VÄLJAS',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsia ohutu režiim',
								'desc'  => 'Vähendab värve ja peatab vilkumise',
								'on'    => 'SEES',
								'off'   => 'VÄLJAS',
							),
						),
						'content'                => array(
							'biggerText'    => 'Suurem tekst',
							'cursor'        => 'Kursor',
							'lineHeight'    => 'Ridade kõrgus',
							'letterSpacing' => 'Tähe vaheline kaugus',
							'readableFont'  => 'Lugemisväline font',
							'dyslexicFont'  => 'Düslia font',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Teksti joondus',
							'textMagnifier'  => 'Teksti suurendaja',
							'highlightLinks' => 'Linkide esiletõstmine',
						),
						'colors'                 => array(
							'invertColors' => 'Keerata värvid ümber',
							'brightness'   => 'Heledus',
							'contrast'     => 'Kontrastsus',
							'grayscale'    => 'Halltooni režiim',
							'saturation'   => 'Küllastus',
						),
						'orientation'            => array(
							'readingLine'        => 'Lugemislus',
							'keyboardNavigation' => 'Klaviatuuri navigeerimine',
							'highlightTitles'    => 'Pealkirjade esiletõstmine',
							'readingMask'        => 'Lugemismask',
							'hideImages'         => 'Peida pildid',
							'highlightAll'       => 'Esiletõsta kõik',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Loe lehekülge',
							'muteSounds'     => 'Keela helid',
							'stopAnimations' => 'Peata animatsioonid',
						),
						'divider'                => array(
							'content'    => 'Sisu',
							'colors'     => 'Värvid',
							'navigation' => 'Navigeerimine',
						),
						'resetSettings'          => 'Lähtesta seaded',
						'footer'                 => array(
							'accessibilityStatement' => 'Ligipääsuvõime avaldus',
							'version'                => 'Versioon ' . $plugin_version,
						),
					),
					'hr'    => array(
						'global'                 => array(
							'back' => 'Natrag',
						),
						'hideToolbar'            => array(
							'title'   => 'Koliko dugo želite sakriti traku za pristupačnost?',
							'radio1'  => 'Samo za ovu sesiju',
							'radio2'  => '24 sata',
							'radio3'  => 'Tjedan dana',
							'button1' => 'Ne sada',
							'button2' => 'Sakrij traku',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Preglednik treba ažurirati',
							'desc'  => 'Vaš preglednik ne podržava govor. Ažurirajte preglednik ili koristite onaj koji podržava sintezu govora (npr. Chrome, Edge, Safari).',
							'link'  => 'Kako ažurirati?',
						),
						'header'                 => array(
							'language'      => 'Hrvatski',
							'listLanguages' => $list_languages,
							'title'         => 'Postavke pristupa',
							'desc'          => 'Izradio',
							'anchor'        => 'OneTap',
							'statement'     => 'Izjava',
							'hideToolbar'   => 'Sakrij alatnu traku',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Odaberite svoj pristupni profil',
							'visionImpairedMode' => array(
								'title' => 'Režim za osobe sa oštećenjem vida',
								'desc'  => 'Poboljšava vizualne elemente na stranici',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Siguran profil za epilepsiju',
								'desc'  => 'Smanjuje treperenje i poboljšava boje',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD prijateljski režim',
								'desc'  => 'Poboljšava fokus bez smetnji',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'blindnessMode'      => array(
								'title' => 'Režim za slijepe',
								'desc'  => 'Smanjuje smetnje i poboljšava fokus',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Siguran režim za epilepsiju',
								'desc'  => 'Smanjuje boje i zaustavlja treperenje',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Veći tekst',
							'cursor'        => 'Kursor',
							'lineHeight'    => 'Visina linije',
							'letterSpacing' => 'Razmak između slova',
							'readableFont'  => 'Čitljiv font',
							'dyslexicFont'  => 'Font za disleksiju',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Poravnanje teksta',
							'textMagnifier'  => 'Povećalo za tekst',
							'highlightLinks' => 'Isticanje poveznica',
						),
						'colors'                 => array(
							'invertColors' => 'Inverzija boja',
							'brightness'   => 'Svjetlina',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Sivi režim',
							'saturation'   => 'Zasićenost',
						),
						'orientation'            => array(
							'readingLine'        => 'Linija za čitanje',
							'keyboardNavigation' => 'Navigacija tipkovnicom',
							'highlightTitles'    => 'Isticanje naslova',
							'readingMask'        => 'Maska za čitanje',
							'hideImages'         => 'Sakrij slike',
							'highlightAll'       => 'Istakni sve',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Čitaj stranicu',
							'muteSounds'     => 'Isključi zvukove',
							'stopAnimations' => 'Zaustavi animacije',
						),
						'divider'                => array(
							'content'    => 'Sadržaj',
							'colors'     => 'Boje',
							'navigation' => 'Navigacija',
						),
						'resetSettings'          => 'Vrati postavke',
						'footer'                 => array(
							'accessibilityStatement' => 'Izjava o pristupačnosti',
							'version'                => 'Verzija ' . $plugin_version,
						),
					),
					'ie'    => array(
						'global'                 => array(
							'back' => 'Siar',
						),
						'hideToolbar'            => array(
							'title'   => 'Cé chomh fada is mian leat an barra inrochtaineachta a cheilt?',
							'radio1'  => 'Ach don seisiún seo amháin',
							'radio2'  => '24 uair an chloig',
							'radio3'  => 'Seachtain amháin',
							'button1' => 'Níl anois',
							'button2' => 'Folaigh an barra',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Your browser needs to be updated',
							'desc'  => 'Your browser does not support speech output. Please update your browser or use one with speech synthesis enabled (e.g. Chrome, Edge, Safari).',
							'link'  => 'How to update?',
						),
						'header'                 => array(
							'language'      => 'Gaeilge',
							'listLanguages' => $list_languages,
							'title'         => 'Socruithe Rochtana',
							'desc'          => 'Tógadh',
							'anchor'        => 'OneTap',
							'statement'     => 'Ráiteas',
							'hideToolbar'   => 'Folaigh an barra uirlisí',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Roghnaigh do phróifíl rochtana',
							'visionImpairedMode' => array(
								'title' => 'Modh do dhaoine le laige sa radharc',
								'desc'  => 'Feabhsaíonn na heilimintí amhairc ar an leathanach',
								'on'    => 'AS',
								'off'   => 'AMACH',
							),
							'seizureSafeProfile' => array(
								'title' => 'Próifíl sábháilte do ghalair scaoileadh',
								'desc'  => 'Ísliú ar na píosaí agus feabhsú na dathanna',
								'on'    => 'AS',
								'off'   => 'AMACH',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Modh comhchuí ADHD',
								'desc'  => 'Feabhsaíonn fócas gan cur isteach',
								'on'    => 'AS',
								'off'   => 'AMACH',
							),
							'blindnessMode'      => array(
								'title' => 'Modh do dhaoine le dall',
								'desc'  => 'Ísliú ar an bhfócas agus foirfeacht ar na heilimintí',
								'on'    => 'AS',
								'off'   => 'AMACH',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Modh sábháilte do eipiléipe',
								'desc'  => 'Ísliú ar na dathanna agus stop sé de na píosaí',
								'on'    => 'AS',
								'off'   => 'AMACH',
							),
						),
						'content'                => array(
							'biggerText'    => 'Téacs Níos Mó',
							'cursor'        => 'Cúrsóir',
							'lineHeight'    => 'Airde Líne',
							'letterSpacing' => 'Spásáil Litreach',
							'readableFont'  => 'Cló Léitheoireachta',
							'dyslexicFont'  => 'Cló do Dhiolachas',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Caidrimh Téacs',
							'textMagnifier'  => 'Méadaí Téacs',
							'highlightLinks' => 'Samhlaigh Ceangail',
						),
						'colors'                 => array(
							'invertColors' => 'Inverter na Dathanna',
							'brightness'   => 'Lúbthacht',
							'contrast'     => 'Difríocht',
							'grayscale'    => 'Modh GrayScale',
							'saturation'   => 'Satail',
						),
						'orientation'            => array(
							'readingLine'        => 'Líne Léitheoireachta',
							'keyboardNavigation' => 'Navigeacht Cnaipe',
							'highlightTitles'    => 'Samhlaigh Teidil',
							'readingMask'        => 'Masg Léitheoireachta',
							'hideImages'         => 'Folaigh Grianghraif',
							'highlightAll'       => 'Samhlaigh gach rud',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Léigh Leathanach',
							'muteSounds'     => 'Áthraigh na Gutha',
							'stopAnimations' => 'Stop Animations',
						),
						'divider'                => array(
							'content'    => 'Ábhar',
							'colors'     => 'Dathanna',
							'navigation' => 'Navigeacht',
						),
						'resetSettings'          => 'Athshocraigh Socruithe',
						'footer'                 => array(
							'accessibilityStatement' => 'Taispeánadh um Rochtain',
							'version'                => 'Leagan ' . $plugin_version,
						),
					),
					'bg'    => array(
						'global'                 => array(
							'back' => 'Назад',
						),
						'hideToolbar'            => array(
							'title'   => 'За колко време искате да скриете лентата за достъпност?',
							'radio1'  => 'Само за тази сесия',
							'radio2'  => '24 часа',
							'radio3'  => 'Една седмица',
							'button1' => 'Не сега',
							'button2' => 'Скрий лентата',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Браузърът трябва да бъде актуализиран',
							'desc'  => 'Вашият браузър не поддържа гласов изход. Моля, актуализирайте го или използвайте такъв с активирана речева синтеза (напр. Chrome, Edge, Safari).',
							'link'  => 'Как да актуализирате?',
						),
						'header'                 => array(
							'language'      => 'Български',
							'listLanguages' => $list_languages,
							'title'         => 'Настройки за достъп',
							'desc'          => 'Създадено от',
							'anchor'        => 'OneTap',
							'statement'     => 'Изявление',
							'hideToolbar'   => 'Скриване на лентата с инструменти',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Изберете вашия достъпен профил',
							'visionImpairedMode' => array(
								'title' => 'Режим за хора с увредено зрение',
								'desc'  => 'Подобряване на визуалните елементи на страницата',
								'on'    => 'ВКЛЮЧЕНО',
								'off'   => 'ИЗКЛЮЧЕНО',
							),
							'seizureSafeProfile' => array(
								'title' => 'Безопасен режим за епилепсия',
								'desc'  => 'Намаляване на мигването и подобряване на цветовете',
								'on'    => 'ВКЛЮЧЕНО',
								'off'   => 'ИЗКЛЮЧЕНО',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Приятелски режим за ADHD',
								'desc'  => 'Подобряване на фокуса без разсейване',
								'on'    => 'ВКЛЮЧЕНО',
								'off'   => 'ИЗКЛЮЧЕНО',
							),
							'blindnessMode'      => array(
								'title' => 'Режим за слепота',
								'desc'  => 'Намаляване на смущаващите елементи и подобряване на фокуса',
								'on'    => 'ВКЛЮЧЕНО',
								'off'   => 'ИЗКЛЮЧЕНО',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Безопасен режим за епилепсия',
								'desc'  => 'Намаляване на цветовете и спиране на мигането',
								'on'    => 'ВКЛЮЧЕНО',
								'off'   => 'ИЗКЛЮЧЕНО',
							),
						),
						'content'                => array(
							'biggerText'    => 'По-голям текст',
							'cursor'        => 'Курсор',
							'lineHeight'    => 'Височина на реда',
							'letterSpacing' => 'Разстояние между буквите',
							'readableFont'  => 'Шрифт за четене',
							'dyslexicFont'  => 'Шрифт за дислексия',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Подравняване на текста',
							'textMagnifier'  => 'Лупа за текст',
							'highlightLinks' => 'Подчертаване на линкове',
						),
						'colors'                 => array(
							'invertColors' => 'Обръщане на цветовете',
							'brightness'   => 'Яркост',
							'contrast'     => 'Контраст',
							'grayscale'    => 'Режим сиви',
							'saturation'   => 'Наситеност',
						),
						'orientation'            => array(
							'readingLine'        => 'Линия за четене',
							'keyboardNavigation' => 'Навигация с клавиатура',
							'highlightTitles'    => 'Подчертаване на заглавия',
							'readingMask'        => 'Маска за четене',
							'hideImages'         => 'Скриване на изображения',
							'highlightAll'       => 'Подчертаване на всички',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Прочетете страницата',
							'muteSounds'     => 'Без звуци',
							'stopAnimations' => 'Спри анимациите',
						),
						'divider'                => array(
							'content'    => 'Съдържание',
							'colors'     => 'Цветове',
							'navigation' => 'Навигация',
						),
						'resetSettings'          => 'Нулиране на настройките',
						'footer'                 => array(
							'accessibilityStatement' => 'Декларация за достъпност',
							'version'                => 'Версия ' . $plugin_version,
						),
					),
					'no'    => array(
						'global'                 => array(
							'back' => 'Tilbake',
						),
						'hideToolbar'            => array(
							'title'   => 'Hvor lenge vil du skjule tilgjengelighetsverktøylinjen?',
							'radio1'  => 'Kun for denne økten',
							'radio2'  => '24 timer',
							'radio3'  => 'En uke',
							'button1' => 'Ikke nå',
							'button2' => 'Skjul verktøylinje',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Nettleseren må oppdateres',
							'desc'  => 'Nettleseren din støtter ikke taleutgang. Oppdater nettleseren eller bruk en som støtter talesyntese (f.eks. Chrome, Edge, Safari).',
							'link'  => 'Hvordan oppdatere?',
						),
						'header'                 => array(
							'language'      => 'Norsk',
							'listLanguages' => $list_languages,
							'title'         => 'Tilgjengelighetsinnstillinger',
							'desc'          => 'Drevet av',
							'anchor'        => 'OneTap',
							'statement'     => 'Erklæring',
							'hideToolbar'   => 'Skjul verktøylinje',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Velg din tilgjengelighetsprofil',
							'visionImpairedMode' => array(
								'title' => 'Synshemmet modus',
								'desc'  => 'Forbedrer nettstedets visuelle utseende',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'seizureSafeProfile' => array(
								'title' => 'Anfallsikker profil',
								'desc'  => 'Fjerner blink og reduserer farger',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD-vennlig modus',
								'desc'  => 'Fokusert og distraksjonsfri surfing',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'blindnessMode'      => array(
								'title' => 'Blindemodus',
								'desc'  => 'Reduserer distraksjoner, forbedrer fokus',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsisikker modus',
								'desc'  => 'Demper farger og stopper blinking',
								'on'    => 'PÅ',
								'off'   => 'AV',
							),
						),
						'content'                => array(
							'biggerText'    => 'Større tekst',
							'cursor'        => 'Markør',
							'lineHeight'    => 'Linjeavstand',
							'letterSpacing' => 'Bokstavavstand',
							'readableFont'  => 'Lesbar skrifttype',
							'dyslexicFont'  => 'Dysleksivennlig skrifttype',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Justering av tekst',
							'textMagnifier'  => 'Tekstforstørrelse',
							'highlightLinks' => 'Fremhev lenker',
						),
						'colors'                 => array(
							'invertColors' => 'Invertér farger',
							'brightness'   => 'Lysstyrke',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Gråtoner',
							'saturation'   => 'Metning',
						),
						'orientation'            => array(
							'readingLine'        => 'Leselinje',
							'keyboardNavigation' => 'Tastaturnavigasjon',
							'highlightTitles'    => 'Fremhev titler',
							'readingMask'        => 'Lesemaske',
							'hideImages'         => 'Skjul bilder',
							'highlightAll'       => 'Fremhev alt',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Les siden',
							'muteSounds'     => 'Demp lyder',
							'stopAnimations' => 'Stopp animasjoner',
						),
						'divider'                => array(
							'content'    => 'innhold',
							'colors'     => 'farger',
							'navigation' => 'navigasjon',
						),
						'resetSettings'          => 'Tilbakestill innstillinger',
						'footer'                 => array(
							'accessibilityStatement' => 'Tilgjengelighetserklæring',
							'version'                => 'Versjon ' . $plugin_version,
						),
					),
					'tr'    => array(
						'global'                 => array(
							'back' => 'Geri',
						),
						'hideToolbar'            => array(
							'title'   => 'Erişilebilirlik araç çubuğunu ne kadar süre gizlemek istiyorsunuz?',
							'radio1'  => 'Yalnızca bu oturum için',
							'radio2'  => '24 saat',
							'radio3'  => 'Bir hafta',
							'button1' => 'Şimdi değil',
							'button2' => 'Araç çubuğunu gizle',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Tarayıcının güncellenmesi gerekiyor',
							'desc'  => 'Tarayıcınız konuşma çıkışını desteklemiyor. Lütfen tarayıcınızı güncelleyin veya konuşma sentezi destekleyen bir tarayıcı kullanın (ör. Chrome, Edge, Safari).',
							'link'  => 'Nasıl güncellenir?',
						),
						'header'                 => array(
							'language'      => 'Türkçe',
							'listLanguages' => $list_languages,
							'title'         => 'Erişilebilirlik Ayarları',
							'desc'          => 'Tarafından desteklenmektedir',
							'anchor'        => 'OneTap',
							'statement'     => 'Açıklama',
							'hideToolbar'   => 'Araç çubuğunu gizle',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Erişilebilirlik profilinizi seçin',
							'visionImpairedMode' => array(
								'title' => 'Görme Engelli Modu',
								'desc'  => 'Web sitesinin görselini geliştirir',
								'on'    => 'AÇIK',
								'off'   => 'KAPALI',
							),
							'seizureSafeProfile' => array(
								'title' => 'Nöbet Güvenli Profili',
								'desc'  => 'Parlamaları temizler ve renkleri azaltır',
								'on'    => 'AÇIK',
								'off'   => 'KAPALI',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'DEHB Dostu Mod',
								'desc'  => 'Odaklanmış ve dikkat dağıtmayan gezinme',
								'on'    => 'AÇIK',
								'off'   => 'KAPALI',
							),
							'blindnessMode'      => array(
								'title' => 'Körlük Modu',
								'desc'  => 'Dikkat dağınıklığını azaltır, odağı artırır',
								'on'    => 'AÇIK',
								'off'   => 'KAPALI',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Epilepsi Güvenli Mod',
								'desc'  => 'Renkleri kısar ve yanıp sönmeyi durdurur',
								'on'    => 'AÇIK',
								'off'   => 'KAPALI',
							),
						),
						'content'                => array(
							'biggerText'    => 'Daha Büyük Yazı',
							'cursor'        => 'İmleç',
							'lineHeight'    => 'Satır Yüksekliği',
							'letterSpacing' => 'Harf Aralığı',
							'readableFont'  => 'Okunabilir Yazı Tipi',
							'dyslexicFont'  => 'Disleksi Dostu Yazı Tipi',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Metin Hizalama',
							'textMagnifier'  => 'Metin Büyüteci',
							'highlightLinks' => 'Bağlantıları Vurgula',
						),
						'colors'                 => array(
							'invertColors' => 'Renkleri Ters Çevir',
							'brightness'   => 'Parlaklık',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Gri Tonlama',
							'saturation'   => 'Doygunluk',
						),
						'orientation'            => array(
							'readingLine'        => 'Okuma Satırı',
							'keyboardNavigation' => 'Klavye ile Gezinme',
							'highlightTitles'    => 'Başlıkları Vurgula',
							'readingMask'        => 'Okuma Maskesi',
							'hideImages'         => 'Görüntüleri Gizle',
							'highlightAll'       => 'Hepsini Vurgula',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Sayfayı Oku',
							'muteSounds'     => 'Sesleri Kapat',
							'stopAnimations' => 'Animasyonları Durdur',
						),
						'divider'                => array(
							'content'    => 'içerik',
							'colors'     => 'renkler',
							'navigation' => 'navigasyon',
						),
						'resetSettings'          => 'Ayarları Sıfırla',
						'footer'                 => array(
							'accessibilityStatement' => 'Erişilebilirlik Bildirimi',
							'version'                => 'Sürüm ' . $plugin_version,
						),
					),
					'id'    => array(
						'global'                 => array(
							'back' => 'Kembali',
						),
						'hideToolbar'            => array(
							'title'   => 'Berapa lama Anda ingin menyembunyikan toolbar aksesibilitas?',
							'radio1'  => 'Hanya untuk sesi ini',
							'radio2'  => '24 jam',
							'radio3'  => 'Satu minggu',
							'button1' => 'Tidak sekarang',
							'button2' => 'Sembunyikan toolbar',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Browser perlu diperbarui',
							'desc'  => 'Browser Anda tidak mendukung output suara. Silakan perbarui browser Anda atau gunakan yang mendukung sintesis suara (misalnya Chrome, Edge, Safari).',
							'link'  => 'Cara memperbarui?',
						),
						'header'                 => array(
							'language'      => 'Bahasa Indonesia',
							'listLanguages' => $list_languages,
							'title'         => 'Pengaturan Aksesibilitas',
							'desc'          => 'Didukung oleh',
							'anchor'        => 'OneTap',
							'statement'     => 'Pernyataan',
							'hideToolbar'   => 'Sembunyikan bilah alat',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Pilih profil aksesibilitas Anda',
							'visionImpairedMode' => array(
								'title' => 'Mode Penglihatan Terganggu',
								'desc'  => 'Meningkatkan visual situs web',
								'on'    => 'NYALAKAN',
								'off'   => 'MATIKAN',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil Aman dari Kejang',
								'desc'  => 'Menghilangkan kedipan & mengurangi warna',
								'on'    => 'NYALAKAN',
								'off'   => 'MATIKAN',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Mode Ramah DEHB',
								'desc'  => 'Menjelajahi dengan fokus, tanpa gangguan',
								'on'    => 'NYALAKAN',
								'off'   => 'MATIKAN',
							),
							'blindnessMode'      => array(
								'title' => 'Mode Kebutaan',
								'desc'  => 'Mengurangi gangguan, meningkatkan fokus',
								'on'    => 'NYALAKAN',
								'off'   => 'MATIKAN',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Mode Aman Epilepsi',
								'desc'  => 'Menurunkan kecerahan warna dan menghentikan kedipan',
								'on'    => 'NYALAKAN',
								'off'   => 'MATIKAN',
							),
						),
						'content'                => array(
							'biggerText'    => 'Teks Lebih Besar',
							'cursor'        => 'Kursor',
							'lineHeight'    => 'Tinggi Baris',
							'letterSpacing' => 'Jarak Huruf',
							'readableFont'  => 'Font yang Mudah Dibaca',
							'dyslexicFont'  => 'Font Ramah Disleksia',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Penataan Teks',
							'textMagnifier'  => 'Pembesar Teks',
							'highlightLinks' => 'Sorot Tautan',
						),
						'colors'                 => array(
							'invertColors' => 'Balikkan Warna',
							'brightness'   => 'Kecerahan',
							'contrast'     => 'Kontras',
							'grayscale'    => 'Skala Abu-abu',
							'saturation'   => 'Kejenuhan',
						),
						'orientation'            => array(
							'readingLine'        => 'Garis Bacaan',
							'keyboardNavigation' => 'Navigasi Keyboard',
							'highlightTitles'    => 'Sorot Judul',
							'readingMask'        => 'Masker Bacaan',
							'hideImages'         => 'Sembunyikan Gambar',
							'highlightAll'       => 'Sorot Semua',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Baca Halaman',
							'muteSounds'     => 'Matikan Suara',
							'stopAnimations' => 'Hentikan Animasi',
						),
						'divider'                => array(
							'content'    => 'konten',
							'colors'     => 'warna',
							'navigation' => 'navigasi',
						),
						'resetSettings'          => 'Setel Ulang Pengaturan',
						'footer'                 => array(
							'accessibilityStatement' => 'Pernyataan Aksesibilitas',
							'version'                => 'Versi ' . $plugin_version,
						),
					),
					'pt-br' => array(
						'global'                 => array(
							'back' => 'Voltar',
						),
						'hideToolbar'            => array(
							'title'   => 'Por quanto tempo você deseja ocultar a barra de acessibilidade?',
							'radio1'  => 'Apenas para esta sessão',
							'radio2'  => '24 horas',
							'radio3'  => 'Uma semana',
							'button1' => 'Agora não',
							'button2' => 'Ocultar barra',
						),
						'unsupportedPageReader'  => array(
							'title' => 'O navegador precisa ser atualizado',
							'desc'  => 'Seu navegador não é compatível com saída de voz. Atualize seu navegador ou use um que tenha síntese de voz ativada (por exemplo, Chrome, Edge, Safari).',
							'link'  => 'Como atualizar?',
						),
						'header'                 => array(
							'language'      => 'Português (Brasil)',
							'listLanguages' => $list_languages,
							'title'         => 'Ajustes de Acessibilidade',
							'desc'          => 'Desenvolvido por',
							'anchor'        => 'OneTap',
							'statement'     => 'Declaração',
							'hideToolbar'   => 'Ocultar barra de ferramentas',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Selecione seu perfil de acessibilidade',
							'visionImpairedMode' => array(
								'title' => 'Modo de Deficiência Visual',
								'desc'  => 'Melhora os visuais do site',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Perfil Seguro para Convulsões',
								'desc'  => 'Remove piscadas e reduz as cores',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Modo Amigável para TDAH',
								'desc'  => 'Navegação com foco, sem distrações',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'blindnessMode'      => array(
								'title' => 'Modo de Cegueira',
								'desc'  => 'Reduz distrações, melhora o foco',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Modo Seguro para Epilepsia',
								'desc'  => 'Diminui cores e para piscadas',
								'on'    => 'LIGADO',
								'off'   => 'DESLIGADO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Texto Maior',
							'cursor'        => 'Cursor',
							'lineHeight'    => 'Altura da Linha',
							'letterSpacing' => 'Espaçamento de Letras',
							'readableFont'  => 'Fonte Legível',
							'dyslexicFont'  => 'Fonte para Dislexia',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Alinhar Texto',
							'textMagnifier'  => 'Lupa de Texto',
							'highlightLinks' => 'Destacar Links',
						),
						'colors'                 => array(
							'invertColors' => 'Inverter Cores',
							'brightness'   => 'Brilho',
							'contrast'     => 'Contraste',
							'grayscale'    => 'Escala de Cinza',
							'saturation'   => 'Saturação',
						),
						'orientation'            => array(
							'readingLine'        => 'Linha de Leitura',
							'keyboardNavigation' => 'Navegação por Teclado',
							'highlightTitles'    => 'Destacar Títulos',
							'readingMask'        => 'Máscara de Leitura',
							'hideImages'         => 'Ocultar Imagens',
							'highlightAll'       => 'Destacar Tudo',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Ler Página',
							'muteSounds'     => 'Silenciar Sons',
							'stopAnimations' => 'Parar Animações',
						),
						'divider'                => array(
							'content'    => 'conteúdo',
							'colors'     => 'cores',
							'navigation' => 'navegação',
						),
						'resetSettings'          => 'Redefinir Configurações',
						'footer'                 => array(
							'accessibilityStatement' => 'Declaração de Acessibilidade',
							'version'                => 'Versão ' . $plugin_version,
						),
					),
					'ja'    => array(
						'global'                 => array(
							'back' => '戻る',
						),
						'hideToolbar'            => array(
							'title'   => 'アクセシビリティツールバーをどのくらい非表示にしますか？',
							'radio1'  => 'このセッションのみ',
							'radio2'  => '24時間',
							'radio3'  => '1週間',
							'button1' => '今はしない',
							'button2' => 'ツールバーを非表示',
						),
						'unsupportedPageReader'  => array(
							'title' => 'ブラウザの更新が必要です',
							'desc'  => 'ご利用のブラウザは音声出力に対応していません。ブラウザを更新するか、音声合成に対応したブラウザをご使用ください（例：Chrome、Edge、Safari）。',
							'link'  => '更新方法はこちら',
						),
						'header'                 => array(
							'language'      => '日本語',
							'listLanguages' => $list_languages,
							'title'         => 'アクセシビリティ設定',
							'desc'          => '提供元',
							'anchor'        => 'OneTap',
							'statement'     => '声明',
							'hideToolbar'   => 'ツールバーを非表示にする',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'アクセシビリティプロファイルを選択',
							'visionImpairedMode' => array(
								'title' => '視覚障害者モード',
								'desc'  => 'ウェブサイトの視覚的な改善',
								'on'    => 'オン',
								'off'   => 'オフ',
							),
							'seizureSafeProfile' => array(
								'title' => '発作防止プロファイル',
								'desc'  => '点滅を防ぎ、色を減らします',
								'on'    => 'オン',
								'off'   => 'オフ',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHDフレンドリーモード',
								'desc'  => '集中してブラウジング、気を散らさない',
								'on'    => 'オン',
								'off'   => 'オフ',
							),
							'blindnessMode'      => array(
								'title' => '視覚障害モード',
								'desc'  => '注意散漫を減らし、集中を改善',
								'on'    => 'オン',
								'off'   => 'オフ',
							),
							'epilepsySafeMode'   => array(
								'title' => 'てんかん安全モード',
								'desc'  => '色を暗くし、点滅を止める',
								'on'    => 'オン',
								'off'   => 'オフ',
							),
						),
						'content'                => array(
							'biggerText'    => '文字を大きく',
							'cursor'        => 'カーソル',
							'lineHeight'    => '行の高さ',
							'letterSpacing' => '文字間隔',
							'readableFont'  => '読みやすいフォント',
							'dyslexicFont'  => 'ディスレクシア用フォント',
						),
						'contentBottom'          => array(
							'textAlign'      => 'テキストの配置',
							'textMagnifier'  => 'テキスト拡大鏡',
							'highlightLinks' => 'リンクを強調表示',
						),
						'colors'                 => array(
							'invertColors' => '色を反転',
							'brightness'   => '明るさ',
							'contrast'     => 'コントラスト',
							'grayscale'    => 'グレースケール',
							'saturation'   => '彩度',
						),
						'orientation'            => array(
							'readingLine'        => '読み取りライン',
							'keyboardNavigation' => 'キーボードナビゲーション',
							'highlightTitles'    => 'タイトルを強調表示',
							'readingMask'        => '読み取りマスク',
							'hideImages'         => '画像を非表示',
							'highlightAll'       => 'すべてを強調表示',
						),
						'orientationBottom'      => array(
							'readPage'       => 'ページを読む',
							'muteSounds'     => '音をミュート',
							'stopAnimations' => 'アニメーションを停止',
						),
						'divider'                => array(
							'content'    => 'コンテンツ',
							'colors'     => '色',
							'navigation' => 'ナビゲーション',
						),
						'resetSettings'          => '設定をリセット',
						'footer'                 => array(
							'accessibilityStatement' => 'アクセシビリティ声明',
							'version'                => 'バージョン ' . $plugin_version,
						),
					),
					'ko'    => array(
						'global'                 => array(
							'back' => '뒤로',
						),
						'hideToolbar'            => array(
							'title'   => '접근성 도구 모음을 얼마나 숨기시겠습니까?',
							'radio1'  => '이번 세션만',
							'radio2'  => '24시간',
							'radio3'  => '일주일',
							'button1' => '나중에',
							'button2' => '도구 모음 숨기기',
						),
						'unsupportedPageReader'  => array(
							'title' => '브라우저를 업데이트해야 합니다',
							'desc'  => '사용 중인 브라우저는 음성 출력을 지원하지 않습니다. 브라우저를 업데이트하거나 음성 합성이 가능한 브라우저를 사용하세요 (예: Chrome, Edge, Safari).',
							'link'  => '업데이트 방법',
						),
						'header'                 => array(
							'language'      => '한국어',
							'listLanguages' => $list_languages,
							'title'         => '접근성 설정',
							'desc'          => '제공자',
							'anchor'        => 'OneTap',
							'statement'     => '성명',
							'hideToolbar'   => '도구 모음 숨기기',
						),
						'multiFunctionalFeature' => array(
							'title'              => '접근성 프로필 선택',
							'visionImpairedMode' => array(
								'title' => '시각 장애인 모드',
								'desc'  => '웹사이트의 시각적 개선',
								'on'    => '켜기',
								'off'   => '끄기',
							),
							'seizureSafeProfile' => array(
								'title' => '발작 예방 프로필',
								'desc'  => '점멸을 줄이고 색상을 조정',
								'on'    => '켜기',
								'off'   => '끄기',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD 친화적 모드',
								'desc'  => '집중적인 탐색, 방해 없이',
								'on'    => '켜기',
								'off'   => '끄기',
							),
							'blindnessMode'      => array(
								'title' => '시각 장애 모드',
								'desc'  => '방해 요소를 줄이고 집중력 향상',
								'on'    => '켜기',
								'off'   => '끄기',
							),
							'epilepsySafeMode'   => array(
								'title' => '간질 예방 모드',
								'desc'  => '색을 어둡게 하고 깜박임을 멈춤',
								'on'    => '켜기',
								'off'   => '끄기',
							),
						),
						'content'                => array(
							'biggerText'    => '더 큰 글꼴',
							'cursor'        => '커서',
							'lineHeight'    => '줄 높이',
							'letterSpacing' => '글자 간격',
							'readableFont'  => '읽기 쉬운 글꼴',
							'dyslexicFont'  => '디스렉시아용 글꼴',
						),
						'contentBottom'          => array(
							'textAlign'      => '텍스트 정렬',
							'textMagnifier'  => '텍스트 확대경',
							'highlightLinks' => '링크 강조 표시',
						),
						'colors'                 => array(
							'invertColors' => '색상 반전',
							'brightness'   => '밝기',
							'contrast'     => '대비',
							'grayscale'    => '그레이스케일',
							'saturation'   => '채도',
						),
						'orientation'            => array(
							'readingLine'        => '읽기 라인',
							'keyboardNavigation' => '키보드 탐색',
							'highlightTitles'    => '제목 강조 표시',
							'readingMask'        => '읽기 마스크',
							'hideImages'         => '이미지 숨기기',
							'highlightAll'       => '모두 강조 표시',
						),
						'orientationBottom'      => array(
							'readPage'       => '페이지 읽기',
							'muteSounds'     => '소리 음소거',
							'stopAnimations' => '애니메이션 중지',
						),
						'divider'                => array(
							'content'    => '콘텐츠',
							'colors'     => '색상',
							'navigation' => '탐색',
						),
						'resetSettings'          => '설정 초기화',
						'footer'                 => array(
							'accessibilityStatement' => '접근성 선언문',
							'version'                => '버전 ' . $plugin_version,
						),
					),
					'zh'    => array(
						'global'                 => array(
							'back' => '返回',
						),
						'hideToolbar'            => array(
							'title'   => '您想隐藏辅助工具栏多长时间？',
							'radio1'  => '仅此会话',
							'radio2'  => '24小时',
							'radio3'  => '一周',
							'button1' => '暂不',
							'button2' => '隐藏工具栏',
						),
						'unsupportedPageReader'  => array(
							'title' => '需要更新浏览器',
							'desc'  => '您的浏览器不支持语音输出。请更新浏览器，或使用支持语音合成功能的浏览器（例如 Chrome、Edge、Safari）。',
							'link'  => '如何更新？',
						),
						'header'                 => array(
							'language'      => '简体中文',
							'listLanguages' => $list_languages,
							'title'         => '无障碍调整',
							'desc'          => '提供者',
							'anchor'        => 'OneTap',
							'statement'     => '声明',
							'hideToolbar'   => '隐藏工具栏',
						),
						'multiFunctionalFeature' => array(
							'title'              => '选择您的无障碍配置文件',
							'visionImpairedMode' => array(
								'title' => '视力障碍模式',
								'desc'  => '增强网站视觉效果',
								'on'    => '开',
								'off'   => '关',
							),
							'seizureSafeProfile' => array(
								'title' => '抗癫痫模式',
								'desc'  => '减少闪烁和调整颜色',
								'on'    => '开',
								'off'   => '关',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD友好模式',
								'desc'  => '专注浏览，无干扰',
								'on'    => '开',
								'off'   => '关',
							),
							'blindnessMode'      => array(
								'title' => '盲人模式',
								'desc'  => '减少干扰，增强集中力',
								'on'    => '开',
								'off'   => '关',
							),
							'epilepsySafeMode'   => array(
								'title' => '癫痫安全模式',
								'desc'  => '调暗颜色，停止闪烁',
								'on'    => '开',
								'off'   => '关',
							),
						),
						'content'                => array(
							'biggerText'    => '更大字体',
							'cursor'        => '光标',
							'lineHeight'    => '行高',
							'letterSpacing' => '字母间距',
							'readableFont'  => '可读字体',
							'dyslexicFont'  => '阅读障碍字体',
						),
						'contentBottom'          => array(
							'textAlign'      => '文本对齐',
							'textMagnifier'  => '文本放大器',
							'highlightLinks' => '突出显示链接',
						),
						'colors'                 => array(
							'invertColors' => '反转颜色',
							'brightness'   => '亮度',
							'contrast'     => '对比度',
							'grayscale'    => '灰度',
							'saturation'   => '饱和度',
						),
						'orientation'            => array(
							'readingLine'        => '阅读线',
							'keyboardNavigation' => '键盘导航',
							'highlightTitles'    => '突出显示标题',
							'readingMask'        => '阅读遮罩',
							'hideImages'         => '隐藏图片',
							'highlightAll'       => '突出显示所有内容',
						),
						'orientationBottom'      => array(
							'readPage'       => '朗读页面',
							'muteSounds'     => '静音声音',
							'stopAnimations' => '停止动画',
						),
						'divider'                => array(
							'content'    => '内容',
							'colors'     => '颜色',
							'navigation' => '导航',
						),
						'resetSettings'          => '重置设置',
						'footer'                 => array(
							'accessibilityStatement' => '无障碍声明',
							'version'                => '版本 ' . $plugin_version,
						),
					),
					'ar'    => array(
						'global'                 => array(
							'back' => 'رجوع',
						),
						'hideToolbar'            => array(
							'title'   => 'كم من الوقت تريد إخفاء شريط أدوات إمكانية الوصول؟',
							'radio1'  => 'فقط لهذه الجلسة',
							'radio2'  => '24 ساعة',
							'radio3'  => 'أسبوع واحد',
							'button1' => 'ليس الآن',
							'button2' => 'إخفاء الشريط',
						),
						'unsupportedPageReader'  => array(
							'title' => 'يجب تحديث المتصفح',
							'desc'  => 'المتصفح الخاص بك لا يدعم إخراج الصوت. يرجى تحديث المتصفح أو استخدام متصفح يدعم تحويل النص إلى كلام (مثل Chrome أو Edge أو Safari).',
							'link'  => 'كيف يتم التحديث؟',
						),
						'header'                 => array(
							'language'      => 'العربية',
							'listLanguages' => $list_languages,
							'title'         => 'تعديلات الوصول',
							'desc'          => 'مزود بواسطة',
							'anchor'        => 'OneTap',
							'statement'     => 'بيان',
							'hideToolbar'   => 'إخفاء شريط الأدوات',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'اختر ملف التعريف للوصول الخاص بك',
							'visionImpairedMode' => array(
								'title' => 'وضع ضعف البصر',
								'desc'  => 'تعزيز مرئيات الموقع',
								'on'    => 'تشغيل',
								'off'   => 'إيقاف',
							),
							'seizureSafeProfile' => array(
								'title' => 'وضع آمن للنوبات',
								'desc'  => 'تقليل الوميض وتعديل الألوان',
								'on'    => 'تشغيل',
								'off'   => 'إيقاف',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'وضع صديق لاضطراب فرط الحركة',
								'desc'  => 'تصفح مركز، بدون تشتيت',
								'on'    => 'تشغيل',
								'off'   => 'إيقاف',
							),
							'blindnessMode'      => array(
								'title' => 'وضع العمى',
								'desc'  => 'تقليل التشويش، وتعزيز التركيز',
								'on'    => 'تشغيل',
								'off'   => 'إيقاف',
							),
							'epilepsySafeMode'   => array(
								'title' => 'وضع آمن للصرع',
								'desc'  => 'خفض الألوان ووقف الوميض',
								'on'    => 'تشغيل',
								'off'   => 'إيقاف',
							),
						),
						'content'                => array(
							'biggerText'    => 'نص أكبر',
							'cursor'        => 'مؤشر',
							'lineHeight'    => 'ارتفاع السطر',
							'letterSpacing' => 'تباعد الحروف',
							'readableFont'  => 'خط قابل للقراءة',
							'dyslexicFont'  => 'خط مخصص لمرضى الديسلكسيا',
						),
						'contentBottom'          => array(
							'textAlign'      => 'محاذاة النص',
							'textMagnifier'  => 'مكبر النص',
							'highlightLinks' => 'تسليط الضوء على الروابط',
						),
						'colors'                 => array(
							'invertColors' => 'عكس الألوان',
							'brightness'   => 'السطوع',
							'contrast'     => 'التباين',
							'grayscale'    => 'التدرج الرمادي',
							'saturation'   => 'التشبع',
						),
						'orientation'            => array(
							'readingLine'        => 'خط القراءة',
							'keyboardNavigation' => 'التنقل عبر لوحة المفاتيح',
							'highlightTitles'    => 'تسليط الضوء على العناوين',
							'readingMask'        => 'قناع القراءة',
							'hideImages'         => 'إخفاء الصور',
							'highlightAll'       => 'تسليط الضوء على الكل',
						),
						'orientationBottom'      => array(
							'readPage'       => 'قراءة الصفحة',
							'muteSounds'     => 'كتم الأصوات',
							'stopAnimations' => 'إيقاف الأنيميشينات',
						),
						'divider'                => array(
							'content'    => 'المحتوى',
							'colors'     => 'الألوان',
							'navigation' => 'التنقل',
						),
						'resetSettings'          => 'إعادة تعيين الإعدادات',
						'footer'                 => array(
							'accessibilityStatement' => 'بيان الوصول',
							'version'                => 'الإصدار ' . $plugin_version,
						),
					),
					'ru'    => array(
						'global'                 => array(
							'back' => 'Назад',
						),
						'hideToolbar'            => array(
							'title'   => 'На сколько вы хотите скрыть панель доступности?',
							'radio1'  => 'Только для этой сессии',
							'radio2'  => '24 часа',
							'radio3'  => 'Одна неделя',
							'button1' => 'Не сейчас',
							'button2' => 'Скрыть панель',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Браузер нужно обновить',
							'desc'  => 'Ваш браузер не поддерживает голосовой вывод. Обновите браузер или используйте тот, который поддерживает синтез речи (например, Chrome, Edge, Safari).',
							'link'  => 'Как обновить?',
						),
						'header'                 => array(
							'language'      => 'Русский',
							'listLanguages' => $list_languages,
							'title'         => 'Настройки доступности',
							'desc'          => 'Предоставлено',
							'anchor'        => 'OneTap',
							'statement'     => 'Заявление',
							'hideToolbar'   => 'Скрыть панель инструментов',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Выберите ваш профиль доступности',
							'visionImpairedMode' => array(
								'title' => 'Режим для людей с нарушениями зрения',
								'desc'  => 'Улучшает визуальные элементы сайта',
								'on'    => 'ВКЛ',
								'off'   => 'ВЫКЛ',
							),
							'seizureSafeProfile' => array(
								'title' => 'Безопасный профиль для людей с эпилепсией',
								'desc'  => 'Очищает вспышки и снижает яркость',
								'on'    => 'ВКЛ',
								'off'   => 'ВЫКЛ',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Режим для людей с СДВГ',
								'desc'  => 'Целенаправленный просмотр, без отвлечений',
								'on'    => 'ВКЛ',
								'off'   => 'ВЫКЛ',
							),
							'blindnessMode'      => array(
								'title' => 'Режим для людей с слепотой',
								'desc'  => 'Снижает отвлекающие элементы, улучшает концентрацию',
								'on'    => 'ВКЛ',
								'off'   => 'ВЫКЛ',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Режим безопасности от эпилепсии',
								'desc'  => 'Уменьшает цвета и останавливает мигание',
								'on'    => 'ВКЛ',
								'off'   => 'ВЫКЛ',
							),
						),
						'content'                => array(
							'biggerText'    => 'Большой текст',
							'cursor'        => 'Курсор',
							'lineHeight'    => 'Высота строки',
							'letterSpacing' => 'Межбуквенный интервал',
							'readableFont'  => 'Читаемый шрифт',
							'dyslexicFont'  => 'Шрифт для людей с дислексией',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Выравнивание текста',
							'textMagnifier'  => 'Увеличитель текста',
							'highlightLinks' => 'Выделить ссылки',
						),
						'colors'                 => array(
							'invertColors' => 'Инвертировать цвета',
							'brightness'   => 'Яркость',
							'contrast'     => 'Контрастность',
							'grayscale'    => 'Оттенки серого',
							'saturation'   => 'Насыщенность',
						),
						'orientation'            => array(
							'readingLine'        => 'Читаемая линия',
							'keyboardNavigation' => 'Навигация с клавиатуры',
							'highlightTitles'    => 'Выделить заголовки',
							'readingMask'        => 'Читаемая маска',
							'hideImages'         => 'Скрыть изображения',
							'highlightAll'       => 'Выделить все',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Читать страницу',
							'muteSounds'     => 'Отключить звуки',
							'stopAnimations' => 'Остановить анимацию',
						),
						'divider'                => array(
							'content'    => 'контент',
							'colors'     => 'цвета',
							'navigation' => 'навигация',
						),
						'resetSettings'          => 'Сбросить настройки',
						'footer'                 => array(
							'accessibilityStatement' => 'Заявление о доступности',
							'version'                => 'Версия ' . $plugin_version,
						),
					),
					'hi'    => array(
						'global'                 => array(
							'back' => 'वापस',
						),
						'hideToolbar'            => array(
							'title'   => 'आप एक्सेसिबिलिटी टूलबार को कितनी देर तक छिपाना चाहते हैं?',
							'radio1'  => 'केवल इस सत्र के लिए',
							'radio2'  => '24 घंटे',
							'radio3'  => 'एक सप्ताह',
							'button1' => 'अभी नहीं',
							'button2' => 'टूलबार छिपाएं',
						),
						'unsupportedPageReader'  => array(
							'title' => 'ब्राउज़र को अपडेट करने की आवश्यकता है',
							'desc'  => 'आपका ब्राउज़र वाक् आउटपुट का समर्थन नहीं करता है। कृपया अपना ब्राउज़र अपडेट करें या ऐसा ब्राउज़र इस्तेमाल करें जो स्पीच सिंथेसिस को सपोर्ट करता हो (जैसे Chrome, Edge, Safari)।',
							'link'  => 'कैसे अपडेट करें?',
						),
						'header'                 => array(
							'language'      => 'हिन्दी',
							'listLanguages' => $list_languages,
							'title'         => 'सुगम्यता समायोजन',
							'desc'          => 'द्वारा संचालित',
							'anchor'        => 'OneTap',
							'statement'     => 'बयान',
							'hideToolbar'   => 'टूलबार छिपाएं',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'अपनी सुगम्यता प्रोफ़ाइल चुनें',
							'visionImpairedMode' => array(
								'title' => 'दृष्टिहीन मोड',
								'desc'  => 'वेबसाइट की दृश्यता को बेहतर बनाता है',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'seizureSafeProfile' => array(
								'title' => 'मिर्गी से सुरक्षित प्रोफ़ाइल',
								'desc'  => 'चमक को हटाता है और रंगों को कम करता है',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'ADHD अनुकूल मोड',
								'desc'  => 'ध्यान केंद्रित, बिना विकर्षण के ब्राउज़िंग',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'blindnessMode'      => array(
								'title' => 'अंधत्व मोड',
								'desc'  => 'विकर्षणों को कम करता है, ध्यान केंद्रित करने में मदद करता है',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
							'epilepsySafeMode'   => array(
								'title' => 'मिर्गी सुरक्षित मोड',
								'desc'  => 'रंगों को हल्का करता है और झपकी को रोकता है',
								'on'    => 'ON',
								'off'   => 'OFF',
							),
						),
						'content'                => array(
							'biggerText'    => 'बड़ा टेक्स्ट',
							'cursor'        => 'कर्सर',
							'lineHeight'    => 'लाइन हाइट',
							'letterSpacing' => 'अक्षर स्पेसिंग',
							'readableFont'  => 'पठनीय फ़ॉन्ट',
							'dyslexicFont'  => 'डिस्लेक्सिक फ़ॉन्ट',
						),
						'contentBottom'          => array(
							'textAlign'      => 'पाठ संरेखण',
							'textMagnifier'  => 'पाठ मैग्नीफायर',
							'highlightLinks' => 'लिंक्स को हाइलाइट करें',
						),
						'colors'                 => array(
							'invertColors' => 'रंगों को उलटना',
							'brightness'   => 'चमक',
							'contrast'     => 'कांट्रास्ट',
							'grayscale'    => 'ग्रे-स्केल',
							'saturation'   => 'संतृप्ति',
						),
						'orientation'            => array(
							'readingLine'        => 'पढ़ने की लाइन',
							'keyboardNavigation' => 'किबोर्ड नेविगेशन',
							'highlightTitles'    => 'शीर्षक हाइलाइट करें',
							'readingMask'        => 'पढ़ने की मास्क',
							'hideImages'         => 'चित्र छिपाएं',
							'highlightAll'       => 'सब कुछ हाइलाइट करें',
						),
						'orientationBottom'      => array(
							'readPage'       => 'पृष्ठ पढ़ें',
							'muteSounds'     => 'ध्वनियों को म्यूट करें',
							'stopAnimations' => 'एनिमेशन रोकें',
						),
						'divider'                => array(
							'content'    => 'सामग्री',
							'colors'     => 'रंग',
							'navigation' => 'नेविगेशन',
						),
						'resetSettings'          => 'सेटिंग्स रीसेट करें',
						'footer'                 => array(
							'accessibilityStatement' => 'सुगम्यता कथन',
							'version'                => 'संस्करण ' . $plugin_version,
						),
					),
					'uk'    => array(
						'global'                 => array(
							'back' => 'Назад',
						),
						'hideToolbar'            => array(
							'title'   => 'На скільки ви хочете приховати панель доступності?',
							'radio1'  => 'Лише для цієї сесії',
							'radio2'  => '24 години',
							'radio3'  => 'Один тиждень',
							'button1' => 'Не зараз',
							'button2' => 'Приховати панель',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Потрібно оновити браузер',
							'desc'  => 'Ваш браузер не підтримує озвучування. Оновіть браузер або скористайтеся тим, що підтримує синтез мовлення (наприклад, Chrome, Edge, Safari).',
							'link'  => 'Як оновити?',
						),
						'header'                 => array(
							'language'      => 'Українська',
							'listLanguages' => $list_languages,
							'title'         => 'Налаштування доступності',
							'desc'          => 'Підтримується',
							'anchor'        => 'OneTap',
							'statement'     => 'Заява',
							'hideToolbar'   => 'Сховати панель інструментів',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Оберіть свій профіль доступності',
							'visionImpairedMode' => array(
								'title' => 'Режим для осіб з порушеннями зору',
								'desc'  => 'Поліпшує візуальне сприйняття вебсайту',
								'on'    => 'ВКЛ.',
								'off'   => 'ВИКЛ.',
							),
							'seizureSafeProfile' => array(
								'title' => 'Профіль для безпеки від судом',
								'desc'  => 'Зменшує мерехтіння та колірні ефекти',
								'on'    => 'ВКЛ.',
								'off'   => 'ВИКЛ.',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Режим для осіб з ADHD',
								'desc'  => 'Фокусована навігація без відволікань',
								'on'    => 'ВКЛ.',
								'off'   => 'ВИКЛ.',
							),
							'blindnessMode'      => array(
								'title' => 'Режим для сліпих',
								'desc'  => 'Зменшує відволікання, покращує концентрацію',
								'on'    => 'ВКЛ.',
								'off'   => 'ВИКЛ.',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Режим безпеки від епілепсії',
								'desc'  => 'Зменшує кольори і зупиняє мерехтіння',
								'on'    => 'ВКЛ.',
								'off'   => 'ВИКЛ.',
							),
						),
						'content'                => array(
							'biggerText'    => 'Збільшений текст',
							'cursor'        => 'Курсор',
							'lineHeight'    => 'Висота рядка',
							'letterSpacing' => 'Міжлітерний інтервал',
							'readableFont'  => 'Читабельний шрифт',
							'dyslexicFont'  => 'Шрифт для дислексії',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Вирівнювання тексту',
							'textMagnifier'  => 'Магніфікатор тексту',
							'highlightLinks' => 'Підсвітити посилання',
						),
						'colors'                 => array(
							'invertColors' => 'Інвертувати кольори',
							'brightness'   => 'Яскравість',
							'contrast'     => 'Контрастність',
							'grayscale'    => 'Чорно-біле',
							'saturation'   => 'Насиченість',
						),
						'orientation'            => array(
							'readingLine'        => 'Лінія читання',
							'keyboardNavigation' => 'Навігація за допомогою клавіатури',
							'highlightTitles'    => 'Підсвітити заголовки',
							'readingMask'        => 'Маска для читання',
							'hideImages'         => 'Сховати зображення',
							'highlightAll'       => 'Підсвітити все',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Читати сторінку',
							'muteSounds'     => 'Вимкнути звук',
							'stopAnimations' => 'Зупинити анімації',
						),
						'divider'                => array(
							'content'    => 'контент',
							'colors'     => 'кольори',
							'navigation' => 'орієнтація',
						),
						'resetSettings'          => 'Скинути налаштування',
						'footer'                 => array(
							'accessibilityStatement' => 'Заява про доступність',
							'version'                => 'Версія ' . $plugin_version,
						),
					),
					'sr'    => array(
						'global'                 => array(
							'back' => 'Назад',
						),
						'hideToolbar'            => array(
							'title'   => 'Колико дуго желите да сакријете траку за приступачност?',
							'radio1'  => 'Само за ову сесију',
							'radio2'  => '24 сата',
							'radio3'  => 'Недељу дана',
							'button1' => 'Не сада',
							'button2' => 'Сакриј траку',
						),
						'unsupportedPageReader'  => array(
							'title' => 'Pregledač treba da se ažurira',
							'desc'  => 'Vaš pregledač ne podržava govor. Ažurirajte ga ili koristite pregledač koji podržava sintezu govora (npr. Chrome, Edge, Safari).',
							'link'  => 'Kako ažurirati?',
						),
						'header'                 => array(
							'language'      => 'Srpski',
							'listLanguages' => $list_languages,
							'title'         => 'Podešavanja pristupačnosti',
							'desc'          => 'Pomaže',
							'anchor'        => 'OneTap',
							'statement'     => 'Изјава',
							'hideToolbar'   => 'Сакриј траку са алаткама',
						),
						'multiFunctionalFeature' => array(
							'title'              => 'Izaberite svoj profil pristupačnosti',
							'visionImpairedMode' => array(
								'title' => 'Režim za osobe sa oštećenjem vida',
								'desc'  => 'Poboljšava vizuelno iskustvo na sajtu',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'seizureSafeProfile' => array(
								'title' => 'Profil za sigurnost od napada',
								'desc'  => 'Smanjuje treperenje i boje',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'aDHDFriendlyMode'   => array(
								'title' => 'Režim za osobe sa ADHD',
								'desc'  => 'Fokusirano pretraživanje bez distrakcija',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'blindnessMode'      => array(
								'title' => 'Režim za slepe',
								'desc'  => 'Smanjuje distrakcije, poboljšava koncentraciju',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
							'epilepsySafeMode'   => array(
								'title' => 'Režim za sigurnost od epilepsije',
								'desc'  => 'Smanjuje boje i zaustavlja treperenje',
								'on'    => 'UKLJUČENO',
								'off'   => 'ISKLJUČENO',
							),
						),
						'content'                => array(
							'biggerText'    => 'Veći tekst',
							'cursor'        => 'Kursor',
							'lineHeight'    => 'Visina linije',
							'letterSpacing' => 'Razmak između slova',
							'readableFont'  => 'Font koji je lako čitljiv',
							'dyslexicFont'  => 'Font za disleksiju',
						),
						'contentBottom'          => array(
							'textAlign'      => 'Poravnanje teksta',
							'textMagnifier'  => 'Magnifikator teksta',
							'highlightLinks' => 'Istakni linkove',
						),
						'colors'                 => array(
							'invertColors' => 'Invertuj boje',
							'brightness'   => 'Osvetljenost',
							'contrast'     => 'Kontrast',
							'grayscale'    => 'Crno-belo',
							'saturation'   => 'Saturacija',
						),
						'orientation'            => array(
							'readingLine'        => 'Linija za čitanje',
							'keyboardNavigation' => 'Navigacija tastaturom',
							'highlightTitles'    => 'Istakni naslove',
							'readingMask'        => 'Maska za čitanje',
							'hideImages'         => 'Sakrij slike',
							'highlightAll'       => 'Istakni sve',
						),
						'orientationBottom'      => array(
							'readPage'       => 'Čitaj stranicu',
							'muteSounds'     => 'Isključi zvuke',
							'stopAnimations' => 'Zaustavi animacije',
						),
						'divider'                => array(
							'content'    => 'sadržaj',
							'colors'     => 'boje',
							'navigation' => 'orijentacija',
						),
						'resetSettings'          => 'Poništi podešavanja',
						'footer'                 => array(
							'accessibilityStatement' => 'Izjava o pristupačnosti',
							'version'                => 'Verzija ' . $plugin_version,
						),
					),
				),
				'getSettings' => array(
					'language'                   => $setting_language,
					'color'                      => $setting_color,
					'position-top-bottom'        => $setting_position_top_bottom,
					'position-left-right'        => $setting_position_left_right,
					'widge-position'             => $setting_widget_position,
					'position-top-bottom-tablet' => $setting_position_top_bottom_tablet,
					'position-left-right-tablet' => $setting_position_left_right_tablet,
					'widge-position-tablet'      => $setting_widget_position_tablet,
					'position-top-bottom-mobile' => $setting_position_top_bottom_mobile,
					'position-left-right-mobile' => $setting_position_left_right_mobile,
					'widge-position-mobile'      => $setting_widget_position_mobile,
					'hide-powered-by-onetap'     => $setting_hide_powered_by_onetap,
				),
				'showModules' => array(
					'bigger-text'         => $modules_bigger_text,
					'cursor'              => $modules_cursor,
					'line-height'         => $modules_line_height,
					'letter-spacing'      => $modules_letter_spacing,
					'readable-font'       => $modules_readable_font,
					'dyslexic-font'       => $modules_dyslexic_font,
					'text-align'          => $modules_text_align,
					'text-magnifier'      => $modules_text_magnifier,
					'highlight-links'     => $modules_highlight_links,
					'invert-colors'       => $modules_invert_colors,
					'brightness'          => $modules_brightness,
					'contrast'            => $modules_contrast,
					'grayscale'           => $modules_grayscale,
					'saturation'          => $modules_saturnation,
					'reading-line'        => $modules_reading_line,
					'keyboard-navigation' => $modules_keyboard_navigation,
					'highlight-titles'    => $modules_highlight_titles,
					'reading-mask'        => $modules_reading_mask,
					'hide-images'         => $modules_hide_images,
					'highlight-all'       => $modules_highlight_all,
					'read-page'           => $modules_read_page,
					'mute-sounds'         => $modules_mute_sounds,
					'stop-animations'     => $modules_stop_animations,
				),
			)
		);
	}

	/**
	 * Adds custom class to the body element.
	 *
	 * This function appends a custom class to the body tag, which can be used
	 * for additional styling or JavaScript targeting.
	 *
	 * @param array $classes An array of existing classes for the body tag.
	 * @return array Modified array of classes with the custom class added.
	 */
	public function add_custom_body_class( $classes ) {

		// Get the 'onetap_modules' option from the database.
		$modules                     = get_option( 'onetap_modules' );
		$modules_bigger_text         = isset( $modules['bigger-text'] ) ? esc_html( $modules['bigger-text'] ) : Accessibility_Onetap_Config::get_module( 'bigger_text' );
		$modules_cursor              = isset( $modules['cursor'] ) ? esc_html( $modules['cursor'] ) : Accessibility_Onetap_Config::get_module( 'cursor' );
		$modules_line_height         = isset( $modules['line-height'] ) ? esc_html( $modules['line-height'] ) : Accessibility_Onetap_Config::get_module( 'line_height' );
		$modules_letter_spacing      = isset( $modules['letter-spacing'] ) ? esc_html( $modules['letter-spacing'] ) : Accessibility_Onetap_Config::get_module( 'letter_spacing' );
		$modules_readable_font       = isset( $modules['readable-font'] ) ? esc_html( $modules['readable-font'] ) : Accessibility_Onetap_Config::get_module( 'readable_font' );
		$modules_dyslexic_font       = isset( $modules['dyslexic-font'] ) ? esc_html( $modules['dyslexic-font'] ) : Accessibility_Onetap_Config::get_module( 'dyslexic_font' );
		$modules_text_align          = isset( $modules['text-align'] ) ? esc_html( $modules['text-align'] ) : Accessibility_Onetap_Config::get_module( 'text_align' );
		$modules_text_magnifier      = isset( $modules['text-magnifier'] ) ? esc_html( $modules['text-magnifier'] ) : Accessibility_Onetap_Config::get_module( 'text_magnifier' );
		$modules_highlight_links     = isset( $modules['highlight-links'] ) ? esc_html( $modules['highlight-links'] ) : Accessibility_Onetap_Config::get_module( 'highlight_links' );
		$modules_invert_colors       = isset( $modules['invert-colors'] ) ? esc_html( $modules['invert-colors'] ) : Accessibility_Onetap_Config::get_module( 'invert_colors' );
		$modules_brightness          = isset( $modules['brightness'] ) ? esc_html( $modules['brightness'] ) : Accessibility_Onetap_Config::get_module( 'brightness' );
		$modules_contrast            = isset( $modules['contrast'] ) ? esc_html( $modules['contrast'] ) : Accessibility_Onetap_Config::get_module( 'contrast' );
		$modules_grayscale           = isset( $modules['grayscale'] ) ? esc_html( $modules['grayscale'] ) : Accessibility_Onetap_Config::get_module( 'grayscale' );
		$modules_saturnation         = isset( $modules['saturation'] ) ? esc_html( $modules['saturation'] ) : Accessibility_Onetap_Config::get_module( 'saturation' );
		$modules_reading_line        = isset( $modules['reading-line'] ) ? esc_html( $modules['reading-line'] ) : Accessibility_Onetap_Config::get_module( 'reading_line' );
		$modules_keyboard_navigation = isset( $modules['keyboard-navigation'] ) ? esc_html( $modules['keyboard-navigation'] ) : Accessibility_Onetap_Config::get_module( 'keyboard_navigation' );
		$modules_highlight_titles    = isset( $modules['highlight-titles'] ) ? esc_html( $modules['highlight-titles'] ) : Accessibility_Onetap_Config::get_module( 'highlight_titles' );
		$modules_reading_mask        = isset( $modules['reading-mask'] ) ? esc_html( $modules['reading-mask'] ) : Accessibility_Onetap_Config::get_module( 'reading_mask' );
		$modules_hide_images         = isset( $modules['hide-images'] ) ? esc_html( $modules['hide-images'] ) : Accessibility_Onetap_Config::get_module( 'hide_images' );
		$modules_highlight_all       = isset( $modules['highlight-all'] ) ? esc_html( $modules['highlight-all'] ) : Accessibility_Onetap_Config::get_module( 'highlight_all' );
		$modules_read_page           = isset( $modules['read-page'] ) ? esc_html( $modules['read-page'] ) : Accessibility_Onetap_Config::get_module( 'read_page' );
		$modules_mute_sounds         = isset( $modules['mute-sounds'] ) ? esc_html( $modules['mute-sounds'] ) : Accessibility_Onetap_Config::get_module( 'mute_sounds' );
		$modules_stop_animations     = isset( $modules['stop-animations'] ) ? esc_html( $modules['stop-animations'] ) : Accessibility_Onetap_Config::get_module( 'stop_animations' );

		// Add default classes to the $classes array.
		$classes[] = 'onetap-root onetap-accessibility-plugin onetap-body-class onetap-custom-class onetap-classes';

		// Check if specific accessibility modules are turned off.
		// If a module is 'off', add its corresponding class to the $classes array.

		// Hide content feature.
		if (
			'off' === $modules_bigger_text &&
			'off' === $modules_cursor &&
			'off' === $modules_letter_spacing &&
			'off' === $modules_readable_font &&
			'off' === $modules_text_align &&
			'off' === $modules_line_height
		) {
			// Add class for the "content" module.
			$classes[] = 'onetap_hide_content_feature';
		}

		// Hide colors.
		if (
			'off' === $modules_invert_colors &&
			'off' === $modules_brightness &&
			'off' === $modules_grayscale
		) {
			// Add class for the "colors" module.
			$classes[] = 'onetap_hide_colors_feature';
		}

		// Hide orientations.
		if (
			'off' === $modules_highlight_links &&
			'off' === $modules_stop_animations &&
			'off' === $modules_hide_images &&
			'off' === $modules_reading_mask &&
			'off' === $modules_reading_line &&
			'off' === $modules_highlight_all
		) {
			// Add class for the "orientation" module.
			$classes[] = 'onetap_hide_orientation_feature';
		}

		// Hide orientation bottom.
		if (
			'off' === $modules_read_page &&
			'off' === $modules_mute_sounds &&
			'off' === $modules_stop_animations
		) {
			// Add class for the "orientation bottom" module.
			$classes[] = 'onetap_hide_orientation_bottom_feature';
		}

		if ( 'off' === $modules_bigger_text ) {
			// Add class for the "bigger text" module.
			$classes[] = 'onetap_hide_bigger_text';
		}

		if ( 'off' === $modules_cursor ) {
			// Add class for the "cursor" module.
			$classes[] = 'onetap_hide_cursor';
		}

		if ( 'off' === $modules_line_height ) {
			// Add class for the "line height" module.
			$classes[] = 'onetap_hide_line_height';
		}

		if ( 'off' === $modules_letter_spacing ) {
			// Add class for the "letter spacing" module.
			$classes[] = 'onetap_hide_letter_spacing';
		}

		if ( 'off' === $modules_readable_font ) {
			// Add class for the "readable font" module.
			$classes[] = 'onetap_hide_readable_font';
		}

		if ( 'off' === $modules_dyslexic_font ) {
			// Add class for the "dyslexic font" module.
			$classes[] = 'onetap_hide_dyslexic_font';
		}

		if ( 'off' === $modules_text_align ) {
			// Add class for the "text align" module.
			$classes[] = 'onetap_hide_text_align';
		}

		if ( 'off' === $modules_text_magnifier ) {
			// Add class for the "text magnifier" module.
			$classes[] = 'onetap_hide_text_magnifier';
		}

		if ( 'off' === $modules_highlight_links ) {
			// Add class for the "highlight links" module.
			$classes[] = 'onetap_hide_highlight_links';
		}

		if ( 'off' === $modules_invert_colors ) {
			// Add class for the "invert colors" module.
			$classes[] = 'onetap_hide_invert_colors';
		}

		if ( 'off' === $modules_brightness ) {
			// Add class for the "brightness adjustment" module.
			$classes[] = 'onetap_hide_brightness';
		}

		if ( 'off' === $modules_contrast ) {
			// Add class for the "contrast adjustment" module.
			$classes[] = 'onetap_hide_contrast';
		}

		if ( 'off' === $modules_grayscale ) {
			// Add class for the "grayscale" module.
			$classes[] = 'onetap_hide_grayscale';
		}

		if ( 'off' === $modules_saturnation ) {
			// Add class for the "saturation adjustment" module.
			$classes[] = 'onetap_hide_saturnation';
		}

		if ( 'off' === $modules_reading_line ) {
			// Add class for the "reading line" module.
			$classes[] = 'onetap_hide_reading_line';
		}

		if ( 'off' === $modules_keyboard_navigation ) {
			// Add class for the "keyboard navigation" module.
			$classes[] = 'onetap_hide_keyboard_navigation';
		}

		if ( 'off' === $modules_highlight_titles ) {
			// Add class for the "dyslexic font" module.
			$classes[] = 'onetap_hide_highlight_titles';
		}

		if ( 'off' === $modules_reading_mask ) {
			// Add class for the "reading mask" module.
			$classes[] = 'onetap_hide_reading_mask';
		}

		if ( 'off' === $modules_hide_images ) {
			// Add class for the "hide images" module.
			$classes[] = 'onetap_hide_hide_images';
		}

		if ( 'off' === $modules_highlight_all ) {
			// Add class for the "highlight all" module.
			$classes[] = 'onetap_hide_highlight_all';
		}

		if ( 'off' === $modules_read_page ) {
			// Add class for the "read page" module.
			$classes[] = 'onetap_hide_read_page';
		}

		if ( 'off' === $modules_mute_sounds ) {
			// Add class for the "mute sounds" module.
			$classes[] = 'onetap_hide_mute_sounds';
		}

		if ( 'off' === $modules_stop_animations ) {
			// Add class for the "stop animations" module.
			$classes[] = 'onetap_hide_stop_animations';
		}

		// Return the updated array of classes.
		return $classes;
	}

	/**
	 * Renders an accessibility HTML template.
	 *
	 * This function generates an HTML template that includes accessibility features
	 * It ensures the template adheres to WCAG guidelines for better user experience
	 * for people with disabilities.
	 */
	public function render_accessibility_template() {
		?>
		<section class="onetap-container-toggle" style="display: none;">
			<?php
			$settings = get_option( 'onetap_settings' );
			if ( ! is_array( $settings ) ) {
				$settings = array();
			}

			$toggle_classes = array_filter(
				array(
					! empty( $settings['border'] ) ? $settings['border'] : '',
					isset( $settings['toggle-device-position-desktop'] ) && 'on' === $settings['toggle-device-position-desktop'] ? 'hide-on-desktop' : '',
					isset( $settings['toggle-device-position-tablet'] ) && 'on' === $settings['toggle-device-position-tablet'] ? 'hide-on-tablet' : '',
					isset( $settings['toggle-device-position-mobile'] ) && 'on' === $settings['toggle-device-position-mobile'] ? 'hide-on-mobile' : '',
				)
			);
			?>

			<button type="button" aria-label="Toggle Accessibility Toolbar" class="onetap-toggle <?php echo esc_attr( implode( ' ', $toggle_classes ) ); ?>">
				<?php
				// Define SVG paths for each icon type.
				$icon_paths = array(
					'design1' => 'assets/images/admin/Original_Logo_Icon.svg',
					'design2' => 'assets/images/admin/Hand_Icon.svg',
					'design3' => 'assets/images/admin/Accessibility-Man-Icon.svg',
					'design4' => 'assets/images/admin/Settings-Filter-Icon.svg',
					'design5' => 'assets/images/admin/Switcher-Icon.svg',
					'design6' => 'assets/images/admin/Eye-Show-Icon.svg',
				);

				// Check if the selected icon exists in the array.
				$settings = get_option( 'onetap_settings' );
				if ( isset( $settings['icons'], $icon_paths[ $settings['icons'] ] ) ) {
					$icons = array(
						'design1' => 'Original_Logo_Icon.svg',
						'design2' => 'Hand_Icon.svg',
						'design3' => 'Accessibility-Man-Icon.svg',
						'design4' => 'Settings-Filter-Icon.svg',
						'design5' => 'Switcher-Icon.svg',
						'design6' => 'Eye-Show-Icon.svg',
					);
					foreach ( $icons as $icon_value => $icon_image ) {
						if ( $icon_value === $settings['icons'] ) {
							$class_size   = isset( $settings['size'] ) ? $settings['size'] : '';
							$class_border = isset( $settings['border'] ) ? $settings['border'] : '';
							echo '<img class="' . esc_attr( $class_size ) . ' ' . esc_attr( $class_border ) . '" src="' . esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/' . $icon_image ) . '" alt="toggle icon" />';
						}
					}
				} else {
					echo '<img class="design-size2 design-border2" src="' . esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/Original_Logo_Icon.svg' ) . '" alt="toggle icon" />';
				}
				?>
			</button>			
		</section>
		<nav class="onetap-accessibility onetap-plugin-onetap" aria-label="Accessibility Options">
			<section class="onetap-container">
				<div class="onetap-accessibility-settings" data-lenis-prevent="true">
					<header class="onetap-header-top">
						<!-- Languages -->
						<button type="button" role="combobox" aria-expanded="false" aria-haspopup="listbox" class="onetap-languages" aria-label="Select language">							
							<div class="onetap-icon">
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/english.png' ); ?>" class="onetap-active" alt="en">							
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/german.png' ); ?>" alt="de">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/spanish.png' ); ?>" alt="es">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/french.png' ); ?>" alt="fr">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/italia.png' ); ?>" alt="it">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/poland.png' ); ?>" alt="pl">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/swedish.png' ); ?>" alt="se">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/finnland.png' ); ?>" alt="fi">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/portugal.png' ); ?>" alt="pt">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/rumania.png' ); ?>" alt="ro">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/slowenien.png' ); ?>" alt="sk">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/slowakia.png' ); ?>" alt="si">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/netherland.png' ); ?>" alt="nl">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/danish.png' ); ?>" alt="dk">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/greece.png' ); ?>" alt="gr">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/czech.png' ); ?>" alt="cz">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/hungarian.png' ); ?>" alt="hu">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/lithuanian.png' ); ?>" alt="lt">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/latvian.png' ); ?>" alt="lv">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/estonian.png' ); ?>" alt="ee">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/croatia.png' ); ?>" alt="hr">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/ireland.png' ); ?>" alt="ie">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/bulgarian.png' ); ?>" alt="bg">								
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/norwegan.png' ); ?>" alt="no">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/turkish.png' ); ?>" alt="tr">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/indonesian.png' ); ?>" alt="id">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/brasilian.png' ); ?>" alt="pt-br">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/japanese.png' ); ?>" alt="ja">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/korean.png' ); ?>" alt="ko">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/chinese-simplified.png' ); ?>" alt="zh">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/arabic.png' ); ?>" alt="ar">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/russian.png' ); ?>" alt="ru">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/hindi.png' ); ?>" alt="hi">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/ukrainian.png' ); ?>" alt="uk">				
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/serbian.png' ); ?>" alt="sr">								
							</div>
							<p class="onetap-text">
								<span>
									<?php esc_html_e( 'English', 'accessibility-onetap' ); ?>
								</span>
								<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/icon-drop-down-menu.png' ); ?>" width="10" height="10" alt="<?php echo esc_attr__( 'icon drop down menu', 'accessibility-onetap' ); ?>">
							</p>
						</button>

						<!-- List of languages -->
						<div class="onetap-list-of-languages" style="display: none;">
							<ul>
								<li data-language="en">
									<button type="button">
										<?php esc_html_e( 'English', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/english.png' ); ?>" alt="flag">
									</button>				
								</li>
								<li data-language="de">
									<button type="button">
										<?php esc_html_e( 'Deutsch', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/german.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="es">
									<button type="button">
										<?php esc_html_e( 'Español', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/spanish.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="fr">
									<button type="button">
										<?php esc_html_e( 'Français', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/french.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="it">
									<button type="button">
										<?php esc_html_e( 'Italiano', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/italia.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="pl">
									<button type="button">
										<?php esc_html_e( 'Polski', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/poland.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="se">
									<button type="button">
										<?php esc_html_e( 'Svenska', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/swedish.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="fi">
									<button type="button">
										<?php esc_html_e( 'Suomi', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/finnland.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="pt">
									<button type="button">
										<?php esc_html_e( 'Português', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/portugal.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="ro">
									<button type="button">
										<?php esc_html_e( 'Română', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/rumania.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="si">
									<button type="button">
										<?php esc_html_e( 'Slovenščina', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/slowakia.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="sk">
									<button type="button">
										<?php esc_html_e( 'Slovenčina', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/slowenien.png' ); ?>" alt="flag">
									</button>	
								</li>					
								<li data-language="nl">
									<button type="button">
										<?php esc_html_e( 'Nederlands', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/netherland.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="dk">
									<button type="button">
										<?php esc_html_e( 'Dansk', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/danish.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="gr">
									<button type="button">
										<?php esc_html_e( 'Ελληνικά', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/greece.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="cz">
									<button type="button">
										<?php esc_html_e( 'Čeština', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/czech.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="hu">
									<button type="button">
										<?php esc_html_e( 'Magyar', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/hungarian.png' ); ?>" alt="flag">
									</button>	
								</li>									
								<li data-language="lt">
									<button type="button">
										<?php esc_html_e( 'Lietuvių', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/lithuanian.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="lv">
									<button type="button">
										<?php esc_html_e( 'Latviešu', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/latvian.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="ee">
									<button type="button">
										<?php esc_html_e( 'Eesti', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/estonian.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="hr">
									<button type="button">
										<?php esc_html_e( 'Hrvatski', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/croatia.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="ie">
									<button type="button">
										<?php esc_html_e( 'Gaeilge', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/ireland.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="bg">
									<button type="button">
										<?php esc_html_e( 'Български', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/bulgarian.png' ); ?>" alt="flag">
									</button>	
								</li>			
								<li data-language="no">
									<button type="button">
										<?php esc_html_e( 'Norsk', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/norwegan.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="tr">
									<button type="button">
										<?php esc_html_e( 'Türkçe', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/turkish.png' ); ?>" alt="flag">
									</button>	
								</li>
								<li data-language="id">
									<button type="button">
										<?php esc_html_e( 'Bahasa Indonesia', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/indonesian.png' ); ?>" alt="flag">
									</button>	
								</li>		
								<li data-language="pt-br">
									<button type="button">
										<?php esc_html_e( 'Português (Brasil)', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/brasilian.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="ja">
									<button type="button">
										<?php esc_html_e( '日本語', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/japanese.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="ko">
									<button type="button">
										<?php esc_html_e( '한국어', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/korean.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="zh">
									<button type="button">
										<?php esc_html_e( '简体中文', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/chinese-simplified.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="ar">
									<button type="button">
										<?php esc_html_e( 'العربية', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/arabic.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="ru">
									<button type="button">
										<?php esc_html_e( 'Русский', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/russian.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="hi">
									<button type="button">
										<?php esc_html_e( 'हिन्दी', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/hindi.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="uk">
									<button type="button">
										<?php esc_html_e( 'Українська', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/ukrainian.png' ); ?>" alt="flag">
									</button>	
								</li>	
								<li data-language="sr">
									<button type="button">
										<?php esc_html_e( 'Srpski', 'accessibility-onetap' ); ?>
										<img src="<?php echo esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/serbian.png' ); ?>" alt="flag">
									</button>	
								</li>														
							</ul>
						</div>

						<!-- Close -->
						<button role="button" aria-label="Close toolbar" class="onetap-close" style="display: none;">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
						</button>			

						<!-- Info -->
						<div class="onetap-site-container">
							<div class="onetap-site-info">
								<div class="onetap-image">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 701.81 701.83">
									<path fill="#FFFFFF" d="M331.08.55C190.9,8.53,70.26,97.88,20.83,230.33c-8.95,23.97-16.5,56.86-19.49,84.87-1.76,16.45-1.79,55.1-.07,71.18,8.8,81.9,43.7,155.21,101.34,212.85,57.73,57.73,132.07,93.03,213.44,101.34,16.84,1.72,54.16,1.69,70.59-.06,148.01-15.76,269.77-121.62,305.15-265.3,11.7-47.53,13.22-101.36,4.21-149.42-19.27-102.71-84.89-192.59-177.59-243.23C462.11,11.8,395.54-3.13,331.08.55ZM363.97,142.83c12.37,3.82,21.52,11.62,27.6,23.54,3.03,5.94,3.3,7.54,3.29,19.41-.01,12.48-.16,13.21-4.03,20.37-11.86,21.94-37.82,30.71-59.64,20.15-7.89-3.82-17.14-12.92-21.05-20.71-2.88-5.74-3.52-8.61-3.88-17.52-.53-13.01.78-18.23,6.86-27.33,11.17-16.72,31.5-23.89,50.84-17.91ZM239.63,230.98c56.8,8.19,67.86,9.37,95.7,10.22,36.3,1.11,59.67-.74,121.9-9.63,32.32-4.62,56.53-7.55,60.11-7.27,7.74.61,12.4,3.96,16.26,11.72,5.11,10.26,3.12,21.41-5.06,28.3-4.69,3.95-2.2,3.27-66.49,17.94-32.36,7.38-54.83,13.06-56.06,14.18-3.26,2.95-3.67,8.6-2.3,31.46,3.83,63.99,12.07,102.66,36.42,170.84,5.31,14.88,9.95,29.51,10.31,32.49,1.3,10.96-4.46,21.09-15.8,27.73-4.42,2.59-5.97,2.9-11.13,2.21-10.61-1.41-17.22-6.06-21.85-15.38-1.28-2.59-13.07-33.43-26.2-68.53-13.12-35.1-24.18-63.83-24.56-63.82-.39,0-11.27,28.17-24.19,62.6-12.92,34.43-24.93,65.63-26.68,69.34-8.74,18.47-36.45,20.12-45.98,2.74-5.48-9.99-4.95-13.08,9.64-56.7,22.94-68.59,30.75-106.34,34.2-165.25,1.57-26.79,1.21-28.53-6.51-31.25-2.59-.91-21.91-5.61-42.94-10.43-73.02-16.75-75.15-17.5-80.88-28.73-5.66-11.08-1.62-23.77,9.71-30.46,3.58-2.11,16.54-.93,62.4,5.68Z"/>
								</svg>
								</div>
								<div class="onetap-title">
									<span>
										<?php esc_html_e( 'Accessibility  Adjustments', 'accessibility-onetap' ); ?>
									</span>
								</div>
								<div class="onetap-information">
									<div class="onetap-desc">
										<p>
											<span>
												<?php esc_html_e( 'Powered by', 'accessibility-onetap' ); ?>
											</span>
											<a href="<?php echo esc_url( 'https://wponetap.com/' ); ?>" target="_blank">
												<?php esc_html_e( 'OneTap', 'accessibility-onetap' ); ?>
											</a>
										</p>
									</div>

									<!-- Accessibility status -->
									<?php if ( get_option( 'onetap_show_accessibility' ) && ! empty( get_option( 'onetap_editor_generator' ) ) ) : ?>
										<div class="onetap-statement">
											<button role="button" aria-label="Open toolbar" class="open-accessibility-message">
												<?php esc_html_e( 'Statement', 'accessibility-onetap' ); ?>
											</button>
										</div>			
									<?php endif; ?>	

									<!-- Hide Toolbar -->
									<div class="onetap-hide-toolbar">
										<button role="button" aria-label="Setting toolbar" class="open-form-hide-toolbar">
											<?php esc_html_e( 'Hide Toolbar', 'accessibility-onetap' ); ?>
										</button>
									</div>										
								</div>
							</div>
						</div>
					</header>

					<!-- Accessibility status -->
					<div class="accessibility-status-wrapper" style="display: none;">
						<div class="accessibility-status-text">
							<button role="button" aria-label="Close toolbar" class="close-accessibility-message">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9.68 5.313c-.099.065-1.494 1.436-3.1 3.045-1.606 1.61-2.969 2.953-3.03 2.985-.061.033-.157.151-.217.268-.14.274-.143.515-.009.73.055.087 1.503 1.556 3.218 3.264 3.31 3.297 3.24 3.234 3.562 3.182a.828.828 0 0 0 .289-.132c.342-.246.487-.62.347-.898-.037-.076-1.169-1.239-2.514-2.587l-2.445-2.45h13.442l.178-.09c.25-.127.328-.281.328-.65s-.078-.523-.328-.65l-.178-.09H5.821l2.425-2.43c1.334-1.337 2.457-2.491 2.494-2.567.195-.388-.209-.989-.695-1.032-.154-.014-.215.003-.365.102" fill-rule="evenodd"></path></svg>
								<?php esc_html_e( 'Back', 'accessibility-onetap' ); ?>
							</button>							
							<?php
							$editor_generator   = get_option( 'onetap_editor_generator' );
							$show_accessibility = get_option( 'onetap_show_accessibility' );

							if ( ! empty( $editor_generator ) && $show_accessibility ) {
								echo wp_kses_post( $editor_generator );
							}
							?>
						</div>
					</div>					

					<!-- Toolbar hide duration -->
					<div class="toolbar-hide-duration" style="display: none;">
						<div class="box-hide-duration">
							<span class="title"><?php esc_html_e( 'How long do you want to hide the accessibility toolbar?', 'accessibility-onetap' ); ?></span>

							<form>
								<fieldset>
									<legend><?php esc_html_e( 'Hide Toolbar Duration', 'accessibility-onetap' ); ?></legend>
									<label class="toolbar-duration-option" for="only-for-this-session" tabindex="0">
										<input type="radio" id="only-for-this-session" name="hide_toolbar_duration" tabindex="-1" checked>
										<span>
											<?php esc_html_e( 'Only for this session', 'accessibility-onetap' ); ?>
										</span>
									</label>

									<label class="toolbar-duration-option" for="only-for-24-hours" tabindex="0">
										<input type="radio" id="only-for-24-hours" name="hide_toolbar_duration" tabindex="-1">
										<span>
											<?php esc_html_e( '24 hours', 'accessibility-onetap' ); ?>
										</span>
									</label>

									<label class="toolbar-duration-option" for="only-for-a-week" tabindex="0">
										<input type="radio" id="only-for-a-week" name="hide_toolbar_duration" tabindex="-1">
										<span>
											<?php esc_html_e( 'A Week', 'accessibility-onetap' ); ?>
										</span>
									</label>
								</fieldset>
							</form>

							<div class="box-btn-action">
								<button type="button" class="close-box-hide-duration"><?php esc_html_e( 'Not Now', 'accessibility-onetap' ); ?></button>
								<button type="button" class="hide-toolbar"><?php esc_html_e( 'Hide Toolbar', 'accessibility-onetap' ); ?></button>
							</div>
						</div>
					</div>						

					<!-- Features content -->
					<div class="onetap-features-container onetap-feature-content">
						<div class="onetap-features">
							<!-- Feature Bigger Text -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-bigger-text">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M3.815 3.278c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248l.16.084 8.06.011c5.766.007 8.121-.002 8.274-.034.748-.155.775-1.244.035-1.431-.211-.053-16.153-.061-16.374-.008m7.97 4.01c-.325.088-.312.064-2.35 4.412-1.772 3.781-1.912 4.096-1.913 4.296a.706.706 0 0 0 .739.737.674.674 0 0 0 .544-.243c.052-.062.221-.386.375-.72l.28-.607 2.532-.002 2.533-.001.3.63c.165.347.34.672.388.724a.677.677 0 0 0 .526.217c.431 0 .741-.304.741-.727 0-.192-.154-.538-1.906-4.276-1.048-2.238-1.939-4.116-1.98-4.175-.164-.233-.508-.346-.809-.265m1.115 4.393c.484 1.034.886 1.898.893 1.92.009.025-.631.039-1.794.039-1.477 0-1.804-.01-1.787-.053C10.283 13.402 11.984 9.8 12 9.8c.011 0 .416.847.9 1.881m-9.085 7.597c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248l.16.084 8.06.011c5.766.007 8.121-.002 8.274-.034.748-.155.775-1.244.035-1.431-.211-.053-16.153-.061-16.374-.008" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span><?php esc_html_e( 'Bigger Text', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>

							<!-- Feature Cursor -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-cursor">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M4.72 3.286a1.931 1.931 0 0 0-.92.458c-.383.358-.599.985-.516 1.499.066.412 3.864 13.271 4.004 13.557a1.7 1.7 0 0 0 1.76.92c.37-.052.752-.236.991-.477.099-.101.592-.773 1.095-1.493.502-.721.924-1.31.938-1.31.013 0 .925.897 2.026 1.994 1.793 1.786 2.029 2.007 2.262 2.119a1.805 1.805 0 0 0 1.548.009c.245-.114.384-.239 1.4-1.254 1.015-1.016 1.14-1.155 1.254-1.4a1.805 1.805 0 0 0-.009-1.548c-.112-.233-.333-.469-2.119-2.262-1.097-1.101-1.994-2.013-1.994-2.026 0-.014.589-.436 1.31-.938.72-.503 1.392-.996 1.493-1.095.812-.803.579-2.252-.443-2.751-.464-.227-13.662-4.082-13.84-4.043l-.24.041m6.884 3.394c3.59 1.056 6.553 1.941 6.584 1.967.034.028.051.102.044.189-.012.139-.05.169-1.712 1.332-.935.654-1.742 1.229-1.792 1.277a.948.948 0 0 0-.156.21c-.076.147-.083.49-.013.627.027.054 1.092 1.142 2.365 2.419 2.021 2.025 2.316 2.336 2.316 2.44 0 .101-.141.259-.99 1.109-.85.85-1.006.99-1.109.99-.104 0-.414-.294-2.46-2.337-1.67-1.668-2.375-2.347-2.461-2.369a.85.85 0 0 0-.605.062c-.17.096-.127.038-1.727 2.324-.884 1.263-.914 1.3-1.052 1.312-.089.008-.161-.01-.191-.046C8.588 18.117 4.76 5.114 4.76 4.99c0-.114.113-.23.224-.23.051 0 3.03.864 6.62 1.92" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span><?php esc_html_e( 'Cursor', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>

							<!-- Feature Letter Spacing -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-letter-spacing">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><path d="M6.18 2.837c-.222.104-2.794 2.688-2.879 2.892a.661.661 0 0 0 .016.571c.104.222 2.688 2.794 2.892 2.879a.802.802 0 0 0 .805-.131c.113-.1.224-.366.225-.539.002-.282-.101-.427-.77-1.099l-.648-.65h12.358l-.648.65c-.669.672-.772.817-.77 1.099.001.173.112.439.225.539a.802.802 0 0 0 .805.131c.204-.085 2.788-2.657 2.892-2.879a.864.864 0 0 0 .075-.3.864.864 0 0 0-.075-.3c-.104-.222-2.688-2.794-2.892-2.879a.802.802 0 0 0-.805.131c-.113.1-.224.366-.225.539-.002.282.101.427.77 1.099l.648.65H5.821l.648-.65c.669-.672.772-.817.77-1.099-.001-.173-.112-.439-.225-.539a.792.792 0 0 0-.834-.115m-2.365 9.44a.8.8 0 0 0-.462.354l-.093.149v8.44l.093.149c.357.574 1.223.443 1.363-.207.059-.277.06-8.064.001-8.321a.747.747 0 0 0-.902-.564m8 0a.8.8 0 0 0-.462.354l-.093.149v8.44l.093.149c.357.574 1.223.443 1.363-.207.059-.277.06-8.064.001-8.321a.747.747 0 0 0-.902-.564m8 0a.8.8 0 0 0-.462.354l-.093.149v8.44l.093.149c.357.574 1.223.443 1.363-.207.059-.277.06-8.064.001-8.321a.747.747 0 0 0-.902-.564m-12 2a.8.8 0 0 0-.462.354l-.093.149v6.44l.093.149c.357.574 1.223.443 1.363-.207.059-.275.06-6.065.001-6.321a.747.747 0 0 0-.902-.564m8 0a.8.8 0 0 0-.462.354l-.093.149v6.44l.093.149c.357.574 1.223.443 1.363-.207.059-.275.06-6.065.001-6.321a.747.747 0 0 0-.902-.564" fill-rule="evenodd"></path></svg>
									</span>
								</div>
								<div class="onetap-title">
									<span><?php esc_html_e( 'Letter Spacing', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>							

							<!-- Feature Readable Font -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-readable-font onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M11.34 2.281C7.073 2.553 3.439 5.66 2.499 9.84a10.086 10.086 0 0 0 0 4.32 9.76 9.76 0 0 0 7.341 7.341c1.393.313 2.93.312 4.336-.003 3.289-.739 5.985-3.188 7.068-6.422a9.928 9.928 0 0 0 .257-5.236 9.76 9.76 0 0 0-7.341-7.341 10.445 10.445 0 0 0-2.82-.218m1.621 1.521a8.318 8.318 0 0 1 5.894 3.608c.543.802 1.034 1.968 1.222 2.899.124.611.163 1.019.163 1.691 0 1.332-.263 2.465-.845 3.642a8.146 8.146 0 0 1-3.753 3.753c-1.177.582-2.31.845-3.642.845a7.867 7.867 0 0 1-3.626-.836 8.266 8.266 0 0 1-4.572-6.443c-.054-.436-.054-1.486 0-1.922.195-1.582.857-3.123 1.846-4.299.337-.4.751-.811 1.168-1.159 1.084-.904 2.682-1.585 4.168-1.775.395-.051 1.579-.053 1.977-.004M11.614 7.62c-.134.08-.2.167-.345.45-.386.755-3.301 6.957-3.319 7.063a.892.892 0 0 0 .017.279c.101.448.57.699.984.526.244-.102.348-.238.612-.802l.251-.536h4.37l.237.508c.131.279.282.561.336.625a.84.84 0 0 0 .563.265c.29 0 .616-.238.699-.51.092-.305.097-.293-1.56-3.794-2.017-4.258-1.858-3.947-2.072-4.072a.771.771 0 0 0-.773-.002m1.117 3.92c.39.826.709 1.519.709 1.54 0 .026-.516.04-1.44.04-.991 0-1.44-.013-1.44-.043 0-.057 1.413-3.037 1.44-3.037.012 0 .341.675.731 1.5" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>

								<div class="onetap-title">
									<span><?php esc_html_e( 'Readable Font', 'accessibility-onetap' ); ?></span>
								</div>
							</button>							

							<!-- Feature text align -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-text-align">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.533 2.282c-2.527.207-4.649 2.073-5.15 4.529-.124.602-.142 1.271-.142 5.189s.018 4.587.142 5.189c.445 2.183 2.245 3.983 4.428 4.428.602.124 1.271.142 5.189.142s4.587-.018 5.189-.141c2.179-.445 3.984-2.25 4.429-4.429.123-.602.141-1.271.141-5.189s-.018-4.587-.141-5.189c-.292-1.427-1.211-2.78-2.438-3.589-.858-.566-1.705-.854-2.771-.942-.546-.045-8.323-.044-8.876.002m9.487 1.583c1.616.474 2.683 1.556 3.128 3.175.067.243.072.568.072 4.96s-.005 4.717-.072 4.96c-.229.832-.597 1.484-1.15 2.038-.554.553-1.206.921-2.038 1.15-.243.067-.568.072-4.96.072s-4.717-.005-4.96-.072c-.832-.229-1.484-.597-2.038-1.15a4.422 4.422 0 0 1-1.146-2.038c-.073-.286-.076-.511-.076-4.98V7.3l.09-.326a4.39 4.39 0 0 1 1.132-1.972A4.397 4.397 0 0 1 7.4 3.786c.055-.009 2.179-.013 4.72-.01 4.531.007 4.625.009 4.9.089m-9.84 3.97a.61.61 0 0 0-.358.375c-.114.273-.039.659.164.838.224.199.036.192 5.023.191 4.427-.001 4.659-.004 4.811-.074a.61.61 0 0 0 .358-.375.74.74 0 0 0 0-.58.61.61 0 0 0-.358-.375c-.152-.07-.383-.073-4.82-.073s-4.668.003-4.82.073m.24 3.424a1.675 1.675 0 0 1-.149.038c-.147.032-.39.251-.457.411a.736.736 0 0 0 .201.842c.08.071.196.143.256.159.143.04 9.315.04 9.458 0 .152-.042.392-.262.457-.417a.742.742 0 0 0-.139-.786c-.25-.265.129-.245-4.967-.253a424.68 424.68 0 0 0-4.66.006m-.24 3.576a.61.61 0 0 0-.358.375c-.114.273-.039.659.164.838.224.199.036.192 5.023.191 4.427-.001 4.659-.004 4.811-.074a.61.61 0 0 0 .358-.375.74.74 0 0 0 0-.58.61.61 0 0 0-.358-.375c-.152-.07-.383-.073-4.82-.073s-4.668.003-4.82.073" fill-rule="evenodd"></path></svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Align Text', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>							

							<!-- Feature Line Height -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-line-height">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M2.815 3.278c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.159.083.191.084 4.219.095 2.865.008 4.122-.002 4.274-.034.749-.155.777-1.244.036-1.431-.21-.052-8.155-.06-8.374-.008M17.9 3.259a1.795 1.795 0 0 1-.16.04c-.162.036-2.795 2.648-2.904 2.881a.907.907 0 0 0-.074.32c0 .18.108.446.224.548a.918.918 0 0 0 .514.192c.273 0 .424-.107 1.09-.771l.65-.648v12.358l-.65-.648c-.672-.669-.817-.772-1.099-.77-.173.001-.439.112-.539.225a.794.794 0 0 0-.116.834c.05.106.535.617 1.429 1.506 1.283 1.274 1.365 1.347 1.545 1.385a.935.935 0 0 0 .38 0c.18-.038.262-.111 1.545-1.385.894-.889 1.379-1.4 1.429-1.506a.794.794 0 0 0-.116-.834c-.1-.113-.366-.224-.539-.225-.282-.002-.427.101-1.099.77l-.65.648V5.821l.65.648c.666.664.817.771 1.09.771.16 0 .398-.089.514-.192.116-.102.224-.368.224-.548 0-.309-.099-.43-1.484-1.805-.734-.729-1.37-1.344-1.414-1.366-.091-.045-.38-.092-.44-.07M2.815 7.278c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.158.083.205.084 3.218.095C8.02 8.759 9 8.749 9.151 8.718c.751-.156.78-1.245.038-1.432-.21-.052-6.156-.06-6.374-.008m0 4c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.159.083.191.084 4.219.095 2.865.008 4.122-.002 4.274-.034.749-.155.777-1.244.036-1.431-.21-.052-8.155-.06-8.374-.008m0 4c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.158.083.205.084 3.218.095 2.142.008 3.122-.002 3.273-.033.751-.156.78-1.245.038-1.432-.21-.052-6.156-.06-6.374-.008m0 4c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.159.083.191.084 4.219.095 2.865.008 4.122-.002 4.274-.034.749-.155.777-1.244.036-1.431-.21-.052-8.155-.06-8.374-.008" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Line Height', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>							
						</div>
					</div>

					<!-- Divider colors -->
					<div class="onetap-divider-container">
						<div class="onetap-divider">
							<span class="onetap-divider-separator onetap-divider-colors">
								<span class="onetap-divider__text onetap-colors">
									<?php esc_html_e( 'Colors', 'accessibility-onetap' ); ?>
								</span>
							</span>
						</div>
					</div>

					<!-- Features colors-->
					<div class="onetap-features-container onetap-feature-colors">
						<div class="onetap-features">
							<!-- Feature Grayscale -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-grayscale">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M11.32 2.281a9.812 9.812 0 0 0-5.418 2.111c-.363.287-1.223 1.147-1.51 1.51-1.12 1.417-1.801 3.021-2.055 4.838-.09.647-.09 1.874.001 2.52.254 1.817.936 3.423 2.054 4.838.287.363 1.147 1.223 1.51 1.51A10.013 10.013 0 0 0 9.9 21.516c1.326.29 2.874.29 4.2 0a10.013 10.013 0 0 0 3.998-1.908c.363-.287 1.223-1.147 1.51-1.51a10.013 10.013 0 0 0 1.908-3.998c.29-1.326.29-2.874 0-4.2a10.013 10.013 0 0 0-1.908-3.998c-.287-.363-1.147-1.223-1.51-1.51a9.843 9.843 0 0 0-6.778-2.111m-.08 9.725v8.206l-.251-.024c-.761-.071-1.789-.38-2.615-.786a7.592 7.592 0 0 1-2.128-1.498 8.305 8.305 0 0 1-2.444-4.943c-.054-.436-.054-1.486 0-1.922.185-1.499.807-3.005 1.71-4.139a8.38 8.38 0 0 1 5.089-3.037c.165-.03.376-.056.469-.059l.17-.004v8.206m2.441-8.084c1.228.253 2.593.9 3.503 1.659.986.823 1.68 1.695 2.218 2.793A7.864 7.864 0 0 1 20.24 12a7.864 7.864 0 0 1-.838 3.626c-.538 1.098-1.232 1.97-2.218 2.793-1.083.904-2.829 1.644-4.173 1.769l-.251.024V3.788l.251.024c.138.013.44.062.67.11" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Grayscale', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>

							<!-- Feature Brightness -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-brightness">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M11.66 1.276a.734.734 0 0 0-.398.413c-.097.232-.087 1.433.014 1.651.283.614 1.165.614 1.448 0 .063-.136.074-.263.074-.84s-.011-.704-.074-.84a.799.799 0 0 0-1.064-.384M4.701 4.149c-.135.035-.344.197-.447.348a.872.872 0 0 0-.094.687c.065.199.908 1.072 1.14 1.18a.847.847 0 0 0 .895-.136c.224-.206.305-.605.183-.899-.08-.195-.91-1.035-1.118-1.132a.924.924 0 0 0-.559-.048m14.039.045c-.21.102-1.039.942-1.118 1.135-.122.294-.041.693.183.899a.847.847 0 0 0 .895.136c.232-.108 1.075-.981 1.14-1.18a.838.838 0 0 0-.34-.932.838.838 0 0 0-.76-.058m-7.287 1.528a6.256 6.256 0 0 0-3.908 1.823 6.296 6.296 0 0 0 0 8.91 6.303 6.303 0 0 0 8.284.553c3.023-2.309 3.318-6.771.626-9.463-1.079-1.079-2.422-1.697-3.966-1.825-.511-.042-.503-.042-1.036.002m1.319 1.658a4.666 4.666 0 0 1 2.629 1.404 4.673 4.673 0 0 1 0 6.432c-2.251 2.371-6.145 1.779-7.612-1.156A4.765 4.765 0 0 1 7.32 12c0-2.28 1.62-4.209 3.877-4.618a5.652 5.652 0 0 1 1.575-.002M1.66 11.276c-.626.289-.608 1.196.029 1.462.232.097 1.433.087 1.651-.014.614-.283.614-1.165 0-1.448-.136-.063-.263-.074-.84-.074s-.704.011-.84.074m19 0c-.626.289-.608 1.196.029 1.462.232.097 1.433.087 1.651-.014.487-.224.614-.88.248-1.279-.191-.207-.351-.243-1.088-.243-.577 0-.704.011-.84.074M5.3 17.636c-.232.108-1.075.981-1.14 1.18-.198.612.412 1.222 1.024 1.024.199-.065 1.072-.908 1.18-1.14.139-.3.064-.714-.169-.928a.847.847 0 0 0-.895-.136m12.72 0a.796.796 0 0 0-.383 1.064c.097.208.937 1.038 1.132 1.118.223.093.433.077.675-.049a.797.797 0 0 0 .374-1c-.08-.195-.91-1.035-1.118-1.132a.843.843 0 0 0-.68-.001m-6.36 2.64a.734.734 0 0 0-.398.413c-.097.232-.087 1.433.014 1.651.224.487.88.614 1.279.248.207-.191.243-.351.243-1.088 0-.577-.011-.704-.074-.84a.799.799 0 0 0-1.064-.384" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Brightness', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>							

							<!-- Feature Invert colors-->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-invert-colors">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M11.68 2.267c-3.425.192-6.065 3.083-5.906 6.467.013.29.036.611.05.715.023.163.016.193-.049.216-.041.015-.258.113-.482.217-1.614.753-2.879 2.297-3.33 4.068a8.21 8.21 0 0 0-.203 1.57c0 1.602.706 3.276 1.863 4.42a6.433 6.433 0 0 0 3.437 1.726c.623.096 1.697.057 2.314-.084a6.072 6.072 0 0 0 2.246-1.004c.198-.141.372-.257.387-.258.015 0 .078.042.14.094.062.052.248.185.413.295 1.552 1.037 3.581 1.312 5.374.727 1.599-.522 2.893-1.644 3.668-3.182.228-.452.44-1.073.544-1.594.102-.515.102-1.728 0-2.28a6.298 6.298 0 0 0-2.696-4.083c-.319-.212-.909-.52-1.172-.612-.126-.044-.128-.048-.103-.235.366-2.787-.966-5.326-3.446-6.567-.85-.425-2.068-.671-3.049-.616m1.129 1.554c.959.168 1.828.62 2.529 1.316a4.753 4.753 0 0 1 1.325 2.443c.083.39.095 1.358.021 1.74a4.836 4.836 0 0 1-1.346 2.543 4.716 4.716 0 0 1-5.433.891 4.874 4.874 0 0 1-2.176-2.174 6.399 6.399 0 0 1-.413-1.26c-.074-.382-.062-1.35.021-1.74a4.753 4.753 0 0 1 1.325-2.443 4.774 4.774 0 0 1 2.479-1.311 6.09 6.09 0 0 1 1.668-.005M6.408 11.27c.046.105.171.331.278.502.738 1.192 1.888 2.133 3.165 2.588.743.264 1.35.366 2.229.374l.62.006.026.2c.081.611-.003 1.383-.223 2.041-.256.764-.591 1.31-1.139 1.856-1.432 1.426-3.555 1.806-5.359.96-1.803-.844-2.908-2.749-2.723-4.694.161-1.7 1.109-3.095 2.628-3.864.17-.086.334-.158.362-.158.029-.001.09.084.136.189m11.724-.011c2.294 1.156 3.262 3.937 2.172 6.242a4.466 4.466 0 0 1-.943 1.344c-.613.621-1.317 1.025-2.193 1.261-.519.139-1.369.173-1.928.077a4.697 4.697 0 0 1-1.866-.726 3.96 3.96 0 0 1-.334-.235c0-.008.11-.189.244-.403a6.547 6.547 0 0 0 .861-2.199c.077-.392.101-1.492.044-1.993-.03-.259-.027-.275.053-.296.128-.033.705-.318.978-.482.983-.59 1.966-1.66 2.372-2.579.046-.105.107-.19.136-.189.028 0 .211.08.404.178" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Invert Colors', 'accessibility-onetap' ); ?></span>
									<p class="onetap-option-levels">
										<span class="onetap-level onetap-level1"></span>
										<span class="onetap-level onetap-level2"></span>
										<span class="onetap-level onetap-level3"></span>
									</p>
								</div>
							</button>
						</div>
					</div>					

					<!-- Divider orientation -->
					<div class="onetap-divider-container">
						<div class="onetap-divider">
							<span class="onetap-divider-separator onetap-divider-orientation">
								<span class="onetap-divider__text onetap-orientation">
									<?php esc_html_e( 'Orientation', 'accessibility-onetap' ); ?>
								</span>
							</span>
						</div>
					</div>					

					<!-- Features orientation -->
					<div class="onetap-features-container onetap-feature-orientation">
						<div class="onetap-features">
							<!-- Feature Highlight Links -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-highlight-links onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M16.28 2.227a6.03 6.03 0 0 0-1.768.517c-.656.332-.812.47-3.136 2.793C9.372 7.54 9.104 7.823 8.871 8.18a4.967 4.967 0 0 0-.648 1.394c-.149.516-.191.822-.189 1.406.003 1.29.418 2.363 1.317 3.407.462.536 1.45 1.173 1.82 1.173a.904.904 0 0 0 .522-.192c.229-.207.288-.59.137-.89-.092-.182-.201-.267-.717-.558-.478-.269-1.043-.937-1.305-1.54-.229-.528-.268-.738-.265-1.44.003-.589.012-.667.115-.98.125-.382.246-.637.454-.96.165-.256 4.036-4.163 4.482-4.525.929-.752 2.207-.965 3.368-.562a3.561 3.561 0 0 1 2.125 2.125c.381 1.098.208 2.325-.458 3.24-.089.122-.626.69-1.193 1.262-1.056 1.064-1.156 1.192-1.156 1.48 0 .16.089.398.192.514.102.116.368.224.548.224.306 0 .436-.103 1.581-1.263 1.306-1.322 1.556-1.66 1.877-2.53.798-2.165.001-4.63-1.91-5.902-.961-.64-2.182-.95-3.288-.836m-3.693 6.252a.755.755 0 0 0-.413 1.094c.079.133.177.211.49.387.463.26.969.718 1.232 1.114.229.346.44.86.526 1.285.1.491.064 1.219-.082 1.681a3.79 3.79 0 0 1-.619 1.177c-.283.353-4.186 4.227-4.412 4.38a4.124 4.124 0 0 1-1.057.492c-.417.12-1.406.129-1.812.016-1.047-.29-1.955-1.067-2.359-2.016-.217-.511-.258-.736-.259-1.409-.001-.702.064-1.011.319-1.527.224-.454.378-.636 1.444-1.713 1.034-1.044 1.135-1.173 1.135-1.46a.918.918 0 0 0-.192-.514c-.187-.211-.586-.28-.868-.15-.225.103-2.172 2.084-2.454 2.496a4.897 4.897 0 0 0-.886 2.868c0 1.185.334 2.161 1.062 3.1.944 1.218 2.357 1.9 3.938 1.9 1.062 0 1.924-.264 2.839-.87.27-.18.745-.628 2.296-2.168 1.075-1.068 2.088-2.094 2.252-2.279a5.18 5.18 0 0 0 1.216-2.557c.064-.391.052-1.249-.022-1.666-.269-1.507-1.266-2.856-2.612-3.536-.271-.136-.524-.182-.702-.125" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Highlight Links', 'accessibility-onetap' ); ?></span>
								</div>
							</button>	
							
							<!-- Stop Animations -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-stop-animations onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24"><path d="M11.815 2.277a.8.8 0 0 0-.462.354l-.093.149v3.44l.093.149c.357.574 1.223.443 1.363-.207.057-.268.058-3.072.001-3.321a.747.747 0 0 0-.902-.564M5.38 4.938a.75.75 0 0 0-.379 1.082c.041.066.593.635 1.227 1.265 1.087 1.082 1.163 1.148 1.343 1.186.572.119 1.019-.328.9-.9-.038-.18-.104-.256-1.186-1.343-.63-.634-1.201-1.188-1.27-1.23a.785.785 0 0 0-.635-.06m12.74-.011c-.106.03-.423.322-1.309 1.204-.643.64-1.199 1.226-1.235 1.302a.805.805 0 0 0 .029.692c.157.284.478.418.824.346.18-.038.256-.104 1.343-1.186.634-.63 1.185-1.199 1.225-1.265a.73.73 0 0 0-.112-.904c-.21-.21-.467-.274-.765-.189M2.815 11.278c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.153.08.228.085 1.713.096 1.793.014 1.914.001 2.146-.231.399-.399.212-1.098-.33-1.235-.208-.052-3.16-.059-3.374-.008m15 0c-.484.115-.717.726-.432 1.13a.951.951 0 0 0 .277.248c.153.08.228.085 1.713.096 1.793.014 1.914.001 2.146-.231.399-.399.212-1.098-.33-1.235-.208-.052-3.16-.059-3.374-.008M7.56 15.53c-.166.035-.272.129-1.332 1.184-.634.63-1.186 1.2-1.227 1.266a.73.73 0 0 0 .114.905c.244.244.613.29.905.112.066-.04.635-.591 1.265-1.225 1.082-1.087 1.148-1.163 1.186-1.343.071-.341-.063-.669-.333-.814a.75.75 0 0 0-.578-.085m8.534-.011c-.423.099-.656.475-.565.91.038.18.104.256 1.186 1.343.63.634 1.199 1.185 1.265 1.225.654.397 1.414-.363 1.017-1.017-.04-.066-.591-.635-1.225-1.265-.947-.943-1.177-1.151-1.292-1.173a11.46 11.46 0 0 0-.2-.04.555.555 0 0 0-.186.017m-4.279 1.758a.8.8 0 0 0-.462.354l-.093.149v3.44l.093.149c.357.574 1.223.443 1.363-.207.057-.268.058-3.072.001-3.321a.747.747 0 0 0-.902-.564" fill-rule="evenodd"></path></svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Stop Animations', 'accessibility-onetap' ); ?></span>
								</div>
							</button>

							<!-- Feature Hide Images -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-hide-images onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<path d="M7.533 2.282c-2.527.207-4.649 2.073-5.15 4.529-.124.602-.142 1.271-.142 5.189s.018 4.587.142 5.189c.445 2.183 2.245 3.983 4.428 4.428.602.124 1.271.142 5.189.142s4.587-.018 5.189-.141c2.179-.445 3.984-2.25 4.429-4.429.123-.602.141-1.271.141-5.189s-.018-4.587-.141-5.189c-.292-1.427-1.211-2.78-2.438-3.589-.858-.566-1.705-.854-2.771-.942-.546-.045-8.323-.044-8.876.002m9.487 1.583c.808.237 1.442.601 1.978 1.137.551.552.878 1.122 1.134 1.978.082.273.084.362.098 3.778l.013 3.498-.86-.849c-.723-.714-.9-.869-1.112-.968a1.84 1.84 0 0 0-1.544.002c-.218.101-.394.257-1.24 1.096l-.987.979-1.981-1.976c-1.799-1.794-2.005-1.987-2.24-2.097a1.838 1.838 0 0 0-1.558 0c-.238.112-.459.32-2.612 2.469L3.757 15.26l.013-4c.014-3.987.014-4.001.102-4.307a4.441 4.441 0 0 1 1.13-1.951A4.397 4.397 0 0 1 7.4 3.786c.055-.009 2.179-.013 4.72-.01 4.531.007 4.625.009 4.9.089m-2.824 3.736c-.633.109-.829.943-.311 1.318a.751.751 0 0 0 1.103-.254c.098-.188.086-.541-.024-.719a.745.745 0 0 0-.768-.345m-2.337 6.397c1.232 1.231 2.292 2.257 2.354 2.28.144.054.43.054.574 0 .062-.024.671-.6 1.354-1.28 1.073-1.07 1.257-1.238 1.36-1.238.104 0 .295.175 1.431 1.312l1.312 1.312-.026.178a4.346 4.346 0 0 1-1.22 2.436c-.554.553-1.206.921-2.038 1.15-.243.067-.568.072-4.96.072s-4.717-.005-4.96-.072c-1.402-.386-2.455-1.286-2.965-2.535l-.159-.389 2.732-2.732c2.391-2.391 2.747-2.732 2.851-2.732.104 0 .404.285 2.36 2.238" fill-rule="evenodd"></path>
									</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Hide Images', 'accessibility-onetap' ); ?></span>
								</div>
							</button>	

							<!-- Feature Reading Mask -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-reading-mask onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24">
											<path d="M3.699 3.816c-.149.065-.367.308-.408.455-.017.06-.031.667-.031 1.349.001 1.086.01 1.27.074 1.48A2.326 2.326 0 0 0 4.9 8.666c.229.071.554.074 7.1.074 6.546 0 6.871-.003 7.1-.074A2.326 2.326 0 0 0 20.666 7.1c.064-.21.073-.394.074-1.48 0-.682-.014-1.289-.031-1.349-.042-.152-.262-.392-.417-.457a.742.742 0 0 0-.786.139c-.243.23-.244.236-.266 1.593l-.02 1.247-.121.149a1.064 1.064 0 0 1-.259.224c-.134.071-.389.074-6.84.074s-6.706-.003-6.84-.074a1.064 1.064 0 0 1-.259-.224l-.121-.149-.02-1.247c-.022-1.357-.023-1.363-.266-1.593a.756.756 0 0 0-.795-.137m1.116 7.462c-.484.115-.717.726-.432 1.13a.939.939 0 0 0 .277.248l.16.084 7.06.011c5.04.007 7.121-.002 7.274-.034.748-.155.775-1.244.035-1.431-.211-.053-14.154-.061-14.374-.008m.365 4.003c-.852.114-1.557.722-1.831 1.579-.084.265-.089.347-.089 1.52 0 .682.014 1.289.031 1.349.042.152.262.392.417.457a.742.742 0 0 0 .786-.139c.243-.23.244-.236.266-1.593l.02-1.247.121-.149c.067-.082.183-.183.259-.224.134-.071.389-.074 6.84-.074s6.706.003 6.84.074c.076.041.192.142.259.224l.121.149.02 1.247c.022 1.357.023 1.363.266 1.593.205.194.521.25.786.139.155-.065.375-.305.417-.457.017-.06.031-.667.031-1.349-.001-1.086-.01-1.27-.074-1.48-.228-.75-.782-1.31-1.546-1.566-.21-.07-.532-.074-6.96-.079-3.707-.003-6.848.009-6.98.026" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Reading Mask', 'accessibility-onetap' ); ?></span>
								</div>
							</button>	

							<!-- Feature  Reading Line -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-reading-line onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M5.74 3.266a3.841 3.841 0 0 0-2.334 1.031c-.526.494-.95 1.287-1.093 2.045-.037.194-.053.671-.053 1.578 0 1.29.001 1.301.093 1.449.357.574 1.223.443 1.363-.207.026-.123.044-.667.044-1.356 0-1.271.021-1.425.25-1.863.165-.314.619-.768.933-.933.507-.266.065-.25 7.057-.25 6.994 0 6.554-.016 7.054.25.466.249.868.708 1.073 1.224.085.214.091.298.111 1.606.022 1.356.024 1.383.115 1.529a.74.74 0 0 0 1.368-.235c.071-.342.029-2.536-.056-2.909-.334-1.469-1.393-2.529-2.89-2.894-.251-.061-.828-.068-6.575-.073a830.09 830.09 0 0 0-6.46.008m-3.925 8.01c-.486.123-.717.728-.432 1.132.219.31.309.332 1.337.332.495 0 .949-.014 1.009-.031.152-.042.392-.262.457-.417a.742.742 0 0 0-.139-.786c-.223-.235-.269-.245-1.227-.253-.484-.005-.936.006-1.005.023m4.636.001c-.177.045-.305.135-.438.309-.098.128-.113.183-.113.417 0 .242.013.285.124.423.249.308.275.314 1.363.314h.966l.172-.121c.236-.166.334-.346.334-.619s-.097-.453-.334-.619l-.172-.121-.886-.008c-.488-.004-.945.007-1.016.025m4.643-.001c-.659.166-.791 1.031-.208 1.364.172.099.186.1 1.114.1.928 0 .942-.001 1.114-.1a.737.737 0 0 0 .006-1.274c-.178-.105-.188-.106-1.04-.114-.473-.004-.917.007-.986.024m4.597.001a.88.88 0 0 0-.479.375.88.88 0 0 0-.069.348c-.002.273.094.452.332.619l.172.121h.966c1.088 0 1.114-.006 1.363-.314.112-.138.124-.181.124-.426s-.012-.288-.124-.426c-.244-.302-.287-.313-1.276-.322-.484-.004-.938.007-1.009.025m4.729-.017a2.274 2.274 0 0 1-.149.037c-.147.032-.39.251-.457.411a.742.742 0 0 0 .139.786c.218.23.278.244 1.154.259.992.017 1.196-.016 1.412-.232.399-.399.212-1.098-.33-1.235-.164-.041-1.658-.063-1.769-.026M2.815 14.277a.8.8 0 0 0-.462.354c-.089.143-.093.181-.092.949.002 1.092.093 1.531.458 2.208a3.736 3.736 0 0 0 2.623 1.899c.409.078 12.907.078 13.316 0a3.768 3.768 0 0 0 3.004-2.912c.084-.388.122-1.61.06-1.909a.74.74 0 0 0-1.369-.235c-.087.14-.094.201-.116 1.029-.021.777-.034.906-.112 1.106a2.426 2.426 0 0 1-1.071 1.224c-.5.266-.06.25-7.054.25-6.992 0-6.55.016-7.057-.25-.314-.165-.768-.619-.933-.933-.206-.394-.25-.633-.251-1.375-.001-.731-.037-.959-.179-1.146-.159-.209-.502-.325-.765-.259" fill-rule="evenodd"></path>
										</svg>
									</span>
								</div>
								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Reading Line', 'accessibility-onetap' ); ?></span>
								</div>
							</button>

							<!-- Feature Highlight All -->
							<button type="button" role="button" aria-pressed="false" class="onetap-box-feature onetap-highlight-all onetap-remove-margin-title">
								<div class="onetap-icon">
									<span class="onetap-icon-animation">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.533 2.282c-2.527.207-4.649 2.073-5.15 4.529-.124.602-.142 1.271-.142 5.189s.018 4.587.142 5.189c.445 2.183 2.245 3.983 4.428 4.428.602.124 1.271.142 5.189.142s4.587-.018 5.189-.141c2.179-.445 3.984-2.25 4.429-4.429.123-.602.141-1.271.141-5.189s-.018-4.587-.141-5.189c-.292-1.427-1.211-2.78-2.438-3.589-.858-.566-1.705-.854-2.771-.942-.546-.045-8.323-.044-8.876.002m9.487 1.583c1.616.474 2.683 1.556 3.128 3.175.067.243.072.568.072 4.96s-.005 4.717-.072 4.96c-.229.832-.597 1.484-1.15 2.038-.554.553-1.206.921-2.038 1.15-.243.067-.568.072-4.96.072s-4.717-.005-4.96-.072c-.832-.229-1.484-.597-2.038-1.15a4.422 4.422 0 0 1-1.146-2.038c-.073-.286-.076-.511-.076-4.98V7.3l.09-.326a4.39 4.39 0 0 1 1.132-1.972A4.397 4.397 0 0 1 7.4 3.786c.055-.009 2.179-.013 4.72-.01 4.531.007 4.625.009 4.9.089m-9.84 3.97a.61.61 0 0 0-.358.375c-.114.273-.039.659.164.838.224.199.036.192 5.023.191 4.427-.001 4.659-.004 4.811-.074a.61.61 0 0 0 .358-.375.74.74 0 0 0 0-.58.61.61 0 0 0-.358-.375c-.152-.07-.383-.073-4.82-.073s-4.668.003-4.82.073m.24 3.424a1.675 1.675 0 0 1-.149.038c-.147.032-.39.251-.457.411a.736.736 0 0 0 .201.842c.08.071.196.143.256.159.143.04 9.315.04 9.458 0 .152-.042.392-.262.457-.417a.742.742 0 0 0-.139-.786c-.25-.265.129-.245-4.967-.253a424.68 424.68 0 0 0-4.66.006m-.24 3.576a.61.61 0 0 0-.358.375c-.114.273-.039.659.164.838.224.199.036.192 5.023.191 4.427-.001 4.659-.004 4.811-.074a.61.61 0 0 0 .358-.375.74.74 0 0 0 0-.58.61.61 0 0 0-.358-.375c-.152-.07-.383-.073-4.82-.073s-4.668.003-4.82.073" fill-rule="evenodd"></path></svg>
									</span>
								</div>

								<div class="onetap-title">
									<span class="onetap-heading"><?php esc_html_e( 'Highlight Al', 'accessibility-onetap' ); ?></span>
								</div>
							</button>									
						</div>
					</div>					

					<!-- Reset settings -->
					<div class="onetap-reset-settings">
						<button type="button" aria-label="Reset all settings">
							<?php esc_html_e( 'Reset Settings', 'accessibility-onetap' ); ?>
						</button>
					</div>					

					<!-- Footer bottom -->
					<footer class="onetap-footer-bottom">
						<!-- Accessibility -->
						<div class="onetap-accessibility-container">
							<ul class="onetap-icon-list-items">
								<li class="onetap-icon-list-item">
									<span class="onetap-icon-list-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128" fill="none">
											<path d="M116.627 101.688L99.2097 70.0115C104.87 61.406 107.22 51.0416 105.827 40.837C104.434 30.6312 99.3894 21.2763 91.6299 14.5043C83.869 7.73115 73.9186 4 63.6174 4C53.317 4 43.3665 7.73115 35.6049 14.5043C27.8451 21.2763 22.8004 30.631 21.4074 40.837C20.013 51.0419 22.3646 61.4063 28.025 70.0115L10.5892 101.688C10.1888 102.411 9.98603 103.226 10.0007 104.053C10.0155 104.879 10.2477 105.687 10.6732 106.395C11.0704 107.121 11.662 107.721 12.3828 108.125C13.1036 108.531 13.9242 108.725 14.7501 108.688L30.3124 108.57L38.5408 121.783C39.4003 123.162 40.9081 123.999 42.5326 124H42.664C44.3325 123.954 45.8509 123.028 46.6568 121.566L63.6074 90.7484L80.5537 121.548C81.3586 123.009 82.878 123.935 84.5455 123.981H84.6769C86.3013 123.98 87.81 123.143 88.6697 121.764L96.8981 108.551L112.46 108.669H112.459C114.113 108.636 115.643 107.784 116.542 106.395C116.967 105.687 117.199 104.879 117.214 104.053C117.229 103.226 117.026 102.411 116.626 101.688L116.627 101.688ZM63.609 13.4862C72.4111 13.4862 80.8517 16.983 87.0751 23.2066C93.2984 29.4302 96.7955 37.8719 96.7955 46.6727C96.7955 55.4748 93.2987 63.9154 87.0751 70.1398C80.8515 76.3634 72.4109 79.8592 63.609 79.8592C54.8072 79.8592 46.3663 76.3634 40.143 70.1398C33.9194 63.9151 30.4225 55.4745 30.4225 46.6727C30.432 37.8748 33.932 29.4396 40.1535 23.2171C46.3749 16.9957 54.8101 13.4967 63.609 13.4862V13.4862ZM42.2855 109.986L36.91 101.357H36.9089C36.0347 99.9766 34.5143 99.1402 32.8803 99.1402L22.7122 99.2159L34.5279 77.7366C40.0515 82.9313 46.8645 86.5532 54.2606 88.2293L42.2855 109.986ZM94.3402 99.1591H94.3391C92.7084 99.1717 91.1933 100.005 90.3105 101.376L84.9339 109.967L72.9586 88.2094V88.2105C80.3547 86.5346 87.1676 82.9128 92.6913 77.7178L104.507 99.1971L94.3402 99.1591ZM46.4656 64.707C46.3111 66.3619 47.0413 67.9758 48.3863 68.953C49.7312 69.9302 51.4912 70.1246 53.018 69.4658L63.6094 64.8991L74.2009 69.4658C75.7276 70.1246 77.4877 69.9302 78.8326 68.953C80.1776 67.9758 80.9078 66.3619 80.7534 64.707L79.6805 53.2024L87.2878 44.5452H87.2868C88.3848 43.298 88.7431 41.5643 88.2303 39.9829C87.7176 38.4026 86.4084 37.2099 84.7881 36.8443L73.5379 34.3163L67.6581 24.3836C66.746 23.0439 65.2309 22.2412 63.6095 22.2412C61.9881 22.2412 60.4731 23.0439 59.561 24.3836L53.6822 34.3026L42.432 36.8306H42.431C40.8107 37.1952 39.5014 38.3889 38.9887 39.9692C38.476 41.5495 38.8343 43.2831 39.9323 44.5315L47.5385 53.2021L46.4656 64.707ZM57.7252 43.0766V43.0776C58.9892 42.7939 60.0809 42.0016 60.7429 40.8879L63.6093 36.0114L66.4756 40.8499C67.1376 41.9637 68.2293 42.756 69.4934 43.0397L74.9824 44.2732L71.2679 48.5098V48.5088C70.4126 49.4817 69.9944 50.7636 70.1142 52.054L70.6364 57.6514L65.4584 55.4249H65.4595C64.269 54.9111 62.9209 54.9111 61.7305 55.4249L56.5524 57.6514L57.0746 52.054H57.0757C57.1955 50.7637 56.7783 49.4818 55.922 48.5088L52.2075 44.2722L57.7252 43.0766Z" fill="currentColor"></path>
										</svg>
									</span>
									<span class="onetap-icon-list-text"></span>
								</li>
							</ul>
						</div>

						<!-- Divider version -->
						<div class="onetap-divider-container">
							<div class="onetap-divider">
								<span class="onetap-divider-separator">
									<span class="onetap-divider__text">
										<?php
										// Construct the file path of the plugin.
										$plugin_file = ACCESSIBILITY_ONETAP_DIR_PATH . 'accessibility-onetap.php';

										// Check if the plugin file exists.
										if ( file_exists( $plugin_file ) ) {
											// Include the necessary WordPress file for plugin data retrieval.
											require_once ABSPATH . 'wp-admin/includes/plugin.php';

											// Retrieve the plugin data.
											$plugin_info = get_plugin_data( $plugin_file );

											// Extract relevant plugin information.
											$plugin_version = $plugin_info['Version'];
											esc_html_e( 'Version ', 'accessibility-onetap' );
											echo esc_html( $plugin_version );
										}
										?>
									</span>
								</span>
							</div>
						</div>
					</footer>
				</div>
			</section>
		</nav>
		<div class="onetap-markup-reading-line"></div>
		<div class="onetap-markup-reading-mask onetap-top"></div>
		<div class="onetap-markup-reading-mask onetap-bottom"></div>
		<div class="onetap-markup-text-magnifier" style="display: none;"></div>
		<?php
	}
}
