<?php

class Obs_Init
{
	public static $_instance = null;

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Init() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		self::define_params();
	}

	public static function define_params()
	{
		define('OBS_TEXT_DOMAIN', 'obs');
		define('OBS_PLUGIN_PATH', plugin_dir_path(__DIR__));
		define('OBS_PLUGIN_TEMPLATE', plugin_dir_path(__DIR__) . 'templates/');
		define('OBS_PLUGIN_ASSETS', plugin_dir_url(__DIR__) . 'assets/');
		define('OBS_IMAGE', plugin_dir_url(__DIR__) . 'assets/images/');
		define('OBS_PREFIX', 'obs_');
	}
}
