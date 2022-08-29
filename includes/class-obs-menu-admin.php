<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Obs_Menu_Admin
{
	public static $_instance = null;

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Menu_Admin() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		add_action('admin_menu', array($this, 'add_menu'));
	}

	public function add_menu()
	{
		$icon = 'dashicons-admin-site';

		add_menu_page(
			__('Observatório', OBS_TEXT_DOMAIN),
			__('Observatório', OBS_TEXT_DOMAIN),
			'',
			'obs',
			array($this, 'menu_page'),
			$icon,
			2
		);

		add_submenu_page(
			'obs',
			__('Importar Dados (Indicadores)', OBS_TEXT_DOMAIN),
			__('Importar Dados (Indicadores)', OBS_TEXT_DOMAIN),
			'manage_options',
			'obs-import-dados',
			array($this, 'obs_submenu_import_data'),
		);

		add_submenu_page(
			'obs',
			__('Importar Dados (Matriz)', OBS_TEXT_DOMAIN),
			__('Importar Dados (Matriz)', OBS_TEXT_DOMAIN),
			'manage_options',
			'obs-import-dados-admin',
			array($this, 'obs_submenu_import_data_admin'),
		);

		// if (get_current_user_id() === 1) {
		// 	add_submenu_page(
		// 		'obs',
		// 		__('Importar Dados (Completos)', OBS_TEXT_DOMAIN),
		// 		__('Importar Dados (Completos)', OBS_TEXT_DOMAIN),
		// 		'manage_options',
		// 		'obs-import-dados-all',
		// 		array($this, 'obs_submenu_import_data_all'),
		// 	);
		// }
	}

	public function menu_page()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', OBS_TEXT_DOMAIN));
		}
	}

	public function obs_submenu_import_data()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', OBS_TEXT_DOMAIN));
		}

		obs_get_template_admin('submenu-import-data');
	}

	public function obs_submenu_import_data_admin()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', OBS_TEXT_DOMAIN));
		}

		obs_get_template_admin('submenu-import-data-admin');
	}

	public function obs_submenu_import_data_all()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', OBS_TEXT_DOMAIN));
		}

		obs_get_template_admin('submenu-import-data-all');
	}
}
