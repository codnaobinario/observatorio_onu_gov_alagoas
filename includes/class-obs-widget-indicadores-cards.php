<?php

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Background;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Obs_Widget_Indicadores_Cards extends Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'obs-indicadores-cards';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Cards Indicadores', OBS_TEXT_DOMAIN);
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-posts-grid';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url()
	{
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['obs'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['post', 'link', 'obs', 'observatorio'];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{

		$this->start_controls_section(
			'section_query',
			[
				'label' => __('Configuraçoes Indicadores', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __('Cards por página', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::NUMBER,
				'default' => '6',
				'description' => esc_html__("Número de Indicadores exibidos por página (0 para todos).", OBS_TEXT_DOMAIN),
				'min'     => 0,
				'step'     => 1,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __('Ordenar por', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'date' => esc_html__('Data', OBS_TEXT_DOMAIN),
					'modified' => esc_html__('Data de Modificação', OBS_TEXT_DOMAIN),
					'title' => esc_html__('Título', OBS_TEXT_DOMAIN),
					'ID' => esc_html__('Indicador ID', OBS_TEXT_DOMAIN),
					'rand' => esc_html__('Aleatória', OBS_TEXT_DOMAIN),
				],
				'default' => 'date',
				'description' => esc_html__("Selecione como classificar as categorias recuperadas. Mais em ", OBS_TEXT_DOMAIN) . '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>.',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __('Ordem de Classificação', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__('Crescente', OBS_TEXT_DOMAIN),
					'DESC' => esc_html__('Decrescente', OBS_TEXT_DOMAIN),
				],
				'default' => 'DESC',
				'description' => esc_html__("Selecione ordem crescente ou decrescente. Mais em", OBS_TEXT_DOMAIN) . '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>.',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => __('Exibir Paginação', OBS_TEXT_DOMAIN),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on' => _x('Yes', 'On/Off', OBS_TEXT_DOMAIN),
				'label_off' => _x('No', 'On/Off', OBS_TEXT_DOMAIN),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Definições Card', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__('Background', OBS_TEXT_DOMAIN),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .indicador-card',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__('List Style', 'elementor-list-widget'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'elementor-list-widget'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-list-widget-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-list-widget-text > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text, {{WRAPPER}} .elementor-list-widget-text > a',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings();

		include(OBS_PLUGIN_TEMPLATE . 'card-indicador.php');
	}
}
