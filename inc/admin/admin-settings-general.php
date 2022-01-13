<?php

/**
 * simple checkout General Settings
 *
 * @package simple-checkout
 * @version 1.3.1
 */

defined('ABSPATH') || exit;

if (class_exists('WC_Settings_SimpleCheckout_General_Settings', false)) {
	return new WC_Settings_SimpleCheckout_General_Settings();
}

/**
 * WC_Settings_SimpleCheckout_General_Settings.
 */
class WC_Settings_SimpleCheckout_General_Settings extends WC_Settings_Page
{

	/**
	 * __construct function.
	 */
	public function __construct()
	{
		$this->id = 'sc_checkout';
		$this->hooks();
	}



	/**
	 * Initialize hooks.
	 */
	public function hooks()
	{
		// Settings
		add_filter('woocommerce_get_settings_sc_checkout', array($this, 'add_settings'), 10, 2);
	}



	/**
	 * Add new settings to the simple checkout admin settings sections.
	 *
	 * @param   array   $settings         Array with all settings for the current section.
	 * @param   string  $current_section  Current section name.
	 */
	public function add_settings($settings, $current_section)
	{
		if (empty($current_section)) {

			$settings_new = apply_filters(
				'sc_checkout_general_settings',
				array(
					array(
						'title' => __('Layout', 'simple-checkout'),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'sc_checkout_layout_options',
					),

					array(
						'title'             => __('Checkout Layout', 'simple-checkout'),
						'id'                => 'sc_checkout_layout',
						'type'              => 'sc_layout_selector',
						'options'           => SimpleCheckout_Steps::instance()->get_allowed_checkout_layouts(),
						'default'           => 'multi-step',
						'autoload'          => false,
						'wrapper_class'     => 'sc-checkout-layout',
						'class'             => 'sc-checkout-layout__option',
					),

					array(
						'title'             => __('Logo image', 'simple-checkout'),
						'desc_tip'          => __('Choose an image to be displayed on the checkout page header. Only applies when using the plugin\'s checkout header.', 'simple-checkout'),
						'id'                => 'sc_checkout_logo_image',
						'type'              => 'sc_image_uploader',
						'autoload'          => false,
						'wrapper_class'     => 'sc-checkout-logo-image',
					),

					array(
						'title'             => __('Header background color', 'simple-checkout'),
						'desc_tip'          => __('Choose a background color for the checkout page header. Only applies when using the plugin\'s checkout header.', 'simple-checkout'),
						'desc'              => __('HTML color value. ie: #f3f3f3', 'simple-checkout'),
						'id'                => 'sc_checkout_header_background_color',
						'type'              => 'text',
						'autoload'          => false,
						'class'             => 'colorpick',
					),

					array(
						'title'             => __('Page background color', 'simple-checkout'),
						'desc_tip'          => __('Choose a background color for the checkout page. Color is applied to the <em>body</em> element.', 'simple-checkout'),
						'desc'              => __('HTML color value. ie: #f3f3f3', 'simple-checkout'),
						'id'                => 'sc_checkout_page_background_color',
						'type'              => 'text',
						'autoload'          => false,
						'class'             => 'colorpick',
					),

					array(
						'type' => 'sectionend',
						'id'   => 'sc_checkout_layout_options',
					),

					array(
						'title' => __('Features', 'simple-checkout'),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'sc_checkout_features_options',
					),

					array(
						'title'             => __('Optional fields', 'simple-checkout'),
						'desc'              => __('Hide optional fields behind a link button', 'simple-checkout'),
						'desc_tip'          => __('It is recommended to keep this options checked to reduce the number of open input fields, <a href="https://baymard.com/blog/checkout-flow-average-form-fields#1-address-line-2--company-name-can-safely-be-collapsed-behind-a-link" target="_blank">read the research</a>.', 'simple-checkout'),
						'id'                => 'sc_enable_checkout_hide_optional_fields',
						'default'           => 'yes',
						'type'              => 'checkbox',
						'checkboxgroup'     => 'start',
						'show_if_checked'   => 'option',
						'autoload'          => false,
					),
					array(
						'desc'              => __('Display the "Add" link buttons in lowercase', 'simple-checkout'),
						'desc_tip'          => __('Make the labels of optional field "Add" link button as <code>lowercase</code>. (ie. "Add phone number" instead of "Add Phone number")', 'simple-checkout'),
						'id'                => 'sc_optional_fields_link_label_lowercase',
						'default'           => 'yes',
						'type'              => 'checkbox',
						'checkboxgroup'     => '',
						'show_if_checked'   => 'yes',
						'autoload'          => false,
					),
					array(
						'desc'              => __('Do not hide "Address line 2" fields behind a link button', 'simple-checkout'),
						'desc_tip'          => __('Recommended only whe most customers actually need the "Address line 2" field, or when getting the right shipping address is crucial (ie. if delivering food and other perishable products).', 'simple-checkout'),
						'id'                => 'sc_hide_optional_fields_skip_address_2',
						'default'           => 'no',
						'type'              => 'checkbox',
						'checkboxgroup'     => 'end',
						'show_if_checked'   => 'yes',
						'autoload'          => false,
					),

					array(
						'title'         => __('Billing Address', 'simple-checkout'),
						'desc'          => __('Billing address same as the shipping address checked by default', 'simple-checkout'),
						'desc_tip'      => __('It is recommended to leave this option checked. The billing address at checkout will start with the option "Billing same as shipping" checked by default. This will reduce significantly the number of open input fields at the checkout, <a href="https://baymard.com/blog/checkout-flow-average-form-fields#3-default-billing--shipping-and-hide-the-fields-entirely" target="_blank">read the research</a>.', 'simple-checkout'),
						'id'            => 'sc_default_to_billing_same_as_shipping',
						'default'       => 'yes',
						'type'          => 'checkbox',
						'autoload'      => false,
					),

					array(
						'title'         => __('Shipping phone', 'simple-checkout'),
						'desc'          => __('Add a phone field to the shipping address form', 'simple-checkout'),
						'id'            => 'sc_shipping_phone_field_visibility',
						'options'       => array(
							'no'        => _x('Hidden', 'Shipping phone field visibility', 'simple-checkout'),
							'optional'  => _x('Optional', 'Shipping phone field visibility', 'simple-checkout'),
							'required'  => _x('Required', 'Shipping phone field visibility', 'simple-checkout'),
						),
						'default'       => 'no',
						'type'          => 'select',
						'autoload'      => false,
					),

					array(
						'desc'          => __('Choose in which step to display the shipping phone', 'simple-checkout'),
						'id'            => 'sc_shipping_phone_field_position',
						'options'       => array(
							'shipping_address' => _x('Shipping address', 'Shipping phone field position', 'simple-checkout'),
							'contact'          => _x('Contact', 'Shipping phone field position', 'simple-checkout'),
						),
						'default'       => 'shipping_address',
						'type'          => 'select',
						'autoload'      => false,
					),

					array(
						'title'             => __('Integrated Coupon Codes', 'simple-checkout'),
						'desc'              => __('Show coupon codes as a substep of the payment step', 'simple-checkout'),
						'desc_tip'          => __('Only applicable if use of coupon codes are enabled in the WooCommerce settings.', 'simple-checkout'),
						'id'                => 'sc_enable_checkout_coupon_codes',
						'default'           => 'yes',
						'type'              => 'checkbox',
						'checkboxgroup'     => 'start',
						'show_if_checked'   => 'option',
						'autoload'          => false,
					),
					array(
						'desc'              => __('Display the coupon codes section title', 'simple-checkout'),
						'id'                => 'sc_display_coupon_code_section_title',
						'type'              => 'checkbox',
						'default'           => 'no',
						'checkboxgroup'     => 'end',
						'show_if_checked'   => 'yes',
						'autoload'          => false,
					),

					array(
						'title'         => __('Order notes', 'simple-checkout'),
						'desc'          => __('Define the visibility of the additional order notes field.', 'simple-checkout'),
						'id'            => 'woocommerce_enable_order_comments',
						'options'       => array(
							'no'        => _x('Hidden', 'Order notes field visibility', 'simple-checkout'),
							'yes'       => _x('Optional', 'Order notes field visibility', 'simple-checkout'),
						),
						'default'       => 'yes',
						'type'          => 'select',
						'autoload'      => false,
					),

					array(
						'title'         => __('Express checkout', 'simple-checkout'),
						'desc'          => __('Enable the express checkout section at checkout', 'simple-checkout'),
						'desc_tip'      => __('Displays the express checkout section at checkout when supported payment gateways have this feature enabled.', 'simple-checkout'),
						'id'            => 'sc_enable_checkout_express_checkout',
						'default'       => 'yes',
						'type'          => 'checkbox',
						'autoload'      => false,
					),

					array(
						'title'             => __('Gift options', 'simple-checkout'),
						'desc'              => __('Display gift message and other gift options at the checkout page', 'simple-checkout'),
						'desc_tip'          => __('Allow customers to add a gift message and other gift related options to the order.', 'simple-checkout'),
						'id'                => 'sc_enable_checkout_gift_options',
						'default'           => 'no',
						'type'              => 'checkbox',
						'checkboxgroup'     => 'start',
						'show_if_checked'   => 'option',
						'autoload'          => false,
					),
					array(
						'desc'              => __('Display the gift message fields always expanded', 'simple-checkout'),
						'id'                => 'sc_default_gift_options_expanded',
						'type'              => 'checkbox',
						'default'           => 'no',
						'checkboxgroup'     => '',
						'show_if_checked'   => 'yes',
						'autoload'          => false,
					),
					array(
						'desc'              => __('Display the gift message as part of the order details table instead of a separate section', 'simple-checkout'),
						'desc_tip'          => __('This option affects the order confirmation page (thank you page), order details at account pages, emails and packing slips.', 'simple-checkout'),
						'id'                => 'sc_display_gift_message_in_order_details',
						'type'              => 'checkbox',
						'default'           => 'no',
						'checkboxgroup'     => 'end',
						'show_if_checked'   => 'yes',
						'autoload'          => false,
					),

					array(
						'title'             => __('Checkout Widget Areas', 'simple-checkout'),
						'desc'              => __('Add widget areas to the checkout page', 'simple-checkout'),
						'desc_tip'          => __('These widget areas are used to add trust symbols on the checkout page.', 'simple-checkout'),
						'id'                => 'sc_enable_checkout_widget_areas',
						'default'           => 'yes',
						'type'              => 'checkbox',
						'autoload'          => false,
					),

					array(
						'type' => 'sectionend',
						'id'   => 'sc_checkout_features_options',
					),
				)
			);

			$settings = apply_filters('sc_general_settings', $settings_new, $current_section);
		}

		return $settings;
	}
}

return new WC_Settings_SimpleCheckout_General_Settings();
