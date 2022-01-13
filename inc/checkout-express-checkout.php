<?php
defined('ABSPATH') || exit;

/**
 * Add customizations of the checkout page for Express Checkout section.
 */
class SimpleCheckout_ExpressCheckout extends SimpleCheckout
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
		// Express checkout
		add_action('sc_checkout_before_steps', array($this, 'maybe_output_express_checkout_section'), 10);
	}



	/**
	 * Output the express checkout section.
	 */
	public function maybe_output_express_checkout_section()
	{
		if ('yes' !== get_option('sc_enable_checkout_express_checkout', 'yes') || !has_action('sc_checkout_express_checkout')) {
			return;
		}

		$express_checkout_section_title = apply_filters('sc_checkout_express_checkout_section_title', __('Express checkout', 'simple-checkout'));
?>
		<section class="sc-express-checkout" aria-labelledby="sc-express-checkout__title">
			<div class="sc-express-checkout__inner">
				<h2 id="sc-express-checkout__title" class="sc-express-checkout__title"><?php echo esc_html($express_checkout_section_title); ?></h2>
				<?php do_action('sc_checkout_express_checkout'); ?>
			</div>

			<div class="sc-express-checkout__separator">
				<span class="sc-express-checkout__separator-text"><?php echo esc_html(apply_filters('sc_checkout_login_separator_text', _x('Or', 'Separator label for the express checkout section', 'simple-checkout'))); ?></span>
			</div>
		</section>
<?php
	}
}

SimpleCheckout_ExpressCheckout::instance();
