<?php
defined('ABSPATH') || exit;

/**
 * Compatibility with theme: Flatsome (by UX-Themes).
 */
class SimpleCheckout_ThemeCompat_Flatsome extends SimpleCheckout
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
		// Late hooks
		add_action('init', array($this, 'late_hooks'), 100);

		// Page container class
		remove_filter('sc_content_section_class', array(SimpleCheckout_Steps::instance(), 'sc_content_section_class'), 10);
		add_filter('sc_content_section_class', array($this, 'change_sc_content_section_class'), 10);

		// Make header static (not sticky at the top)
		add_filter('theme_mod_header_sticky', array($this, 'change_theme_mod_header_sticky'), 10);

		// Use theme's logo
		add_action('sc_checkout_header_logo', array($this, 'output_checkout_header_logo'), 10);
	}

	/**
	 * Add or remove late hooks.
	 */
	public function late_hooks()
	{
		// Revert Flatsome changes to the privacy policy placement at the checkout page
		remove_action('woocommerce_checkout_after_order_review', 'wc_checkout_privacy_policy_text', 1);
		add_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
	}



	/**
	 * Add container class to the main content element.
	 *
	 * @param string $class Main content element classes.
	 */
	public function change_sc_content_section_class($class)
	{
		// Bail if using the plugin's header and footer
		if (SimpleCheckout_Steps::instance()->get_hide_site_header_footer_at_checkout()) {
			return $class;
		}

		return $class . ' container';
	}



	/**
	 * Disable the sticky header option on the checkout page.
	 *
	 * @param mixed $current_mod  Theme modification value.
	 */
	public function change_theme_mod_header_sticky($current_mod)
	{
		// Bail if not on checkout page.
		if (!function_exists('is_checkout') || !is_checkout() || is_order_received_page()) {
			return $current_mod;
		}

		return 0; // Disabled
	}



	/**
	 * Output the theme logo on the plugin's checkout header.
	 */
	public function output_checkout_header_logo()
	{
		get_template_part('template-parts/header/partials/element', 'logo');
	}
}

SimpleCheckout_ThemeCompat_Flatsome::instance();
