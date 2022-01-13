<?php
defined('ABSPATH') || exit;

/**
 * Compatibility with theme: Woodmart (by XTemos).
 */
class SimpleCheckout_ThemeCompat_Woodmart extends SimpleCheckout
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
		add_filter('sc_override_template_with_theme_file', array($this, 'override_template_with_theme_file'), 10, 4);
	}



	/**
	 * Override plugin template files with the theme version.
	 */
	public function override_template_with_theme_file($override, $template, $template_name, $template_path)
	{

		if ('global/form-login.php' === $template_name) {
			$override = true;
		}

		return $override;
	}
}

SimpleCheckout_ThemeCompat_Woodmart::instance();
