<?php

class Obs_Enqueue
{
	public static $_instance = null;

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Enqueue() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		self::script_all();
		self::style_all();

		if (is_admin()) {
			self::script_admin();
			self::style_admin();
		} else {
			self::script_front();
			self::style_front();
		}
	}

	public static function script_all()
	{
		wp_enqueue_script(OBS_PREFIX . 'script_mask', OBS_PLUGIN_ASSETS . 'packs/mask/jquery.mask.min.js', array('jquery'));
		wp_enqueue_script(OBS_PREFIX . 'script_select2', OBS_PLUGIN_ASSETS . 'packs/select2/select2.full.min.js', array('jquery'));
		wp_enqueue_script(OBS_PREFIX . 'script_bootstrap', OBS_PLUGIN_ASSETS . 'packs/bootstrap/bootstrap.min.js', array('jquery'));
		wp_enqueue_script(OBS_PREFIX . 'xlsx', OBS_PLUGIN_ASSETS . 'packs/xlsx/xlsx.full.min.js', array('jquery'));
		wp_enqueue_script(OBS_PREFIX . 'xlsx', OBS_PLUGIN_ASSETS . 'packs/xlsx/xlsx.zahl.js', array('jquery'));
	}

	public static function style_all()
	{
		wp_enqueue_style(OBS_PREFIX . 'style_select2', OBS_PLUGIN_ASSETS . 'packs/select2/select2.min.css', array());
		wp_enqueue_style(OBS_PREFIX . 'style_bootstrap', OBS_PLUGIN_ASSETS . 'packs/bootstrap/bootstrap.min.css', array());
	}

	public static function script_admin()
	{
		wp_enqueue_script(OBS_PREFIX . 'script_functions_admin', OBS_PLUGIN_ASSETS . 'js/functions-admin.js', array('jquery'));

		wp_enqueue_script(OBS_PREFIX . 'script_admin', OBS_PLUGIN_ASSETS . 'js/script-admin.js', array('jquery'));

		$localize = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'security' => wp_create_nonce('file_upload'),
			'obs_prefix' 	=> OBS_PREFIX,
		);

		wp_localize_script(OBS_PREFIX . 'script_functions_admin', 'obs_options_object', $localize);
	}

	public static function style_admin()
	{
		wp_enqueue_style(OBS_PREFIX . 'style_admin', OBS_PLUGIN_ASSETS . 'css/style-admin.css', array());
	}

	public static function script_front()
	{
		wp_enqueue_script(OBS_PREFIX . 'script_functions', OBS_PLUGIN_ASSETS . 'js/functions.js', array('jquery'));

		wp_enqueue_script(OBS_PREFIX . 'script', OBS_PLUGIN_ASSETS . 'js/script.js', array('jquery'));

		wp_enqueue_script(OBS_PREFIX . 'script_chartjs', OBS_PLUGIN_ASSETS . 'packs/chartjs/chart.min.js');

		wp_enqueue_script(OBS_PREFIX . 'script_html2canvas', OBS_PLUGIN_ASSETS . 'packs/html2canvas/html2canvas.min.js');

		$localize = array(
			'ajaxurl' 				=> admin_url('admin-ajax.php'),
			'obs_prefix' 			=> OBS_PREFIX,
			'site_url' 				=> get_site_url(),
			'security' 				=> wp_create_nonce('file_upload'),
			'nonce' 					=> wp_create_nonce('townhub-add-ons'),
			'wpml' 						=> apply_filters('wpml_current_language', null),
		);

		wp_localize_script(OBS_PREFIX . 'script_functions', 'obs_options_object', $localize);
	}

	public static function style_front()
	{
		wp_enqueue_style(OBS_PREFIX . 'style', OBS_PLUGIN_ASSETS . 'css/style.css', array());
	}
}
