<?php
defined('ABSPATH') || exit;

/**
 * Compatibility with plugin: WooCommerce Amazon Pay (by WooCommerce).
 */
class SimpleCheckout_WooCommerceGatewayAmazonPaymentsAdvanced extends SimpleCheckout
{

	public $amazon_pay_gateway;
	public $amazon_pay_gateway_legacy;

	/**
	 * __construct function.
	 */
	public function __construct()
	{
		$this->hooks();
	}



	/**
	 * Initialize hooks.
	 */
	public function hooks()
	{
		// Very late hooks
		add_action('wp', array($this, 'very_late_hooks'), 100);

		// Admin settings
		add_filter('sc_integrations_settings_add', array($this, 'add_settings'), 10, 2);
	}

	/**
	 * Add or remove very late hooks.
	 */
	public function very_late_hooks()
	{

		// Maybe run initialization
		if (class_exists('WC_Gateway_Amazon_Payments_Advanced')) {

			// Get the Amazon Pay objects
			$this->amazon_pay_gateway = $this->get_object_by_class_name_from_hooks('WC_Gateway_Amazon_Payments_Advanced');

			if (null !== $this->amazon_pay_gateway) {
				// Run checkout initialization later
				remove_action('woocommerce_checkout_init', array($this->amazon_pay_gateway, 'checkout_init'));
				$this->amazon_pay_gateway->checkout_init(WC()->checkout);
			}
		}

		// Maybe run legacy initialization
		if (class_exists('WC_Gateway_Amazon_Payments_Advanced_Legacy')) {

			// Get the Amazon Pay object
			$this->amazon_pay_gateway_legacy = $this->get_object_by_class_name_from_hooks('WC_Gateway_Amazon_Payments_Advanced_Legacy');

			if (null !== $this->amazon_pay_gateway_legacy) {
				// Run checkout initialization later
				remove_action('woocommerce_checkout_init', array($this->amazon_pay_gateway_legacy, 'checkout_init'));
				$this->amazon_pay_gateway_legacy->checkout_init(WC()->checkout);
			}
		}

		// Maybe move button to Express Checkout section
		if (class_exists('WC_Gateway_Amazon_Payments_Advanced')) {

			// Express Checkout
			if ('yes' === get_option('sc_enable_checkout_express_checkout', 'yes')) {

				remove_action('woocommerce_before_checkout_form', array($this->amazon_pay_gateway, 'checkout_message'), 5);

				if ('only_button' === get_option('sc_integration_woocommerce_gateway_amazon_payments_advanced_express_checkout_style', 'only_button')) {
					add_action('sc_checkout_express_checkout', array($this->amazon_pay_gateway, 'checkout_button'), 10);
				} else {
					add_action('sc_checkout_express_checkout', array($this->amazon_pay_gateway, 'checkout_message'), 10);
				}
			}
		}
	}



	/**
	 * Add new settings to the simple checkout admin settings sections.
	 *
	 * @param   array   $settings         Array with all settings for the current section.
	 * @param   string  $current_section  Current section name.
	 */
	public function add_settings($settings, $current_section)
	{

		$settings[] = array(
			'title'          => __('WooCommerce Amazon Pay', 'simple-checkout'),
			'desc'           => __('Define which components of the Amazon Pay express checkout button to display.', 'simple-checkout'),
			'id'             => 'sc_integration_woocommerce_gateway_amazon_payments_advanced_express_checkout_style',
			'options'        => array(
				'only_button'          => _x('Only button', 'Amazon Pay Express elements', 'simple-checkout'),
				'button_and_message'   => _x('Button and message', 'Amazon Pay Express elements', 'simple-checkout'),
			),
			'default'        => 'only_button',
			'type'           => 'select',
			'autoload'       => false,
		);

		return $settings;
	}
}

SimpleCheckout_WooCommerceGatewayAmazonPaymentsAdvanced::instance();
