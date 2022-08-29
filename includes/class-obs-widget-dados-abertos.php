<?php

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
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
class Obs_Widget_Dados_Abertos extends Widget_Base
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
		return 'obs-dados-abertos';
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
		return esc_html__('Botão Dados Abertos', OBS_TEXT_DOMAIN);
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
		return 'eicon-button';
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
			'section_btn',
			[
				'label' => __('Botão', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'width',
			[
				'label' => esc_html__('Width', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .btn-dados-abertos' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_btn',
			[
				'label' => __('Texto do botão', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,

				'label_block' => true,
				'default' => 'Dados Abertos',
				'description' => esc_html__('Texto exibido no botão', OBS_TEXT_DOMAIN)
			]
		);

		$this->add_control(
			'alignment',
			[
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label' => esc_html__('Alinhamento', OBS_TEXT_DOMAIN),
				'options' => [
					'start' => [
						'title' => esc_html__('Esquerda', OBS_TEXT_DOMAIN),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Centralizado', OBS_TEXT_DOMAIN),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__('Direita', OBS_TEXT_DOMAIN),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_icon',
			[
				'label' => __('Ícone', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label' => __('Ícone', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'position_icon',
			[
				'type' => Controls_Manager::CHOOSE,
				'label' => esc_html__('Posição', OBS_TEXT_DOMAIN),
				'options' => [
					'left' => [
						'title' => esc_html__('Esquerda', OBS_TEXT_DOMAIN),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__('Direita', OBS_TEXT_DOMAIN),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => __('Botão', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => esc_html__('Cor', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-dados-abertos' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_background',
				'label' => esc_html__('Background', OBS_TEXT_DOMAIN),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .btn-dados-abertos',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'selector' => '{{WRAPPER}} .btn-dados-abertos',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_shadow',
				'label' => esc_html__('Sombra do Botão', OBS_TEXT_DOMAIN),
				'selector' => '{{WRAPPER}} .btn-dados-abertos',
			]
		);

		$this->add_responsive_control(
			'btn_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__('Margin', OBS_TEXT_DOMAIN),
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .btn-dados-abertos' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__('Padding', OBS_TEXT_DOMAIN),
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .btn-dados-abertos' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style_hover',
			[
				'label' => __('Botão Hover', OBS_TEXT_DOMAIN),
				'tab'		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_color_hover',
			[
				'label' => esc_html__('Cor', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-dados-abertos:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_background_hover',
				'label' => esc_html__('Background', OBS_TEXT_DOMAIN),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .btn-dados-abertos:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_shadow_hover',
				'label' => esc_html__('Sombra do Botão', OBS_TEXT_DOMAIN),
				'selector' => '{{WRAPPER}} .btn-dados-abertos:hover',
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
		$settings = $this->get_settings_for_display();
?>
		
<?php
		include(OBS_PLUGIN_TEMPLATE . 'button-dados-abertos.php');
	}
}
