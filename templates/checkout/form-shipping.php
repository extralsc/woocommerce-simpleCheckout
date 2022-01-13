<?php

/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @fc-version 1.3.1
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>


<div class="woocommerce-shipping-fields">

	<?php do_action('sc_checkout_before_step_shipping_fields'); ?>

	<?php if (true === WC()->cart->needs_shipping_address()) : ?>

		<?php // CHANGE: Output "ship to different address" option via hook 
		?>
		<?php do_action('sc_before_checkout_shipping_address_wrapper', $checkout); ?>

		<div class="shipping_address">

			<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields('shipping');

				foreach ($fields as $key => $field) {
					/**
					 * The variable `$display_fields` is passed as a paramenter to this template file
					 * @see Hook `sc_checkout_contact_step_field_ids`
					 */
					if (in_array($key, $display_fields)) {
						woocommerce_form_field($key, $field, $checkout->get_value($key));
					}
				}
				?>
			</div>

			<?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

		</div>

	<?php endif; ?>

	<?php
	// CHANGE: Added for compatibility with plugins that use this action hook
	do_action('woocommerce_checkout_shipping', $checkout);
	?>

	<?php do_action('sc_checkout_after_step_shipping_fields'); ?>

</div>