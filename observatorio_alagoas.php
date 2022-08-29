<?php

/**
 * Plugin Name: Observatório Alagoas
 * Plugin URI: https://github.com/igorsacramento/observatorio_alagoas
 * Description: Observatório Alagoas
 * Author: Núcleo Digital / Igor Sacramento
 * Author URI: http://nucleodigital.cc
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * License: GPLv2 or later
 * Version: 1.0.0
 * Text Domain: obs-alagoas
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Obs
{
	public static $_instance = null;

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		self::init();
		add_action('elementor/widgets/register', array($this, 'register_widgets_elementor'));
		// add_action('wp_ajax_' . OBS_PREFIX . 'import_municipios_regioes', array($this, 'import_municipios_regioes'));
		// add_action('wp_ajax_nopriv_' . OBS_PREFIX . 'import_municipios_regioes', array($this, 'import_municipios_regioes'));
	}

	public function import_municipios_regioes()
	{
		wp_send_json(
			array(
				'status' => 'success',
			)
		);

		exit;
	}

	public static function init()
	{
		self::includes();
		self::instace_class();
		self::include_ajax();
		self::include_widgets();
	}

	public static function includes()
	{
		include_once('includes/class-obs-init.php');
		include_once('includes/class-obs-enqueue.php');
		include_once('includes/class-obs-post-type.php');
		include_once('includes/class-obs-terms.php');
		include_once('includes/class-obs-indicador-custom-meta-box.php');
		include_once('includes/class-obs-menu-admin.php');
		include_once('includes/class-obs-import-xlsx.php');

		include_once('includes/functions.php');
	}

	public static function instace_class()
	{
		class_exists('Obs_Init') && Obs_Init::get_instance();
		class_exists('Obs_Enqueue') && Obs_Enqueue::get_instance();
		class_exists('Obs_Post_Type') && Obs_Post_Type::get_instance();
		class_exists('Obs_Terms') && Obs_Terms::get_instance();
		class_exists('Obs_Indicador_Custom_Meta_Box') && Obs_Indicador_Custom_Meta_Box::get_instance();
		class_exists('Obs_Menu_Admin') && Obs_Menu_Admin::get_instance();
		class_exists('Obs_Import_Xlsx') && Obs_Import_Xlsx::get_instance();
	}

	public static function include_ajax()
	{
	}

	public static function include_widgets()
	{
		require_once('includes/class-obs-widget-indicadores-cards.php');
		require_once('includes/class-obs-widget-filters-cards.php');
		require_once('includes/class-obs-widget-dados-abertos.php');
	}

	public function register_widgets_elementor($widgets_manager)
	{
		$widgets_manager->register(new \Obs_Widget_Indicadores_Cards());
		$widgets_manager->register(new \Obs_Widget_Filters_Cards());
		$widgets_manager->register(new \Obs_Widget_Dados_Abertos());
	}
}

function obs_init()
{
	Obs::get_instance();
}

add_action('init', 'obs_init');

add_action('elementor/init', function () {

	\Elementor\Plugin::$instance->elements_manager->add_category(
		'obs',
		[
			'title' => __('Observatório Elements', OBS_TEXT_DOMAIN),
			'icon' => 'fa fa-gmap', //default icon
		],
		1 // position
	);
});
