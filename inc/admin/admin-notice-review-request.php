<?php
defined('ABSPATH') || exit;

/**
 * Admin review request notice.
 */
class SimpleCheckout_AdminNotices_ReviewRequest extends SimpleCheckout
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
		add_action('sc_admin_notices', array($this, 'add_review_request_timed_notice'), 10);
	}



	/**
	 * Add plugin review request notice.
	 * @param  array  $notices  Admin notices from the plugin.
	 */
	public static function add_review_request_timed_notice($notices = array())
	{
		// Get install date
		$install_date = get_option('sc_plugin_activation_time');
		$past_date = strtotime('-7 days');

		// Bail if 7 days have not passed since installation
		if ($past_date < $install_date) {
			return;
		}

		$notices[] = array(
			'name' => 'review_request_timed',
			'title' => __('Thanks for choosing simple checkout, you rock!', 'simple-checkout'),
			'description' => __('You have been using simple checkout for a while. How do you like it so far? <br>Please give us a quick rating, it works as a boost for us to keep working on the plugin :)', 'simple-checkout'),
			'actions' => array(
				sprintf('<a href="%s" class="button button-primary" target="_blank">%s</a>', esc_url('https://wordpress.org/support/plugin/simple-checkout/reviews/'), __('Rate Us Now', 'simple-checkout')),
				sprintf('<a href="%s" class="button button-secondary" target="_blank">%s</a>', esc_url('https://wordpress.org/support/plugin/simple-checkout/'), __('I Need Help!', 'simple-checkout')),
			),
		);

		return $notices;
	}
}

SimpleCheckout_AdminNotices_ReviewRequest::instance();
