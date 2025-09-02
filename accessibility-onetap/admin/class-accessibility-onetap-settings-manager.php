<?php
/**
 * Accessibility Settings Manager for Onetap.
 *
 * @link       https://wponetap.com
 * @since      1.0.0
 *
 * @package    Accessibility_Onetap_Settings_Manager
 * @subpackage Accessibility_Onetap_Settings_Manager/admin
 */

/**
 * Accessibility Settings Manager for Onetap.
 *
 * Handles the settings related to accessibility in the Onetap Pro plugin.
 *
 * @package    Accessibility_Onetap_Settings_Manager
 * @subpackage Accessibility_Onetap_Settings_Manager/admin
 * @author     OneTap <support@wponetap.com>
 */
class Accessibility_Onetap_Settings_Manager {

	/**
	 * Settings sections array.
	 *
	 * @var array
	 */
	protected $settings_sections = array();

	/**
	 * Settings fields array.
	 *
	 * @var array
	 */
	protected $settings_fields = array();

	/**
	 * Initialize __construct.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts and styles for the admin area.
	 *
	 * This function ensures that necessary scripts and styles are loaded on
	 * specific admin pages of the plugin. It loads the WordPress color picker,
	 * media uploader, jQuery, and a custom JavaScript file for managing settings.
	 *
	 * @param string $hook The current admin page hook suffix.
	 */
	public function admin_enqueue_scripts( $hook ) {
		// Enqueue the WordPress color picker style.
		wp_enqueue_style( 'wp-color-picker' );

		// Enqueue the media uploader script.
		wp_enqueue_media();

		// Enqueue the WordPress color picker script.
		wp_enqueue_script( 'wp-color-picker' );

		// Enqueue the jQuery library.
		wp_enqueue_script( 'jquery' );

		// Conditionally enqueue the settings manager script for specific plugin admin pages.
		if ( 'toplevel_page_accessibility-onetap-settings' === $hook ||
			'onetap_page_accessibility-onetap-general-settings' === $hook ||
			'onetap_page_accessibility-onetap-alt-text' === $hook ||
			'onetap_page_accessibility-onetap-modules' === $hook ||
			'admin_page_onetap-module-labels' === $hook ||
			'onetap_page_accessibility-onetap-accessibility-status' === $hook
		) {
			wp_enqueue_script( 'accessibility-plugin-onetap-pro-settings-manager', ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/js/settings-manager.min.js', array( 'jquery' ), ACCESSIBILITY_ONETAP_VERSION, true );
		}
	}

	/**
	 * Set settings sections.
	 *
	 * @param array $sections setting sections array.
	 */
	public function set_sections( $sections ) {
		$this->settings_sections = $sections;

		return $this;
	}

	/**
	 * Add a single section.
	 *
	 * @param array $section The section details.
	 */
	public function add_section( $section ) {
		$this->settings_sections[] = $section;

		return $this;
	}

	/**
	 * Set settings fields.
	 *
	 * @param array $fields settings fields array.
	 */
	public function set_fields( $fields ) {
		$this->settings_fields = $fields;

		return $this;
	}

	/**
	 * Add settings fields.
	 *
	 * @param array $section settings section array.
	 * @param array $field settings fields array.
	 */
	public function add_field( $section, $field ) {
		$defaults = array(
			'name'  => '',
			'label' => '',
			'desc'  => '',
			'type'  => 'text',
		);

		$arg                                 = wp_parse_args( $field, $defaults );
		$this->settings_fields[ $section ][] = $arg;

		return $this;
	}

	/**
	 * Initialize and registers the settings sections and fileds to WordPress.
	 *
	 * Usually this should be called at `admin_init` hook.
	 *
	 * This function gets the initiated settings sections and fields. Then
	 * registers them to WordPress and ready for use.
	 */
	public function admin_init() {
		// register settings sections.
		foreach ( $this->settings_sections as $section ) {
			if ( false === get_option( $section['id'] ) ) {
				add_option( $section['id'] );
			}

			if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
				$section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
				$callback        = function () use ( $section ) {
					echo esc_html( str_replace( '"', '\"', $section['desc'] ) );
				};
			} elseif ( isset( $section['callback'] ) ) {
				$callback = $section['callback'];
			} else {
				$callback = null;
			}

			add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
		}

		// register settings fields.
		foreach ( $this->settings_fields as $section => $field ) {
			foreach ( $field as $option ) {

				$anchor                   = isset( $option['anchor'] ) ? $option['anchor'] : '';
				$color_list               = isset( $option['color_list'] ) ? $option['color_list'] : '';
				$device_visibility        = isset( $option['device_visibility'] ) ? $option['device_visibility'] : '';
				$feature_desc             = isset( $option['feature_desc'] ) ? $option['feature_desc'] : '';
				$feature_name             = isset( $option['feature_name'] ) ? $option['feature_name'] : '';
				$first_control            = isset( $option['first_control'] ) ? $option['first_control'] : '';
				$is_pro                   = isset( $option['is_pro'] ) ? $option['is_pro'] : '';
				$label                    = isset( $option['label'] ) ? $option['label'] : '';
				$last_control             = isset( $option['last_control'] ) ? $option['last_control'] : '';
				$name                     = $option['name'];
				$radio_image_list         = isset( $option['radio_image_list'] ) ? $option['radio_image_list'] : '';
				$radio_text_list          = isset( $option['radio_text_list'] ) ? $option['radio_text_list'] : '';
				$select_badge             = isset( $option['select_badge'] ) ? $option['select_badge'] : '';
				$select_options           = isset( $option['select_options'] ) ? $option['select_options'] : '';
				$setting_description      = isset( $option['setting_description'] ) ? $option['setting_description'] : '';
				$setting_title            = isset( $option['setting_title'] ) ? $option['setting_title'] : '';
				$show_save_button         = isset( $option['show_save_button'] ) ? $option['show_save_button'] : '';
				$status                   = isset( $option['status'] ) ? $option['status'] : '';
				$switch_icon              = isset( $option['switch_icon'] ) ? $option['switch_icon'] : '';
				$switch_style             = isset( $option['switch_style'] ) ? $option['switch_style'] : '';
				$module_icon              = isset( $option['module_icon'] ) ? $option['module_icon'] : '';
				$module_style             = isset( $option['module_style'] ) ? $option['module_style'] : '';
				$copyable_icon            = isset( $option['copyable_icon'] ) ? $option['copyable_icon'] : '';
				$copyable_style           = isset( $option['copyable_style'] ) ? $option['copyable_style'] : '';
				$copy_text                = isset( $option['copy_text'] ) ? $option['copy_text'] : '';
				$button_text              = isset( $option['button_text'] ) ? $option['button_text'] : '';
				$button_icon              = isset( $option['button_icon'] ) ? $option['button_icon'] : '';
				$button_class             = isset( $option['button_class'] ) ? $option['button_class'] : '';
				$button_link              = isset( $option['button_link'] ) ? $option['button_link'] : '';
				$hide_setting_description = isset( $option['hide_setting_description'] ) ? (bool) $option['hide_setting_description'] : false;
				$type                     = isset( $option['type'] ) ? $option['type'] : 'text';
				$callback                 = isset( $option['callback'] ) ? array( $this, $option['callback'] ) : array( $this, 'callback_' . $type );

				$args = array(
					'anchor'                   => $anchor,
					'class'                    => isset( $option['class'] ) ? $option['class'] : $name,
					'color_list'               => $color_list,
					'device_visibility'        => $device_visibility,
					'feature_desc'             => $feature_desc,
					'feature_name'             => $feature_name,
					'first_control'            => $first_control,
					'id'                       => $name,
					'is_pro'                   => $is_pro,
					'label'                    => $label,
					'label_for'                => "{$section}[{$name}]",
					'last_control'             => $last_control,
					'max'                      => isset( $option['max'] ) ? $option['max'] : '',
					'min'                      => isset( $option['min'] ) ? $option['min'] : '',
					'name'                     => $label,
					'placeholder'              => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
					'radio_image_list'         => $radio_image_list,
					'radio_text_list'          => $radio_text_list,
					'sanitize_callback'        => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
					'section'                  => $section,
					'select_badge'             => $select_badge,
					'select_options'           => $select_options,
					'setting_description'      => $setting_description,
					'setting_title'            => $setting_title,
					'show_save_button'         => $show_save_button,
					'status'                   => $status,
					'step'                     => isset( $option['step'] ) ? $option['step'] : '',
					'std'                      => isset( $option['default'] ) ? $option['default'] : '',
					'switch_icon'              => $switch_icon,
					'switch_style'             => $switch_style,
					'module_icon'              => $module_icon,
					'module_style'             => $module_style,
					'copyable_icon'            => $copyable_icon,
					'copyable_style'           => $copyable_style,
					'copy_text'                => $copy_text,
					'button_text'              => $button_text,
					'button_icon'              => $button_icon,
					'button_class'             => $button_class,
					'button_link'              => $button_link,
					'hide_setting_description' => $hide_setting_description,
					'type'                     => $type,
					'units'                    => isset( $option['units'] ) ? $option['units'] : '',
				);

				add_settings_field( "{$section}[{$name}]", $label, $callback, $section, $section, $args );
			}
		}

		// creates our settings in the options table.
		foreach ( $this->settings_sections as $section ) {
			register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
		}
	}

