<?php
defined('ABSPATH') || exit;

/**
 * Compatibility with theme: Storefront (by WooCommerce).
 */
class SimpleCheckout_ThemeCompat_Storefront extends SimpleCheckout
{

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
		// Page container class
		remove_filter('sc_content_section_class', array(SimpleCheckout_Steps::instance(), 'sc_content_section_class'), 10);

		// Coupon code button style
		add_filter('sc_coupon_code_apply_button_classes', array($this, 'change_coupon_code_apply_button_class'), 10);
	}



	/**
	 * Change coupon code apply button class.
	 *
	 * @param   string  $class  Coupon code apply button class.
	 */
	public function change_coupon_code_apply_button_class($class)
	{
		return $class . ' button alt';
	}
}

SimpleCheckout_ThemeCompat_Storefront::instance();
