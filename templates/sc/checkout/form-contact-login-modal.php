<?php

/**
 * Checkout contact login substep
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/sc/checkout/form-contact-login-modal.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package simple-checkout
 * @version 1.2.0
 */

defined('ABSPATH') || exit;
?>

<div class="sc-login-form" data-flyout data-flyout-modal data-flyout-checkout-login>
	<div class="sc-login-form__inner" data-flyout-content>

		<div class="sc-login-form__close-wrapper">
			<a href="#close" class="button--flyout-close" title="<?php esc_attr_e('Close login form', 'fluidtheme') ?>" data-flyout-close aria-label="<?php echo esc_html(_x('Close', 'Close button aria-label', 'simple-checkout')); ?>"></a>
		</div>

		<div class="sc-login-form__title"><?php echo esc_html(__('Sign in to your account', 'simple-checkout')); ?></div>

		<?php woocommerce_login_form(); ?>

	</div>
</div>