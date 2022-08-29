<?php

class Obs_Post_Type
{
	public static $_instance = null;

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Post_Type() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		$this->create_post_type();
		if (!function_exists('create_custom_meta_box')) {
			add_action('add_meta_boxes', array($this, 'create_custom_meta_box'));
		}
	}

	public function create_post_type()
	{
		register_post_type(
			'indicadores',
			array(
				'labels' => array(
					'name'          => __('Indicadores', OBS_TEXT_DOMAIN),
					'singular_name' => __('Indicadores', OBS_TEXT_DOMAIN)
				),
				'public'        => true,
				'show_in_rest'  => true,
				'has_archive'   => true,
				'menu_position' => 2,
				'taxonomies'    => array(),
				'rewrite'       => array('slug' => 'indicador', 'with_front' => false),
				'supports'      => array(
					'title',
					'author',
					// 'categories',
					// 'thumbnail',
				)
			)
		);
	}
}
