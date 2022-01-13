<?php
defined('ABSPATH') || exit;

/**
 * Feature for adding coupon codes or gift certificate codes to checkout
 */
class SimpleCheckout_CouponCodes extends SimpleCheckout
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
		// Bail if use of coupons not enabled
		if (!wc_coupons_enabled()) {
			return;
		}

		// Body Class
		add_filter('body_class', array($this, 'add_body_class'));

		// Checkout Coupon Notice
		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

		// Coupon Code Substep
		add_action('sc_output_step_payment', array($this, 'output_substep_coupon_codes'), 10);
		add_filter('woocommerce_update_order_review_fragments', array($this, 'add_coupon_codes_text_fragment'), 10);

		// Prevent hiding coupon code field behind a link button, as it is implemented directly
		add_filter('sc_hide_optional_fields_skip_list', array($this, 'prevent_hide_optional_fields_coupon_code'), 10);
	}



	/**
	 * Return Checkout Steps class instance.
	 */
	public function checkout_steps()
	{
		return SimpleCheckout_Steps::instance();
	}



	/**
	 * Add page body class for feature detection.
	 *
	 * @param   array  $classes  Body classes array.
	 */
	public function add_body_class($classes)
	{
		// Bail if not on checkout page.
		if (!function_exists('is_checkout') || !is_checkout()) {
			return $classes;
		}

		return array_merge($classes, array('has-sc-coupon-code-fields'));
	}



	/**
	 * Output coupon codes substep.
	 *
	 * @param   string  $step_id     Id of the step in which the substep will be rendered.
	 */
	public function output_substep_coupon_codes($step_id)
	{
		$substep_id = 'coupon_codes';
		$substep_title = get_option('sc_display_coupon_code_section_title', 'no') === 'yes' ? apply_filters('sc_substep_coupon_codes_section_title', __('Coupon code', 'simple-checkout')) : null;
		$this->checkout_steps()->output_substep_start_tag($step_id, $substep_id, $substep_title);

		$this->output_substep_text_coupon_codes();

		$this->checkout_steps()->output_substep_fields_start_tag($step_id, $substep_id, false);
		$this->output_substep_coupon_codes_fields();
		$this->checkout_steps()->output_substep_fields_end_tag();

		$this->checkout_steps()->output_substep_end_tag($step_id, $substep_id, $substep_title, false);
	}



	/**
	 * Output coupon codes fields.
	 */
	public function output_substep_coupon_codes_fields()
	{
		$coupon_code_field_label = apply_filters('sc_coupon_code_field_label', __('Coupon code', 'simple-checkout'));
		$coupon_code_field_placeholder = apply_filters('sc_coupon_code_field_placeholder', __('Enter your code here', 'simple-checkout'));
		$coupon_code_button_label = apply_filters('sc_coupon_code_button_label', _x('Apply', 'Button label for applying coupon codes', 'simple-checkout'));

		$key = 'coupon_code';
		$coupon_code_field_args = array(
			'required'                   => false,
			'sc_skip_server_validation' => true,
			'class'                      => array('form-row-wide'),
			'placeholder'                => $coupon_code_field_placeholder,
			'custom_attributes'          => array(
				'aria-label'             => $coupon_code_field_label,
				'data-autofocus'         => true,
			),
		);

		// Expansible section args
		$coupon_code_expansible_args = array();
		if (apply_filters('sc_coupon_code_field_initially_expanded', false) == true) {
			$coupon_code_expansible_args['initial_state'] = 'expanded';
		}

		// Output coupon code field and button in an expansible form section
		$coupon_code_toggle_label = get_option('sc_optional_fields_link_label_lowercase', 'yes') === 'yes' ? strtolower($coupon_code_field_label) : $coupon_code_field_label;
		$coupon_code_toggle_label = apply_filters('sc_expansible_section_toggle_label_' . $key, sprintf(__('Add %s', 'simple-checkout'), $coupon_code_toggle_label));
		/* translators: %s: Form field label */
		$this->checkout_steps()->output_expansible_form_section_start_tag($key, $coupon_code_toggle_label, $coupon_code_expansible_args);
		woocommerce_form_field($key, $coupon_code_field_args);
?>
		<button type="button" class="sc-coupon-code__apply <?php echo esc_attr(apply_filters('sc_coupon_code_apply_button_classes', 'button')); ?>" data-apply-coupon-button><?php echo esc_html($coupon_code_button_label); ?></button>
		<?php
		$this->checkout_steps()->output_expansible_form_section_end_tag();
	}



	/**
	 * Prevent hiding optional coupon code field behind a link button, as it is implemented directly.
	 *
	 * @param   array  $skip_list  List of optional fields to skip hidding.
	 */
	public function prevent_hide_optional_fields_coupon_code($skip_list)
	{
		$skip_list[] = 'coupon_code';
		return $skip_list;
	}



	/**
	 * Get coupon codes substep added coupon codes.
	 */
	public function get_substep_text_coupon_codes()
	{
		$html = '<div class="sc-step__substep-text-content sc-step__substep-text-content--coupon-codes">';
		ob_start();

		do_action('sc_substep_coupon_codes_text_before');

		foreach (WC()->cart->get_coupons() as $code => $coupon) :
			// Get coupon label with changed "remove" link
			ob_start();
			wc_cart_totals_coupon_html($coupon);
			$coupon_html_esc = str_replace(esc_html(__('[Remove]', 'woocommerce')), esc_html(__('Remove', 'simple-checkout')), ob_get_clean());
		?>
			<?php // The function `sanitize_title` is used below to convert the string into a CSS-class-like string 
			?>
			<div class="sc-coupon-codes__coupon coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
				<strong class="sc-coupon-codes__coupon-code"><?php wc_cart_totals_coupon_label($coupon); ?></strong>
				<span class="sc-coupon-codes__coupon-amount"><?php echo $coupon_html_esc; // WPCS: XSS ok. 
																?></span>
			</div>
<?php
		endforeach;

		do_action('sc_substep_coupon_codes_text_after');

		$html .= ob_get_clean();
		$html .= '</div>';

		return apply_filters('sc_substep_coupon_codes_text', $html);
	}

	/**
	 * Add coupon codes text format as checkout fragment.
	 *
	 * @param array $fragments Checkout fragments.
	 */
	public function add_coupon_codes_text_fragment($fragments)
	{
		$html = $this->get_substep_text_coupon_codes();
		$fragments['.sc-step__substep-text-content--coupon-codes'] = $html;
		return $fragments;
	}

	/**
	 * Output coupon codes substep in text format for when the step is completed.
	 */
	public function output_substep_text_coupon_codes()
	{
		echo $this->get_substep_text_coupon_codes();
	}
}

SimpleCheckout_CouponCodes::instance();
