<?php

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

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
class Obs_Widget_Filters_Cards extends Widget_Base
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
		return 'obs-filters-cards';
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
		return esc_html__('Filtros Cards', OBS_TEXT_DOMAIN);
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
				'label' => __('Consulta de Editais', OBS_TEXT_DOMAIN),
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
					'name' => esc_html__('Slug', OBS_TEXT_DOMAIN),
					'term_group' => esc_html__('Post Group', OBS_TEXT_DOMAIN),
					'ID' => esc_html__('Post ID', OBS_TEXT_DOMAIN),
					'description' => esc_html__('Descrição', OBS_TEXT_DOMAIN),
					'parent' => esc_html__('Parent', OBS_TEXT_DOMAIN),
					'rand' => esc_html__('Aleatória', OBS_TEXT_DOMAIN),
					'count' => esc_html__('Contagem de projetos', OBS_TEXT_DOMAIN),
					'include' => esc_html__('Para incluir acima', OBS_TEXT_DOMAIN),
				],
				'default' => 'date',
				'separator' => 'before',
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
				'separator' => 'before',
				'description' => esc_html__("Selecione ordem crescente ou decrescente. Mais em", OBS_TEXT_DOMAIN) . '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>.',
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label' => __('Ocultar vazio', OBS_TEXT_DOMAIN),
				'description' => esc_html__('Se os Editais não tirem nenhum Projeto atribuído devem ser ocultados', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SWITCHER,
				'default' => '1',
				'label_on' => __('Yes', OBS_TEXT_DOMAIN),
				'label_off' => __('No', OBS_TEXT_DOMAIN),
				'return_value' => '1',
			]
		);


		$this->add_control(
			'number',
			[
				'label' => __('Número de Editais a serem exibidos', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::NUMBER,
				'default' => '6',
				'description' => esc_html__("Número de locais a serem exibidos (0 para todos).", OBS_TEXT_DOMAIN),
				'min'     => 0,
				'step'     => 1,

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Layout de Editais', OBS_TEXT_DOMAIN),
			]
		);

		$this->add_control(
			'columns_grid',
			[
				'label' => __('Grid de Colunas', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'one' => esc_html__('Uma Coluna', OBS_TEXT_DOMAIN),
					'two' => esc_html__('Duas Colunas', OBS_TEXT_DOMAIN),
					'three' => esc_html__('Três Colunas', OBS_TEXT_DOMAIN),
					'four' => esc_html__('Quatro Colunas', OBS_TEXT_DOMAIN),
					'five' => esc_html__('Cinco Colunas', OBS_TEXT_DOMAIN),
					'six' => esc_html__('Seis Colunas', OBS_TEXT_DOMAIN),
					'seven' => esc_html__('Sete Colunas', OBS_TEXT_DOMAIN),
					'eight' => esc_html__('Oito Colunas', OBS_TEXT_DOMAIN),
					'nine' => esc_html__('Nove Colunas', OBS_TEXT_DOMAIN),
					'ten' => esc_html__('Dez Colunas', OBS_TEXT_DOMAIN),
				],
				'default' => 'three',
			]
		);

		$this->add_control(
			'items_width',
			[
				'label' => __('Largura dos itens de Editais', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,

				'label_block' => true,
				'default' => 'x1,x1,x1,x1,x2,x1,x1,x1,2x,1x',
				'description' => esc_html__('Largura do local definido. Os valores disponíveis são x1(padrão),x2(x2 largura),x3(x3 largura), e separados por vírgula. Ex: x1,x1,x2,x1,x1,x1', OBS_TEXT_DOMAIN)
			]
		);

		$this->add_control(
			'space',
			[
				'label' => __('Espaço', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'big' => esc_html__('Grande', OBS_TEXT_DOMAIN),
					'medium' => esc_html__('Médio', OBS_TEXT_DOMAIN),
					'small' => esc_html__('Pequeno', OBS_TEXT_DOMAIN),
					'extrasmall' => esc_html__('Muito Pequeno', OBS_TEXT_DOMAIN),
					'no' => esc_html__('Nenhum', OBS_TEXT_DOMAIN),

				],
				'default' => 'big',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => __('Ver todo o texto', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,

				'label_block' => true,
				'default' => 'Ver Todos os Editais',
				'description' => ''
			]
		);


		$this->add_control(
			'count_child',
			[
				'label' => __('Contar listagens de Projetos filhos', OBS_TEXT_DOMAIN),
				'description' => '',
				'type' => Controls_Manager::SWITCHER,
				'default' => '0',
				'label_on' => _x('Yes', 'On/Off', OBS_TEXT_DOMAIN),
				'label_off' => _x('No', 'On/Off', OBS_TEXT_DOMAIN),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'show_icon_link',
			[
				'label'        => __('Exibir Links de divulgação', OBS_TEXT_DOMAIN),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on' => _x('Yes', 'On/Off', OBS_TEXT_DOMAIN),
				'label_off' => _x('No', 'On/Off', OBS_TEXT_DOMAIN),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => __('Exibir Paginação', OBS_TEXT_DOMAIN),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on' => _x('Yes', 'On/Off', OBS_TEXT_DOMAIN),
				'label_off' => _x('No', 'On/Off', OBS_TEXT_DOMAIN),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'view_all_preview_button',
			[
				'label'        => __('Exibir Botão ver todos', OBS_TEXT_DOMAIN),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on' => _x('Yes', 'On/Off', OBS_TEXT_DOMAIN),
				'label_off' => _x('No', 'On/Off', OBS_TEXT_DOMAIN),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => __('Texto Botão ver todos', OBS_TEXT_DOMAIN),
				'type' => Controls_Manager::TEXT,

				'label_block' => true,
				'default' => 'Ver Todos os Projetos',
				'description' => ''
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

		include(OBS_PLUGIN_TEMPLATE . 'filters-indicadores.php');
	}
}