	/**
	 * Get common allowed HTML tags for wp_kses.
	 *
	 * @return array Allowed HTML tags array.
	 */
	protected function get_allowed_html() {
		return array(
			'h4'       => array(
				'class' => array(),
			),
			'p'        => array(
				'class' => array(),
			),
			'a'        => array(
				'class'         => array(),
				'href'          => array(),
				'target'        => array(),
				'title'         => array(),
				'data-image-id' => array(),
			),
			'div'      => array(
				'class'       => array(),
				'style'       => array(),
				'data-device' => array(),
			),
			'ul'       => array(
				'class' => array(),
			),
			'li'       => array(
				'class'      => array(),
				'data-color' => array(),
				'style'      => array(),
			),
			'img'      => array(
				'class' => array(),
				'src'   => array(),
			),
			'span'     => array(
				'id'             => array(),
				'class'          => array(),
				'license-status' => array(),
			),
			'label'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'input'    => array(
				'type'           => array(),
				'class'          => array(),
				'id'             => array(),
				'name'           => array(),
				'value'          => array(),
				'style'          => array(),
				'placeholder'    => array(),
				'checked'        => array(),
				'min'            => array(),
				'max'            => array(),
				'step'           => array(),
				'license-status' => array(),
				'license-key'    => array(),
				'readonly'       => array(),
			),
			'textarea' => array(
				'rows'          => array(),
				'cols'          => array(),
				'class'         => array(),
				'id'            => array(),
				'name'          => array(),
				'value'         => array(),
				'placeholder'   => array(),
				'data-image-id' => array(),
			),
			'select'   => array(
				'class' => array(),
				'name'  => array(),
				'id'    => array(),
			),
			'option'   => array(
				'value'    => array(),
				'selected' => array(),
			),
			'button'   => array(
				'type'             => array(),
				'class'            => array(),
				'style'            => array(),
				'title'            => array(),
				'data-image-id'    => array(),
				'aria-pressed'     => array(),
				'data-device-type' => array(),
			),
			'svg'      => array(
				'class'   => array(),
				'viewBox' => array(),
				'width'   => array(),
				'height'  => array(),
				'fill'    => array(),
				'xmlns'   => array(),
			),
			'g'        => array(
				'clip-path' => array(),
			),
			'clipPath' => array(
				'id'   => array(),
				'rect' => array(),
			),
			'rect'     => array(
				'width'     => array(),
				'height'    => array(),
				'fill'      => array(),
				'transform' => array(),
			),
			'defs'     => array(),
			'path'     => array(
				'd'               => array(),
				'fill'            => array(),
				'stroke'          => array(),
				'stroke-width'    => array(),
				'stroke-linecap'  => array(),
				'stroke-linejoin' => array(),
			),
		);
	}

	/**
	 * Parse common arguments for template rendering.
	 *
	 * @param array $args Settings field arguments.
	 * @return array Parsed arguments.
	 */
	protected function parse_template_args( $args ) {
		$value                    = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$label                    = isset( $args['label'] ) ? $args['label'] : '';
		$setting_title            = isset( $args['setting_title'] ) ? $args['setting_title'] : '';
		$setting_description      = isset( $args['setting_description'] ) ? $args['setting_description'] : '';
		$first_control            = ! empty( $args['first_control'] ) ? ' first-control' : '';
		$last_control             = ! empty( $args['last_control'] ) ? ' last-control' : '';
		$show_save_button         = ! empty( $args['show_save_button'] );
		$hide_setting_description = isset( $args['hide_setting_description'] ) ? (bool) $args['hide_setting_description'] : false;
		$type                     = isset( $args['type'] ) ? $args['type'] : 'default';
		$classes                  = 'setting-control' . $first_control . ' ' . $last_control . ' ' . esc_attr( $type );

		return array(
			'value'                    => $value,
			'label'                    => $label,
			'setting_title'            => $setting_title,
			'setting_description'      => $setting_description,
			'first_control'            => $first_control,
			'last_control'             => $last_control,
			'show_save_button'         => $show_save_button,
			'hide_setting_description' => $hide_setting_description,
			'type'                     => $type,
			'classes'                  => $classes,
			'args'                     => $args,
		);
	}

	/**
	 * Build common HTML structure for settings templates.
	 *
	 * @param array  $parsed_args Parsed template arguments.
	 * @param string $content Inner content for the template.
	 * @return string Generated HTML.
	 */
	protected function build_template_structure( $parsed_args, $content = '' ) {
		// Build device visibility classes.
		$device_visibility_class = '';
		$active_class            = '';
		$device_visibility_attr  = '';
		$viewport_class          = '';
		$hide_description_class  = '';

		if ( isset( $parsed_args['args']['device_visibility'] ) && ! empty( $parsed_args['args']['device_visibility'] ) ) {
			$device_visibility_class = $parsed_args['args']['device_visibility'] . ' device';

			// Add data attribute for device when device_visibility is set.
			$device_visibility_attr = ' data-device="' . esc_attr( $parsed_args['args']['device_visibility'] ) . '"';

			// Add preview viewport classes similar to the preview markup.
			$viewport_class = ' preview-viewport viewport-' . esc_attr( $parsed_args['args']['device_visibility'] );

			// Add active class if device_visibility is desktop.
			if ( 'desktop' === $parsed_args['args']['device_visibility'] ) {
				$active_class = ' active';
			}
		}

		// Add hide description class if hide_setting_description is true.
		if ( $parsed_args['hide_setting_description'] ) {
			$hide_description_class = ' hide-setting-description';
		}

		$html  = '<div class="settings-group ' . esc_attr( $parsed_args['args']['id'] ) . ' ' . $device_visibility_class . $viewport_class . $active_class . $hide_description_class . '"' . $device_visibility_attr . '>';
		$html .= '<div class="' . $parsed_args['classes'] . '">';

		if ( $parsed_args['setting_title'] ) {
			$html .= '<span class="setting-title">' . $parsed_args['setting_title'] . '</span>';
		}

		if ( $parsed_args['setting_description'] && ! $parsed_args['hide_setting_description'] ) {
			$html .= '<span class="setting-description">' . $parsed_args['setting_description'] . '</span>';
		}

		if ( $parsed_args['label'] ) {
			$html .= '<span class="control-heading">' . esc_html( $parsed_args['label'] ) . '</span>';
		}

		$html .= '<div class="boxes">';
		$html .= $content;
		$html .= '</div>'; // .boxes

		if ( $parsed_args['show_save_button'] ) {
			$html .= '<button class="save-changes">' . esc_html__( 'Save Changes', 'accessibility-onetap' ) . '</button>';
		}

		$html .= '</div>'; // .setting-control
		$html .= '</div>'; // .settings-group

		return $html;
	}

	/**
	 * Render template with common structure.
	 *
	 * @param array  $args Settings field arguments.
	 * @param string $content Inner content for the template.
	 * @param string $type Template type for default type fallback.
	 */
	protected function render_template( $args, $content = '', $type = 'default' ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = $type;
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $type );

