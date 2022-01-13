<?php
defined('ABSPATH') || exit;

/**
 * Compatibility with theme: Phlox (by averta).
 */
class SimpleCheckout_ThemeCompat_Phlox extends SimpleCheckout
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
		// Dequeue
		add_action('wp_enqueue_scripts', array($this, 'maybe_dequeue_scripts'), 100);
	}



	/**
	 * Dequeue theme scripts unnecessary on checkout page and that interfere with simple checkout scripts.
	 */
	public function maybe_dequeue_scripts()
	{
		// Bail if not on checkout page
		if (!function_exists('is_checkout') || !is_checkout() || is_order_received_page()) {
			return;
		}

		// Bail if use of theme header is enabled
		if (SimpleCheckout_Steps::instance()->get_hide_site_header_footer_at_checkout()) {
			return;
		}

		wp_dequeue_script('auxin-plugins');
		wp_dequeue_script('auxin-scripts');
	}
}

SimpleCheckout_ThemeCompat_Phlox::instance();
