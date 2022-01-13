<?php
defined('ABSPATH') || exit;

/**
 * Widget Areas on the checkout page.
 */
class SimpleCheckout_CheckoutWidgetAreas extends SimpleCheckout
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
		// Widget Areas
		add_action('widgets_init', array($this, 'register_checkout_widgets_areas'), 50);
		add_action('sc_checkout_header_widgets', array($this, 'output_widget_area_checkout_header'), 50);
		add_action('woocommerce_before_checkout_form_cart_notices', array($this, 'output_widget_area_checkout_header_below'), 3); // Displays widgets before the progress bar
		add_action('sc_checkout_after_order_review_inside', array($this, 'output_widget_area_order_review_inside'), 50);
		add_action('sc_checkout_after_order_review', array($this, 'output_widget_area_order_review_outside'), 50);
		add_action('woocommerce_review_order_after_submit', array($this, 'output_widget_area_checkout_place_order_below'), 50);
	}





	/**
	 * Register widget areas for the checkout page.
	 */
	public function register_checkout_widgets_areas()
	{

		register_sidebar(array(
			'name'          => __('Checkout Header - Desktop', 'simple-checkout'),
			'id'            => 'sc_checkout_header',
			'description'   => __('Display widgets on the checkout header for large screens. Only displayed if using the plugin\'s checkout header.', 'simple-checkout'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));

		register_sidebar(array(
			'name'          => __('Checkout Header - Mobile', 'simple-checkout'),
			'id'            => 'sc_checkout_below_header',
			'description'   => __('Display widgets below the checkout header for mobile devices. Only displayed if using the plugin\'s checkout header.', 'simple-checkout'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));



		register_sidebar(array(
			'name'          => __('Checkout Sidebar', 'simple-checkout'),
			'id'            => 'sc_checkout_sidebar_after',
			'description'   => __('Display widgets on the checkout sidebar after the order summary.', 'simple-checkout'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));



		register_sidebar(array(
			'name'          => __('Checkout Order Summary', 'simple-checkout'),
			'id'            => 'sc_order_summary_after',
			'description'   => __('Display widgets inside the order summary at the checkout page.', 'simple-checkout'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		));

		register_sidebar(array(
			'name'          => __('Checkout Below Place Order', 'simple-checkout'),
			'id'            => 'sc_place_order_after',
			'description'   => __('Display widgets below the place order button at the checkout page.', 'simple-checkout'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		));
	}





	/**
	 * Output widget area on the checkout header.
	 */
	public function output_widget_area_checkout_header()
	{
		if (is_active_sidebar('sc_checkout_header') || has_action('sc_checkout_header_widgets_inside_before') || has_action('sc_checkout_header_widgets_inside_after')) :
			echo '<div class="sc-checkout__header-widgets">';
			do_action('sc_checkout_header_widgets_inside_before');
			dynamic_sidebar('sc_checkout_header');
			do_action('sc_checkout_header_widgets_inside_after');
			echo '</div>';
		endif;
	}

	/**
	 * Output widget area below the checkout progress bar.
	 */
	public function output_widget_area_checkout_header_below()
	{
		if (is_active_sidebar('sc_checkout_below_header')) :
			echo '<div class="sc-checkout__below-header-widgets">';
			dynamic_sidebar('sc_checkout_below_header');
			echo '</div>';
		endif;
	}



	/**
	 * Output widget area outside order review section.
	 *
	 * @param   bool  $is_sidebar_widget  Whether or not outputting the sidebar.
	 */
	public function output_widget_area_order_review_outside($is_sidebar_widget)
	{
		// Bail if not outputting widget areas for the sidebar
		if (!$is_sidebar_widget) {
			return;
		}

		if (is_active_sidebar('sc_checkout_sidebar_after')) :
			echo '<div class="sc-checkout-order-review__widgets-outside">';
			dynamic_sidebar('sc_checkout_sidebar_after');
			echo '</div>';
		endif;
	}



	/**
	 * Output widget area inside order review section.
	 *
	 * @param   bool  $is_sidebar_widget  Whether or not outputting the sidebar.
	 */
	public function output_widget_area_order_review_inside($is_sidebar_widget)
	{
		// Bail if not outputting widget areas for the sidebar
		if (!$is_sidebar_widget) {
			return;
		}

		if (is_active_sidebar('sc_order_summary_after')) :
			echo '<div class="sc-checkout-order-review__widgets-inside">';
			dynamic_sidebar('sc_order_summary_after');
			echo '</div>';
		endif;
	}



	/**
	 * Output widget area below the checkout place order button.
	 */
	public function output_widget_area_checkout_place_order_below()
	{
		if (is_active_sidebar('sc_place_order_after')) :
			echo '<div class="sc-checkout__below-place-order-widgets">';
			dynamic_sidebar('sc_place_order_after');
			echo '</div>';
		endif;
	}
}

SimpleCheckout_CheckoutWidgetAreas::instance();