		$html = $this->build_template_structure( $parsed_args, $content );
		echo wp_kses( $html, $this->get_allowed_html() );
	}

	/**
	 * Callback function for rendering divider template in settings.
	 *
	 * This method generates HTML for a visual divider element used to separate
	 * different sections or groups of settings. The divider provides visual
	 * separation and improves the overall layout and readability of the settings page.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_divider( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'divider';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build input HTML.
		$input_html  = '<div class="box box1">';
		$input_html .= '<div class="divider"></div>';
		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'divider' );
	}

	/**
	 * Callback function to render the save changes button template.
	 *
	 * This method creates a save changes button with proper styling and classes.
	 * It parses the provided arguments, sets default values, and renders the button
	 * using the template rendering system.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_save_changes( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'submit';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build input HTML.
		$input_html  = '<div class="box box1">';
		$input_html .= '<button class="save-changes">' . esc_html__( 'Save Changes', 'accessibility-onetap' ) . '</button>';
		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'submit' );
	}

	/**
	 * Callback function for rendering switch template in settings.
	 *
	 * This method generates HTML for a toggle switch control with customizable content
	 * including optional icon, PRO status badge, feature name, and description.
	 * The switch supports various styling options and can be configured for different
	 * feature types with conditional display of elements.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_switch( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'switch';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build switch content attributes.
		$switch_icon  = isset( $args['switch_icon'] ) ? esc_url( $args['switch_icon'] ) : '';
		$is_pro       = isset( $args['is_pro'] ) ? (bool) $args['is_pro'] : false;
		$feature_name = isset( $args['feature_name'] ) ? esc_html( $args['feature_name'] ) : '';
		$feature_desc = isset( $args['feature_desc'] ) ? esc_html( $args['feature_desc'] ) : '';
		$switch_style = isset( $args['switch_style'] ) ? esc_attr( $args['switch_style'] ) : '';

		// Build PRO feature information attributes.
		$pro_title     = isset( $args['pro_title'] ) ? esc_html( $args['pro_title'] ) : __( 'This is a PRO Feature', 'accessibility-onetap' );
		$pro_desc      = isset( $args['pro_desc'] ) ? esc_html( $args['pro_desc'] ) : __( ' to use this Feature.', 'accessibility-onetap' );
		$pro_link_text = isset( $args['pro_link_text'] ) ? esc_html( $args['pro_link_text'] ) : __( 'Upgrade to Pro', 'accessibility-onetap' );
		$upgrade_link  = isset( $args['upgrade_link'] ) ? esc_url( $args['upgrade_link'] ) : 'https://wponetap.com/pricing/';

		// Check if label exists and is not empty, then add padding-top-0 class (except for switch2 style).
		$label_class = ( isset( $args['label'] ) && ! empty( $args['label'] ) && 'switch2' !== $switch_style ) ? ' padding-top-0' : '';

		// Build input HTML.
		$input_html = '<div class="box box1' . ( ! empty( $switch_style ) ? ' ' . $switch_style : '' ) . ( $is_pro ? ' pro' : '' ) . $label_class . '">';

		$input_html .= '<div class="left">';

		// Icon section - only show if switch_icon is provided.
		if ( ! empty( $switch_icon ) ) {
			$input_html .= '<div class="icon">';
			$input_html .= '<img src="' . $switch_icon . '" alt="icon">';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="text">';

		// Display feature name - only show if feature_name exists (regardless of is_pro status).
		if ( ! empty( $feature_name ) ) {
			$input_html .= '<span class="feature-name">' . $feature_name . ( $is_pro ? '<span class="pro">' . esc_html__( 'PRO', 'accessibility-onetap' ) . '</span>' : '' ) . '</span>';
		}

		// Feature description - only show if feature_desc is provided (regardless of is_pro status).
		if ( ! empty( $feature_desc ) ) {
			$input_html .= '<span class="feature-desc">' . $feature_desc . '</span>';
		}

		$input_html .= '</div>';

		$input_html .= '</div>';

		$input_html .= '<div class="right">';

		// Show PRO feature information if is_pro is true.
		if ( $is_pro ) {
			$input_html .= '<div class="pro-info">';
			$input_html .= '<h4 class="pro-title">' . $pro_title . '</h4>';
			$input_html .= '<p class="pro-desc">';
			$input_html .= '<a target="_blank" href="' . $upgrade_link . '" class="upgrade-link">' . $pro_link_text . '</a> ' . $pro_desc;
			$input_html .= '</p>';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="box-swich">';
		$input_html .= '<label class="switch" for="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']">';
		$input_html .= '<input type="checkbox" id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="on"' . checked( $parsed_args['value'], 'on', false ) . '>';
		$input_html .= '<span class="slider round"></span>';
		$input_html .= '</label>';
		$input_html .= '</div>';
		$input_html .= '</div>';

		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'switch' );
	}

	/**
	 * Callback function for rendering number input template in settings.
	 *
	 * This method generates HTML for a number input field with customizable attributes
	 * such as min, max, step values, and optional save button. It supports various
	 * styling options and accessibility features.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_number( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'number';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build input attributes.
		$placeholder = ! empty( $args['placeholder'] ) ? 'placeholder="' . esc_attr( $args['placeholder'] ) . '"' : '';
		$min         = ( '' === $args['min'] ) ? '' : ' min="' . esc_attr( $args['min'] ) . '"';
		$max         = ( '' === $args['max'] ) ? '' : ' max="' . esc_attr( $args['max'] ) . '"';
		$step        = ( '' === $args['step'] ) ? '' : ' step="' . esc_attr( $args['step'] ) . '"';

		// Build input HTML.
		$input_html  = '<div class="box box1">';
		$input_html .= '<input type="' . esc_attr( $parsed_args['type'] ) . '" class="number" id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . absint( $parsed_args['value'] ) . '"' . $placeholder . $min . $max . $step . '/>';
		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'number' );
	}

	/**
	 * Callback function for rendering number slider template in settings.
	 *
	 * This method generates HTML for a number slider input field with range slider and number input.
	 * It supports customizable min, max, and step values with proper sanitization for security.
	 * The slider provides visual feedback while the number input allows precise value entry.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_number_slider( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'number-slider';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build input attributes.
		$min  = ( '' === $args['min'] ) ? '' : ' min="' . esc_attr( $args['min'] ) . '"';
		$max  = ( '' === $args['max'] ) ? '' : ' max="' . esc_attr( $args['max'] ) . '"';
		$step = ( '' === $args['step'] ) ? '' : ' step="' . esc_attr( $args['step'] ) . '"';

		// Get unit value with fallback to 'px'.
		$unit = isset( $args['units'] ) && ! empty( $args['units'] ) ? esc_attr( $args['units'] ) : 'px';

		// Build input HTML.
		$input_html  = '<div class="box box1">';
		$input_html .= '<div class="box-range">';
		$input_html .= '<input type="range" value="' . floatval( $parsed_args['value'] ) . '"' . $min . $max . $step . '>';
		$input_html .= '</div>';

		$input_html .= '<div class="box-number">';
		$input_html .= '<input type="number" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . absint( $parsed_args['value'] ) . '"' . $min . $max . $step . '>';
		$input_html .= '<span class="unit">' . $unit . '</span>';
		$input_html .= '</div>';
		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'number-slider' );
	}

	/**
	 * Callback function for rendering text input template in settings.
	 *
	 * This method generates HTML for a text input field with customizable attributes
	 * and optional save button. It supports various styling options and accessibility features.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_text( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'text';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build input attributes.
		$placeholder = ! empty( $args['placeholder'] ) ? 'placeholder="' . esc_attr( $args['placeholder'] ) . '"' : '';

		// Build input HTML.
		$input_html  = '<div class="box box1">';
		$input_html .= '<input type="' . esc_attr( $parsed_args['type'] ) . '" class="number" id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $parsed_args['value'] ) . '"' . $placeholder . '/>';
		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'text' );
	}

	/**
	 * Render a title and description section for settings forms.
	 *
	 * Outputs a settings section with optional title, description, label, and save button.
	 * This template is used for displaying informational content or section headers
	 * in the settings page without any input fields.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_title_and_description( $args ) {
		$this->render_template( $args, '', 'title-and-description' );
	}

	/**
	 * Render a device preview selector for settings forms.
	 *
	 * Outputs a device preview section with desktop, tablet, and mobile options.
	 * Allows users to preview how the accessibility widget will appear on different devices.
	 * Includes SVG icons for each device type and optional save button.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_devices_tabs( $args ) {
		// Build devices HTML.
		$devices_html  = '<div class="box box1">';
		$devices_html .= '<div class="devices-tabs">';

		// Desktop.
		$devices_html .= '<button type="button" class="preview-desktop active" aria-pressed="true" data-device-type="desktop">';
		$devices_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path d="M6.5 16.5H13.1667M9.83333 13.1667V16.5M5.5 13.1667H14.1667C15.5668 13.1667 16.2669 13.1667 16.8016 12.8942C17.272 12.6545 17.6545 12.272 17.8942 11.8016C18.1667 11.2669 18.1667 10.5668 18.1667 9.16667V5.5C18.1667 4.09987 18.1667 3.3998 17.8942 2.86502C17.6545 2.39462 17.272 2.01217 16.8016 1.77248C16.2669 1.5 15.5668 1.5 14.1667 1.5H5.5C4.09987 1.5 3.3998 1.5 2.86502 1.77248C2.39462 2.01217 2.01217 2.39462 1.77248 2.86502C1.5 3.3998 1.5 4.09987 1.5 5.5V9.16667C1.5 10.5668 1.5 11.2669 1.77248 11.8016C2.01217 12.272 2.39462 12.6545 2.86502 12.8942C3.3998 13.1667 4.09987 13.1667 5.5 13.1667Z" stroke="#717680" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		$devices_html .= esc_html__( 'Desktop', 'accessibility-onetap' );
		$devices_html .= '</button>';

		// Tablet.
		$devices_html .= '<button type="button" class="preview-tablet" aria-pressed="false" data-device-type="tablet">';
		$devices_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 15 20" fill="none"><path d="M7.50004 14.5833H7.50837M3.50004 18.3333H11.5C12.4335 18.3333 12.9002 18.3333 13.2567 18.1516C13.5703 17.9918 13.8253 17.7369 13.9851 17.4233C14.1667 17.0668 14.1667 16.6 14.1667 15.6666V4.33329C14.1667 3.39987 14.1667 2.93316 13.9851 2.57664C13.8253 2.26304 13.5703 2.00807 13.2567 1.84828C12.9002 1.66663 12.4335 1.66663 11.5 1.66663H3.50004C2.56662 1.66663 2.09991 1.66663 1.74339 1.84828C1.42979 2.00807 1.17482 2.26304 1.01503 2.57664C0.833374 2.93316 0.833374 3.39987 0.833374 4.33329V15.6666C0.833374 16.6 0.833374 17.0668 1.01503 17.4233C1.17482 17.7369 1.42979 17.9918 1.74339 18.1516C2.09991 18.3333 2.56662 18.3333 3.50004 18.3333ZM7.91671 14.5833C7.91671 14.8134 7.73016 15 7.50004 15C7.26992 15 7.08337 14.8134 7.08337 14.5833C7.08337 14.3532 7.26992 14.1666 7.50004 14.1666C7.73016 14.1666 7.91671 14.3532 7.91671 14.5833Z" stroke="#A4A7AE" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		$devices_html .= esc_html__( 'Tablet', 'accessibility-onetap' );
		$devices_html .= '</button>';

		// Mobile.
		$devices_html .= '<button type="button" class="preview-mobile" aria-pressed="false" data-device-type="mobile">';
		$devices_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="20" viewBox="0 0 14 20" fill="none"><path d="M6.66659 14.5833H6.67492M3.49992 18.3333H9.83325C10.7667 18.3333 11.2334 18.3333 11.5899 18.1516C11.9035 17.9918 12.1585 17.7369 12.3183 17.4233C12.4999 17.0668 12.4999 16.6 12.4999 15.6666V4.33329C12.4999 3.39987 12.4999 2.93316 12.3183 2.57664C12.1585 2.26304 11.9035 2.00807 11.5899 1.84828C11.2334 1.66663 10.7667 1.66663 9.83325 1.66663H3.49992C2.5665 1.66663 2.09979 1.66663 1.74327 1.84828C1.42966 2.00807 1.1747 2.26304 1.01491 2.57664C0.833252 2.93316 0.833252 3.39987 0.833252 4.33329V15.6666C0.833252 16.6 0.833252 17.0668 1.01491 17.4233C1.1747 17.7369 1.42966 17.9918 1.74327 18.1516C2.09979 18.3333 2.5665 18.3333 3.49992 18.3333ZM7.08325 14.5833C7.08325 14.8134 6.8967 15 6.66659 15C6.43647 15 6.24992 14.8134 6.24992 14.5833C6.24992 14.3532 6.43647 14.1666 6.66659 14.1666C6.8967 14.1666 7.08325 14.3532 7.08325 14.5833Z" stroke="#A4A7AE" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		$devices_html .= esc_html__( 'Mobile', 'accessibility-onetap' );
		$devices_html .= '</button>';

		$devices_html .= '</div>';
		$devices_html .= '</div>';

		$this->render_template( $args, $devices_html, 'devices' );
	}

	/**
	 * Render a radio field with image/icon options for settings forms.
	 *
	 * Outputs a group of radio buttons where each option is represented by an image/icon.
	 * Optionally displays a 'Save Changes' button below the options.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_radio_image( $args ) {
		$parsed_args      = $this->parse_template_args( $args );
		$radio_image_list = isset( $args['radio_image_list'] ) && is_array( $args['radio_image_list'] ) ? $args['radio_image_list'] : array();

		// Build radio image HTML.
		$radio_html = '';
		$index      = 1;
		foreach ( $radio_image_list as $image_value => $image ) {
			$checked     = ( $parsed_args['value'] === $image_value ) ? 'checked' : '';
			$input_id    = esc_attr( $args['id'] ) . esc_attr( str_replace( 'design-icon', '', $image_value ) );
			$radio_html .= '<div class="box box' . $index . '">';
			$radio_html .= '<label class="label ' . $checked . '">';
			$radio_html .= '<img src="' . ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/' . esc_attr( $image ) . '" />';
			$radio_html .= '<input type="radio" class="' . $checked . '" id="' . $input_id . '" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $image_value ) . '" ' . $checked . ' />';
			$radio_html .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4C0 1.79086 1.79086 0 4 0H12C14.2091 0 16 1.79086 16 4V12C16 14.2091 14.2091 16 12 16H4C1.79086 16 0 14.2091 0 12V4Z" fill="#0048FE"/><path d="M12 5L6.5 10.5L4 8" stroke="white" stroke-width="1.6666" stroke-linecap="round" stroke-linejoin="round"/></svg>';
			$radio_html .= '</label>';
			$radio_html .= '</div>';
			++$index;
		}

		$this->render_template( $args, $radio_html, 'radio-image' );
	}

	/**
	 * Render a radio field with text options for settings forms.
	 *
	 * Outputs a group of radio buttons where each option is represented by an text.
	 * Optionally displays a 'Save Changes' button below the options.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_radio_text( $args ) {
		$parsed_args     = $this->parse_template_args( $args );
		$radio_text_list = isset( $args['radio_text_list'] ) && is_array( $args['radio_text_list'] ) ? $args['radio_text_list'] : array();

		// Build radio text HTML.
		$radio_html = '';
		$index      = 1;
		foreach ( $radio_text_list as $text_value => $text ) {
			$checked     = ( $parsed_args['value'] === $text_value ) ? 'checked' : '';
			$input_id    = esc_attr( $args['id'] ) . esc_attr( str_replace( 'design-text', '', $text_value ) );
			$radio_html .= '<div class="box box' . $index . '">';
			$radio_html .= '<label class="label ' . $checked . '">';
			$radio_html .= '<span class="text">';
			$radio_html .= $text;
			$radio_html .= '</span>';
			$radio_html .= '<input type="radio" class="' . $checked . '" id="' . $input_id . '" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $text_value ) . '" ' . $checked . ' />';
			$radio_html .= '</label>';
			$radio_html .= '</div>';
			++$index;
		}

		$this->render_template( $args, $radio_html, 'radio-text' );
	}

	/**
	 * Render a copyable text field for settings forms.
	 *
	 * Outputs a text field with copy functionality that allows users to copy text to clipboard.
	 * This template is used for displaying text that can be copied, such as URLs or codes.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_copyable_text( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'copyable_text';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build copyable text content attributes.
		$copyable_icon  = isset( $args['copyable_icon'] ) ? esc_url( $args['copyable_icon'] ) : '';
		$is_pro         = isset( $args['is_pro'] ) ? (bool) $args['is_pro'] : false;
		$feature_name   = isset( $args['feature_name'] ) ? esc_html( $args['feature_name'] ) : '';
		$feature_desc   = isset( $args['feature_desc'] ) ? esc_html( $args['feature_desc'] ) : '';
		$copyable_style = isset( $args['copyable_style'] ) ? esc_attr( $args['copyable_style'] ) : '';

		// Build PRO feature information attributes.
		$pro_title     = isset( $args['pro_title'] ) ? esc_html( $args['pro_title'] ) : __( 'This is a PRO Feature', 'accessibility-onetap' );
		$pro_desc      = isset( $args['pro_desc'] ) ? esc_html( $args['pro_desc'] ) : __( ' to use this Feature.', 'accessibility-onetap' );
		$pro_link_text = isset( $args['pro_link_text'] ) ? esc_html( $args['pro_link_text'] ) : __( 'Upgrade to Pro', 'accessibility-onetap' );
		$upgrade_link  = isset( $args['upgrade_link'] ) ? esc_url( $args['upgrade_link'] ) : 'https://wponetap.com/pricing/';

		// Check if label exists and is not empty, then add padding-top-0 class (except for style2 style).
		$label_class = ( isset( $args['label'] ) && ! empty( $args['label'] ) && 'style2' !== $copyable_style ) ? ' padding-top-0' : '';

		// Build input HTML.
		$input_html = '<div class="box box1' . ( ! empty( $copyable_style ) ? ' ' . $copyable_style : '' ) . ( $is_pro ? ' pro' : '' ) . $label_class . '">';

		$input_html .= '<div class="left">';

		// Icon section - only show if copyable_icon is provided.
		if ( ! empty( $copyable_icon ) ) {
			$input_html .= '<div class="icon">';
			$input_html .= '<img src="' . $copyable_icon . '" alt="icon">';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="text">';

		// Display feature name - only show if feature_name exists (regardless of is_pro status).
		if ( ! empty( $feature_name ) ) {
			$input_html .= '<span class="feature-name">' . $feature_name . ( $is_pro ? '<span class="pro">' . esc_html__( 'PRO', 'accessibility-onetap' ) . '</span>' : '' ) . '</span>';
		}

		// Feature description - only show if feature_desc is provided (regardless of is_pro status).
		if ( ! empty( $feature_desc ) ) {
			$input_html .= '<span class="feature-desc">' . $feature_desc . '</span>';
		}

		$input_html .= '</div>';

		$input_html .= '</div>';

		$input_html .= '<div class="right">';

		// Show PRO feature information if is_pro is true.
		if ( $is_pro ) {
			$input_html .= '<div class="pro-info">';
			$input_html .= '<h4 class="pro-title">' . $pro_title . '</h4>';
			$input_html .= '<p class="pro-desc">';
			$input_html .= '<a target="_blank" href="' . $upgrade_link . '" class="upgrade-link">' . $pro_link_text . '</a> ' . $pro_desc;
			$input_html .= '</p>';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="box-copy-text">';

		$input_html .= '<div class="copy-text">';
		$input_html .= $args['copy_text'];
		$input_html .= '</div>';

		$input_html .= '<button type="button" class="copy-button" data-copy-text="' . esc_attr( $args['copy_text'] ) . '" data-success-text="' . esc_attr( __( 'Copied!', 'accessibility-onetap' ) ) . '" data-error-text="' . esc_attr( __( 'Failed!', 'accessibility-onetap' ) ) . '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><g clip-path="url(#clip0_622_885)"><path d="M4.1665 12.5C3.38993 12.5 3.00165 12.5 2.69536 12.3731C2.28698 12.204 1.96253 11.8795 1.79337 11.4711C1.6665 11.1648 1.6665 10.7766 1.6665 9.99999V4.33332C1.6665 3.3999 1.6665 2.93319 1.84816 2.57667C2.00795 2.26307 2.26292 2.0081 2.57652 1.84831C2.93304 1.66666 3.39975 1.66666 4.33317 1.66666H9.99984C10.7764 1.66666 11.1647 1.66666 11.471 1.79352C11.8794 1.96268 12.2038 2.28714 12.373 2.69552C12.4998 3.0018 12.4998 3.39009 12.4998 4.16666M10.1665 18.3333H15.6665C16.5999 18.3333 17.0666 18.3333 17.4232 18.1517C17.7368 17.9919 17.9917 17.7369 18.1515 17.4233C18.3332 17.0668 18.3332 16.6001 18.3332 15.6667V10.1667C18.3332 9.23324 18.3332 8.76653 18.1515 8.41001C17.9917 8.0964 17.7368 7.84143 17.4232 7.68165C17.0666 7.49999 16.5999 7.49999 15.6665 7.49999H10.1665C9.23308 7.49999 8.76637 7.49999 8.40985 7.68165C8.09625 7.84143 7.84128 8.0964 7.68149 8.41001C7.49984 8.76653 7.49984 9.23324 7.49984 10.1667V15.6667C7.49984 16.6001 7.49984 17.0668 7.68149 17.4233C7.84128 17.7369 8.09625 17.9919 8.40985 18.1517C8.76637 18.3333 9.23308 18.3333 10.1665 18.3333Z" stroke="#A4A7AE" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_622_885"><rect width="20" height="20" fill="white"/></clipPath></defs></svg>' . __( 'Copy', 'accessibility-onetap' ) . '</button>';

		$input_html .= '</div>';

		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'copyable_text' );
	}



	/**
	 * Render a module labels input field for settings forms.
	 *
	 * Creates a custom input field specifically designed for module label customization.
	 * The function supports both free and PRO features, with different visual indicators
	 * and functionality based on the feature status.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_module_labels( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$camel_case_id          = lcfirst( str_replace( ' ', '', ucwords( str_replace( array( '-', '_' ), ' ', $args['id'] ) ) ) );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'module-labels';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build module labels content attributes.
		$module_icon  = isset( $args['module_icon'] ) ? esc_url( $args['module_icon'] ) : '';
		$is_pro       = isset( $args['is_pro'] ) ? (bool) $args['is_pro'] : false;
		$feature_name = isset( $args['feature_name'] ) ? esc_html( $args['feature_name'] ) : '';
		$feature_desc = isset( $args['feature_desc'] ) ? esc_html( $args['feature_desc'] ) : '';
		$module_style = isset( $args['module_style'] ) ? esc_attr( $args['module_style'] ) : '';

		// Build PRO feature information attributes.
		$pro_title     = isset( $args['pro_title'] ) ? esc_html( $args['pro_title'] ) : __( 'This is a PRO Feature', 'accessibility-onetap' );
		$pro_desc      = isset( $args['pro_desc'] ) ? esc_html( $args['pro_desc'] ) : __( ' to use this Feature.', 'accessibility-onetap' );
		$pro_link_text = isset( $args['pro_link_text'] ) ? esc_html( $args['pro_link_text'] ) : __( 'Upgrade to Pro', 'accessibility-onetap' );
		$upgrade_link  = isset( $args['upgrade_link'] ) ? esc_url( $args['upgrade_link'] ) : 'https://wponetap.com/pricing/';

		// Check if label exists and is not empty, then add padding-top-0 class (except for switch2 style).
		$label_class = ( isset( $args['label'] ) && ! empty( $args['label'] ) && 'switch2' !== $module_style ) ? ' padding-top-0' : '';

		// Build input attributes.
		$placeholder_text = ! empty( $args['placeholder'] ) ? $args['placeholder'] : __( 'Enter Custom Label', 'accessibility-onetap' );

		// Build input HTML.
		$input_html = '<div class="box box1' . ( ! empty( $module_style ) ? ' ' . $module_style : '' ) . ( $is_pro ? ' pro' : '' ) . $label_class . '">';

		$input_html .= '<div class="left">';

		// Icon section - only show if module_icon is provided.
		if ( ! empty( $module_icon ) ) {
			$input_html .= '<div class="icon">';
			$input_html .= '<img src="' . $module_icon . '" alt="icon">';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="text">';

		// Display feature name - only show if feature_name exists (regardless of is_pro status).
		if ( ! empty( $feature_name ) ) {
			$input_html .= '<span class="feature-name">' . $feature_name . ( $is_pro ? '<span class="pro">' . esc_html__( 'PRO', 'accessibility-onetap' ) . '</span>' : '' ) . '</span>';
		}

		// Feature description - only show if feature_desc is provided (regardless of is_pro status).
		if ( ! empty( $feature_desc ) ) {
			$input_html .= '<span class="feature-desc">' . $feature_desc . '</span>';
		}

		$input_html .= '</div>';

		$input_html .= '</div>';

		$input_html .= '<div class="right">';

		// Show PRO feature information if is_pro is true.
		if ( $is_pro ) {
			$input_html .= '<div class="pro-info">';
			$input_html .= '<h4 class="pro-title">' . $pro_title . '</h4>';
			$input_html .= '<p class="pro-desc">';
			$input_html .= '<a target="_blank" href="' . $upgrade_link . '" class="upgrade-link">' . $pro_link_text . '</a> ' . $pro_desc;
			$input_html .= '</p>';
			$input_html .= '</div>';
		}

		$input_html .= '<input type="text" class="text ' . esc_attr( $camel_case_id ) . '" id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" placeholder="' . esc_attr( $placeholder_text ) . '"/>';

		$input_html .= '<button type="submit" class="save-changes">';
		$input_html .= esc_html__( 'Save', 'accessibility-onetap' );
		$input_html .= '</button>';

		$input_html .= '</div>';

		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'module-labels' );
	}

	/**
	 * Render a select dropdown field for settings forms.
	 *
	 * Outputs a select dropdown with predefined options from the select_options array.
	 * Includes optional title, description, label, and save button.
	 * The select field allows users to choose from a list of predefined options.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_select( $args ) {
		$parsed_args    = $this->parse_template_args( $args );
		$select_options = isset( $args['select_options'] ) ? $args['select_options'] : array();
		$select_badge   = isset( $args['select_badge'] ) ? $args['select_badge'] : '';

		// Build select HTML.
		$select_html  = '<div class="box box1">';
		$select_html .= '<select id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']">';

		foreach ( $select_options as $key => $label ) {
			$select_html .= '<option value="' . esc_attr( $key ) . '"' . selected( $parsed_args['value'], $key, false ) . '>' . esc_html( $label ) . '</option>';
		}

		$select_html .= '</select>';
		$select_html .= $select_badge ? ' <span class="badge">' . $select_badge . '</span>' : '';
		$select_html .= '</div>';

		$this->render_template( $args, $select_html, 'select' );
	}

	/**
	 * Callback template for image list with alt text management.
	 *
	 * @param array $args Arguments for the template.
	 */
	public function callback_template_image_alt_list( $args ) {
		$parsed_args         = $this->parse_template_args( $args );
		$parsed_args['type'] = isset( $args['type'] ) ? $args['type'] : 'alt-text';

		// Get current page for pagination.
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$current_page = isset( $_GET['alt_text_page'] ) ? max( 1, intval( $_GET['alt_text_page'] ) ) : 1;
		$per_page     = 10; // Number of images per page.
		$offset       = ( $current_page - 1 ) * $per_page;

		// Get images from WordPress Media Library.
		$image_list   = $this->get_media_library_images( $per_page, $offset );
		$total_images = $this->get_total_media_count();
		$total_pages  = ceil( $total_images / $per_page );

		// Build image list HTML with dynamic data.
		$list_html  = '<div class="box box1">';
		$list_html .= '<div class="box-image-alt">';

		// Table header.
		$list_html .= '<div class="table-header">';
		$list_html .= '<div class="row">';
		$list_html .= '<div class="table-heading col thumbnail">' . __( 'Thumbnail', 'accessibility-onetap' ) . '</div>';
		$list_html .= '<div class="table-heading col alt-text">' . __( 'Alt Text', 'accessibility-onetap' ) . '</div>';
		$list_html .= '<div class="table-heading col uploaded">' . __( 'Uploaded', 'accessibility-onetap' ) . '</div>';
		$list_html .= '<div class="table-heading col actions">' . __( 'Actions', 'accessibility-onetap' ) . '</div>';
		$list_html .= '</div>';
		$list_html .= '</div>';

		// Table body.
		$list_html .= '<div class="table-body">';

		if ( ! empty( $image_list ) ) {
			foreach ( $image_list as $image ) {
				$thumbnail_url = isset( $image['thumbnail'] ) ? $image['thumbnail'] : '';
				$alt_text      = isset( $image['alt_text'] ) ? $image['alt_text'] : '';
				$upload_date   = isset( $image['upload_date'] ) ? $image['upload_date'] : '';
				$image_id      = isset( $image['id'] ) ? $image['id'] : '';

				$list_html .= '<div class="row" data-image-id="' . esc_attr( $image_id ) . '">';

				// Thumbnail column.
				$list_html .= '<div class="col thumbnail">';
				if ( $thumbnail_url ) {
					$list_html .= '<div class="image-thumbnail" style="background-image: url(' . esc_url( $thumbnail_url ) . '); background-size: cover; background-position: center; background-repeat: no-repeat;" title="' . esc_attr( $alt_text ) . '"></div>';
				}
				$list_html .= '</div>';

				// Alt text column.
				$list_html .= '<div class="col alt-text">';
				if ( $alt_text && 'edit' !== $alt_text ) {
					$list_html .= '<span class="text">' . esc_html( $alt_text ) . '</span>';
				} elseif ( 'edit' === $alt_text ) {
					$list_html .= '<textarea placeholder="' . __( 'Enter a Alt-text...', 'accessibility-onetap' ) . '" data-image-id="' . esc_attr( $image_id ) . '"></textarea>';
				} else {
					$list_html .= '<span class="text">' . esc_html( $alt_text ) . '</span>';
				}
				$list_html .= '</div>';

				// Uploaded column.
				$list_html .= '<div class="col uploaded">';
				$list_html .= '<span class="upload-date">' . esc_html( $upload_date ) . '</span>';
				$list_html .= '</div>';

				// Actions column.
				$list_html .= '<div class="col actions">';
				$list_html .= '<div class="action-buttons">';

				// AI button.
				$list_html .= '<a href="https://www.altpilot.ai/" target="_blank" class="button ai-btn" title="Generate with AltPilot.ai" data-image-id="' . esc_attr( $image_id ) . '">';
				$list_html .= '<img src="' . ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/ai-generate.svg" alt="AltPilot.ai" />';
				$list_html .= '</a>';

				// Edit button.
				$list_html .= '<button type="button" class="button edit-btn" title="Edit alt text" data-image-id="' . esc_attr( $image_id ) . '">';
				$list_html .= '<img src="' . ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/pencil.svg" alt="edit" />';
				$list_html .= '</button>';

				// Save button.
				$list_html .= '<button type="button" class="hide button save-btn" title="Save alt text" data-image-id="' . esc_attr( $image_id ) . '">';
				$list_html .= '<img src="' . ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/save.svg" alt="save" />';
				$list_html .= '</button>';

				$list_html .= '</div>';
				$list_html .= '</div>';

				$list_html .= '</div>'; // End row.
			}
		} else {
			// No images found.
			$list_html .= '<div class="row no-images">';
			$list_html .= '<div class="col" style="text-align: center; padding: 40px;">';
			$list_html .= '<p>' . __( 'No images found in Media Library.', 'accessibility-onetap' ) . '</p>';
			$list_html .= '</div>';
			$list_html .= '</div>';
		}

		$list_html .= '</div>'; // End table-body.
		$list_html .= '</div>'; // End box-image-alt.

		// Pagination.
		if ( $total_pages > 1 ) {
			$list_html .= '<div class="box-navigation">';

			// Previous button.
			$list_html .= '<div class="col prev">';
			if ( $current_page > 1 ) {
				$prev_url   = add_query_arg( 'alt_text_page', $current_page - 1 );
				$list_html .= '<a href="' . esc_url( $prev_url ) . '" class="button prev-btn">';
				$list_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none"><path d="M18.0279 11.4872H5.02222M5.02222 11.4872L11.5251 17.99M5.02222 11.4872L11.5251 4.98431" stroke="#A4A7AE" stroke-width="1.85796" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				$list_html .= __( 'Previous', 'accessibility-onetap' );
				$list_html .= '</a>';
			} else {
				$list_html .= '<a href="#" class="button disable prev-btn">';
				$list_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none"><path d="M18.0279 11.4872H5.02222M5.02222 11.4872L11.5251 17.99M5.02222 11.4872L11.5251 4.98431" stroke="#D5D7DA" stroke-width="1.85796" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				$list_html .= __( 'Previous', 'accessibility-onetap' );
				$list_html .= '</a>';
			}
			$list_html .= '</div>';

			// Page numbers.
			$list_html .= '<div class="col links">';
			$list_html .= '<ul>';

			// Show page numbers with ellipsis for large numbers.
			$start_page = max( 1, $current_page - 2 );
			$end_page   = min( $total_pages, $current_page + 2 );

			if ( $start_page > 1 ) {
				$list_html .= '<li><a href="' . esc_url( add_query_arg( 'alt_text_page', 1 ) ) . '">1</a></li>';
				if ( $start_page > 2 ) {
					$list_html .= '<li>...</li>';
				}
			}

			for ( $i = $start_page; $i <= $end_page; $i++ ) {
				if ( $i === $current_page ) {
					$list_html .= '<li><a href="#" class="current">' . $i . '</a></li>';
				} else {
					$list_html .= '<li><a href="' . esc_url( add_query_arg( 'alt_text_page', $i ) ) . '">' . $i . '</a></li>';
				}
			}

			if ( $end_page < $total_pages ) {
				if ( $end_page < $total_pages - 1 ) {
					$list_html .= '<li>...</li>';
				}
				$list_html .= '<li><a href="' . esc_url( add_query_arg( 'alt_text_page', $total_pages ) ) . '">' . $total_pages . '</a></li>';
			}

			$list_html .= '</ul>';
			$list_html .= '</div>';

			// Next button.
			$list_html .= '<div class="col next">';
			if ( $current_page < $total_pages ) {
				$next_url   = add_query_arg( 'alt_text_page', $current_page + 1 );
				$list_html .= '<a href="' . esc_url( $next_url ) . '" class="button next-btn">';
				$list_html .= __( 'Next', 'accessibility-onetap' );
				$list_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none"><path d="M4.97217 11.4872H17.9779M17.9779 11.4872L11.475 4.98431M17.9779 11.4872L11.475 17.99" stroke="#A4A7AE" stroke-width="1.85796" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				$list_html .= '</a>';
			} else {
				$list_html .= '<a href="#" class="button disable next-btn">';
				$list_html .= __( 'Next', 'accessibility-onetap' );
				$list_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none"><path d="M4.97217 11.4872H17.9779M17.9779 11.4872L11.475 4.98431M17.9779 11.4872L11.475 17.99" stroke="#D5D7DA" stroke-width="1.85796" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				$list_html .= '</a>';
			}
			$list_html .= '</div>';

			$list_html .= '</div>'; // End box-navigation.
		}

		$list_html .= '</div>'; // End box.

		$this->render_template( $args, $list_html, 'image-alt-list' );
	}

	/**
	 * Get images from WordPress Media Library with pagination.
	 *
	 * @param int $per_page Number of images per page.
	 * @param int $offset Offset for pagination.
	 * @return array Array of image data.
	 */
	private function get_media_library_images( $per_page = 10, $offset = 0 ) {
		$args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_status'    => 'inherit',
			'posts_per_page' => $per_page,
			'offset'         => $offset,
			'orderby'        => 'ID',
			'order'          => 'DESC',
		);

		$query  = new WP_Query( $args );
		$images = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$attachment_id = get_the_ID();
				$attachment    = get_post( $attachment_id );

				// Get thumbnail URL.
				$thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
				$thumbnail_url = $thumbnail_url ? $thumbnail_url[0] : '';

				// Get alt text.
				$alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				if ( empty( $alt_text ) ) {
					$alt_text = '-';
				}

				// Get upload date.
				$upload_date = get_the_date( 'd M Y, H:i', $attachment_id );

				$images[] = array(
					'id'          => $attachment_id,
					'thumbnail'   => $thumbnail_url,
					'alt_text'    => $alt_text,
					'upload_date' => $upload_date,
				);
			}
			wp_reset_postdata();
		}

		return $images;
	}

	/**
	 * Get total count of images in Media Library.
	 *
	 * @return int Total number of images.
	 */
	private function get_total_media_count() {
		$args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		);

		$query = new WP_Query( $args );
		return $query->found_posts;
	}

	/**
	 * Render a color picker field with predefined color options for settings forms.
	 *
	 * Outputs a color picker input with a list of predefined color options.
	 * Includes a color preview display and allows users to select from predefined colors
	 * or use the WordPress color picker for custom colors.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_color( $args ) {
		$parsed_args = $this->parse_template_args( $args );
		$color_list  = isset( $args['color_list'] ) ? $args['color_list'] : array();

		// Build color picker HTML.
		$color_html  = '<div class="box box1" style="--outline-color:' . esc_attr( $parsed_args['value'] ) . '">';
		$color_html .= '<input type="text" class="color-picker-field" id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $parsed_args['value'] ) . '" data-default-color="' . esc_attr( $args['std'] ) . '" />';
		$color_html .= '</div>';
		$color_html .= '<div class="box box2">';
		$color_html .= '<span class="color-result">' . esc_attr( $parsed_args['value'] ) . '</span>';
		$color_html .= '</div>';
		$color_html .= '<div class="box box3">';
		if ( ! empty( $color_list ) ) {
			$color_html .= '<ul>';
			foreach ( $color_list as $color ) {
				$color_html .= '<li data-color="' . esc_attr( $color ) . '" style="background: ' . esc_attr( $color ) . ';"></li>';
			}
			$color_html .= '</ul>';
		}
		$color_html .= '</div>';

		$this->render_template( $args, $color_html, 'color' );
	}

	/**
	 * Render a feature card for settings forms.
	 *
	 * Outputs a feature card with icon, description, PRO information, and action button.
	 * This template is used for displaying feature information with copyable text and edit functionality.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_feature_card( $args ) {
		$parsed_args            = $this->parse_template_args( $args );
		$parsed_args['type']    = isset( $args['type'] ) ? $args['type'] : 'feature_card';
		$parsed_args['classes'] = 'setting-control' . $parsed_args['first_control'] . ' ' . $parsed_args['last_control'] . ' ' . esc_attr( $parsed_args['type'] );

		// Build feature card content attributes.
		$feature_icon  = isset( $args['feature_icon'] ) ? esc_url( $args['feature_icon'] ) : '';
		$is_pro        = isset( $args['is_pro'] ) ? (bool) $args['is_pro'] : false;
		$feature_name  = isset( $args['feature_name'] ) ? esc_html( $args['feature_name'] ) : '';
		$feature_desc  = isset( $args['feature_desc'] ) ? esc_html( $args['feature_desc'] ) : '';
		$feature_style = isset( $args['feature_style'] ) ? esc_attr( $args['feature_style'] ) : '';

		// Build PRO feature information attributes.
		$pro_title     = isset( $args['pro_title'] ) ? esc_html( $args['pro_title'] ) : __( 'This is a PRO Feature', 'accessibility-onetap' );
		$pro_desc      = isset( $args['pro_desc'] ) ? esc_html( $args['pro_desc'] ) : __( ' to use this Feature.', 'accessibility-onetap' );
		$pro_link_text = isset( $args['pro_link_text'] ) ? esc_html( $args['pro_link_text'] ) : __( 'Upgrade to Pro', 'accessibility-onetap' );
		$upgrade_link  = isset( $args['upgrade_link'] ) ? esc_url( $args['upgrade_link'] ) : 'https://wponetap.com/pricing/';

		// Build button attributes.
		$button_text  = isset( $args['button_text'] ) ? esc_html( $args['button_text'] ) : '';
		$button_icon  = isset( $args['button_icon'] ) ? esc_url( $args['button_icon'] ) : '';
		$button_class = isset( $args['button_class'] ) ? esc_attr( $args['button_class'] ) : '';
		$button_link  = isset( $args['button_link'] ) ? esc_url( $args['button_link'] ) : '';

		// Check if label exists and is not empty, then add padding-top-0 class (except for style2 style).
		$label_class = ( isset( $args['label'] ) && ! empty( $args['label'] ) && 'style2' !== $feature_style ) ? ' padding-top-0' : '';

		// Build input HTML.
		$input_html = '<div class="box box1' . ( ! empty( $feature_style ) ? ' ' . $feature_style : '' ) . ( $is_pro ? ' pro' : '' ) . $label_class . '">';

		$input_html .= '<div class="left">';

		// Icon section - only show if feature_icon is provided.
		if ( ! empty( $feature_icon ) ) {
			$input_html .= '<div class="icon">';
			$input_html .= '<img src="' . $feature_icon . '" alt="icon">';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="text">';

		// Display feature name - only show if feature_name exists (regardless of is_pro status).
		if ( ! empty( $feature_name ) ) {
			$input_html .= '<span class="feature-name">' . $feature_name . ( $is_pro ? '<span class="pro">' . esc_html__( 'PRO', 'accessibility-onetap' ) . '</span>' : '' ) . '</span>';
		}

		// Feature description - only show if feature_desc is provided (regardless of is_pro status).
		if ( ! empty( $feature_desc ) ) {
			$input_html .= '<span class="feature-desc">' . $feature_desc . '</span>';
		}

		$input_html .= '</div>';

		$input_html .= '</div>';

		$input_html .= '<div class="right">';

		// Show PRO feature information if is_pro is true.
		if ( $is_pro ) {
			$input_html .= '<div class="pro-info">';
			$input_html .= '<h4 class="pro-title">' . $pro_title . '</h4>';
			$input_html .= '<p class="pro-desc">';
			$input_html .= '<a target="_blank" href="' . $upgrade_link . '" class="upgrade-link">' . $pro_link_text . '</a> ' . $pro_desc;
			$input_html .= '</p>';
			$input_html .= '</div>';
		}

		$input_html .= '<div class="box-button-link">';

		// Build button/link element based on whether link is provided.
		if ( ! empty( $button_link ) ) {
			// Create link if button_link is provided.
			$input_html .= '<a href="' . $button_link . '" target="_blank"' . ( ! empty( $button_class ) ? ' class="' . $button_class . '"' : '' ) . '>';
		} else {
			// Create button if no link provided.
			$input_html .= '<button' . ( ! empty( $button_class ) ? ' class="' . $button_class . '"' : '' ) . '>';
		}

		// Add icon if provided.
		if ( ! empty( $button_icon ) ) {
			$input_html .= '<img src="' . $button_icon . '" alt="button icon" class="button-icon">';
		}

		$input_html .= $button_text;

		// Close the appropriate element.
		if ( ! empty( $button_link ) ) {
			$input_html .= '</a>';
		} else {
			$input_html .= '</button>';
		}

		$input_html .= '</div>';

		$input_html .= '</div>';

		$this->render_template( $args, $input_html, 'feature_card' );
	}

	/**
	 * Render a license key input field with status display and activation controls.
	 *
	 * Outputs a license key input field with status indicator and activation/deactivation button.
	 * Includes license status display and proper validation attributes.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_template_license( $args ) {
		$parsed_args = $this->parse_template_args( $args );

		// Get license status and configuration.
		$license_status = $this->get_license_status_config();

		// Build license input HTML.
		$html = $this->build_license_input_html( $args, $parsed_args, $license_status );

		$this->render_template( $args, $html, 'text' );
	}

	/**
	 * Get license status configuration.
	 *
	 * @return array License status configuration.
	 */
	private function get_license_status_config() {
		$status = get_option( 'onetap_license_status' );

		if ( $status ) {
			return array(
				'label'       => __( 'Active', 'accessibility-onetap' ),
				'button_text' => __( 'Deactivate License', 'accessibility-onetap' ),
				'status'      => 1,
				'readonly'    => ' readonly="readonly"',
			);
		}

		return array(
			'label'       => __( 'Inactive', 'accessibility-onetap' ),
			'button_text' => __( 'Activate License', 'accessibility-onetap' ),
			'status'      => 0,
			'readonly'    => '',
		);
	}

	/**
	 * Build license input HTML.
	 *
	 * @param array $args Settings arguments.
	 * @param array $parsed_args Parsed arguments.
	 * @param array $license_status License status configuration.
	 * @return string HTML output.
	 */
	private function build_license_input_html( $args, $parsed_args, $license_status ) {

		$html = '<div class="box box1">';

		// Compute readonly based on label being exactly "Active".
		$label_text    = isset( $license_status['label'] ) ? (string) $license_status['label'] : '';
		$is_active     = ( '' !== $label_text && 'Active' === $label_text );
		$readonly_attr = $is_active ? ' readonly="readonly"' : '';

		// License status label.
		$html .= '<span class="license-status-label" license-status="' . esc_attr( $license_status['status'] ) . '">' . esc_html( $license_status['label'] ) . '</span>';

		// License input field.
		$html .= '<input 
			type="text" 
			id="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']"
			name="' . esc_attr( $args['section'] ) . '[' . esc_attr( $args['id'] ) . ']"
			value="' . esc_attr( $parsed_args['value'] ) . '"
			placeholder="XXXXX-XXXXX-XXXXX-XXXXX"
			license-status="' . esc_attr( $license_status['status'] ) . '"
			license-key="' . esc_attr( $parsed_args['value'] ) . '"'
			. $readonly_attr
			. '/>';

		// License activation button.
		$button_class = 'save-changes license';
		if ( $license_status['status'] ) {
			$button_class .= ' license-active';
		}

		$html .= '<button class="' . esc_attr( $button_class ) . '">' . esc_html( $license_status['button_text'] ) . '</button>';

		$html .= '</div>';

		return $html;
	}

	/**
	 * Sanitize callback for Settings API.
	 *
	 * @param object $options sanitize options.
	 */
	public function sanitize_options( $options ) {

		if ( ! $options ) {
			$options = array();
		}

		// Get all registered switch fields to check for missing checkboxes.
		$all_switch_fields = array();
		foreach ( $this->settings_fields as $section => $section_options ) {
			foreach ( $section_options as $option ) {
				if ( isset( $option['type'] ) && 'switch' === $option['type'] ) {
					$all_switch_fields[ $option['name'] ] = $option;
				}
			}
		}

		// Handle missing checkbox values (set to 'off' if not present).
		foreach ( $all_switch_fields as $field_name => $field_config ) {
			if ( ! isset( $options[ $field_name ] ) ) {
				$options[ $field_name ] = 'off';
			}
		}

		foreach ( $options as $option_slug => $option_value ) {
			$sanitize_callback = $this->get_sanitize_callback( $option_slug );

			// If callback is set, call it.
			if ( $sanitize_callback ) {
				$options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
				continue;
			}
		}

		return $options;
	}

	/**
	 * Get sanitization callback for given option slug.
	 *
	 * @param string $slug option slug.
	 *
	 * @return mixed string or bool false.
	 */
	public function get_sanitize_callback( $slug = '' ) {
		if ( empty( $slug ) ) {
			return false;
		}

		// Iterate over registered fields and see if we can find proper callback.
		foreach ( $this->settings_fields as $section => $options ) {
			foreach ( $options as $option ) {
				if ( $option['name'] !== $slug ) {
					continue;
				}

				// Return the callback name.
				return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
			}
		}

		return false;
	}

	/**
	 * Get the value of a settings field.
	 *
	 * @param string $option  settings field name.
	 * @param string $section the section name this field belongs to.
	 * @param string $default_value default value text if it's not found.
	 * @return string
	 */
	public function get_option( $option, $section, $default_value = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		// For switch/checkbox type fields, return 'off' as default if no default is specified.
		if ( empty( $default_value ) ) {
			// Check if this is a switch field.
			foreach ( $this->settings_fields as $section_name => $section_options ) {
				foreach ( $section_options as $field ) {
					if ( $field['name'] === $option && isset( $field['type'] ) && 'switch' === $field['type'] ) {
						return 'off';
					}
				}
			}
		}

		return $default_value;
	}

	/**
	 * Show navigations as tab.
	 *
	 * Shows all the settings section labels as tab.
	 */
	public function show_navigation() {
		$html = '<h2 class="nav-tab-wrapper">';

		$count = count( $this->settings_sections );

		// Don't show the navigation if only one section exists.
		if ( 1 === $count ) {
			return;
		}

		foreach ( $this->settings_sections as $tab ) {
			$html .= '<a href="' . esc_url( '#' . $tab['id'] ) . '" class="nav-tab" id="' . esc_attr( $tab['id'] ) . '-tab">' . esc_html( $tab['title'] ) . '</a>';
		}

		$html .= '</h2>';

		echo wp_kses(
			$html,
			array(
				'h2' => array(),
				'a'  => array(
					'href'  => array(),
					'class' => array(),
					'id'    => array(),
				),
			)
		);
	}

	/**
	 * Show the section settings forms.
	 *
	 * This function displays every sections in a different form.
	 */
	public function show_forms() {
		?>
		<div class="options-wrapper">
			<?php foreach ( $this->settings_sections as $form ) { ?>
				<div id="<?php echo esc_attr( $form['id'] ); ?>" class="group" style="display: none;">
					<form method="post" action="options.php">
						<?php
						do_action( 'accessibility_plugin_onetap_pro_settings_manager_form_top_' . $form['id'], $form );
						settings_fields( $form['id'] );
						do_settings_sections( $form['id'] );
						do_action( 'accessibility_plugin_onetap_pro_settings_manager_form_bottom_' . $form['id'], $form );
						if ( isset( $this->settings_fields[ $form['id'] ] ) ) :
							?>
						<div class="submit-button">
							<?php submit_button(); ?>
						</div>
						<?php endif; ?>
					</form>
				</div>
			<?php } ?>
		</div>
		<?php
	}
}