<?php

/**
 * Order review section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/sc/checkout/review-order-section.php.
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
 * @wc-version 3.5.0
 * @wc-original checkout/form-checkout.php
 */

defined('ABSPATH') || exit;

$attributes_str = implode(' ', array_map(array(SimpleCheckout::instance(), 'map_html_attributes'), array_keys($attributes), $attributes));
$attributes_inner_str = implode(' ', array_map(array(SimpleCheckout::instance(), 'map_html_attributes'), array_keys($attributes_inner), $attributes_inner));
?>

<?php do_action('sc_checkout_before_order_review', $is_sidebar_widget); ?>

<div <?php echo $attributes_str; // WPCS: XSS ok. 
		?>>

	<div <?php echo $attributes_inner_str; // WPCS: XSS ok. 
			?>>

		<?php do_action('sc_checkout_before_order_review_inside', $is_sidebar_widget); ?>

		<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

		<h3 class="sc-checkout-order-review-title sc-step__substep-title"><?php echo esc_html($order_review_title); ?></h3>

		<?php if ($is_sidebar_widget && apply_filters('sc_order_summary_display_desktop_edit_cart_link', true)) : ?>
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="sc-checkout-order-review__edit-cart"><?php echo esc_html(__('Edit Cart', 'simple-checkout')); ?></a>
		<?php endif; ?>

		<?php do_action('woocommerce_checkout_before_order_review'); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action('woocommerce_checkout_order_review'); ?>
		</div>

		<?php do_action('woocommerce_checkout_after_order_review'); ?>

		<?php if ($is_sidebar_widget) : ?>
			<?php do_action('sc_checkout_order_review_sidebar_before_actions', $is_sidebar_widget); ?>

			<div class="sc-checkout-order-review__actions-mobile">
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="sc-checkout-order-review__edit-cart"><?php echo esc_html(__('Edit Cart', 'simple-checkout')); ?></a>
				<button type="button" class="sc-checkout-order-review__close-order-summary <?php echo esc_attr(apply_filters('sc_order_summary_continue_button_classes', 'button')); ?>" data-flyout-close aria-label="<?php echo esc_html(__('Close and continue with checkout', 'simple-checkout')); ?>"><?php echo esc_html(__('Continue', 'simple-checkout')); ?></button>
			</div>
		<?php endif; ?>

		<?php do_action('sc_checkout_after_order_review_inside', $is_sidebar_widget); ?>

	</div>
</div>

<?php do_action('sc_checkout_after_order_review', $is_sidebar_widget); ?>