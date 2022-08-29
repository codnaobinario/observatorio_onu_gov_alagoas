<?php

class Obs_Indicador_Custom_Meta_Box
{
	public static $_instance = null;
	private $post_type = 'indicadores';

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Indicador_Custom_Meta_Box() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		if (!function_exists('create_custom_meta_box')) {
			add_action('add_meta_boxes', array($this, 'create_custom_meta_box'));
		}

		if (!function_exists('custom_save_post')) {
			add_action('save_post', array($this, 'custom_save_post'));
		}
	}

	public function get_municipios()
	{
		$municipios = get_terms(array(
			'taxonomy' => 'municipios',
			'hide_empty' => false,
		));

		return $municipios;
	}

	public function get_regioes()
	{
		$regioes = get_terms(array(
			'taxonomy' => 'regiao',
			'hide_empty' => false,
		));

		return $regioes;
	}

	public function create_custom_meta_box()
	{

		add_meta_box(
			'description',
			__('Descrição do Indicador', OBS_TEXT_DOMAIN),
			array($this, 'add_custom_content_meta_box_description'),
			$this->post_type,
			'normal',
			'default',
		);

		add_meta_box(
			'concepts-definitions',
			__('Conceitos e Definições', OBS_TEXT_DOMAIN),
			array($this, 'add_custom_content_meta_box_concepts_definitions'),
			$this->post_type,
			'normal',
			'default',
		);

		add_meta_box(
			'ods',
			__('ODS - Objetivo de Desenvolvimento Sustentável', OBS_TEXT_DOMAIN),
			array($this, 'add_custom_content_meta_box_ods'),
			$this->post_type,
			'normal',
			'default',
		);

		add_meta_box(
			'metodo-calculo',
			__('Metodo de Cálculo', OBS_TEXT_DOMAIN),
			array($this, 'add_custom_content_meta_box_metodo_calculo'),
			$this->post_type,
			'normal',
			'default',
		);

		$municipios = $this->get_municipios();
		$regioes = $this->get_regioes();

		foreach ($municipios as $municipio) {
			add_meta_box(
				$municipio->slug,
				__($municipio->name . ' (' . $municipio->slug . ')', OBS_TEXT_DOMAIN),
				array($this, 'add_custom_content_meta_box_dados'),
				$this->post_type,
				'normal',
				'default',
				array('municipio' => $municipio),
			);
		}

		foreach ($regioes as $regiao) {
			add_meta_box(
				$regiao->slug,
				__($regiao->name . ' (' . $regiao->slug . ')', OBS_TEXT_DOMAIN),
				array($this, 'add_custom_content_meta_box_dados'),
				$this->post_type,
				'normal',
				'default',
				array('regiao' => $regiao),
			);
		}
	}

	public function add_custom_content_meta_box_description($post)
	{
		include OBS_PLUGIN_TEMPLATE . 'admin/indicadores-meta-box-description.php';
	}

	public function add_custom_content_meta_box_concepts_definitions($post)
	{
		include OBS_PLUGIN_TEMPLATE . 'admin/indicadores-meta-box-concepts-definitions.php';
	}

	public function add_custom_content_meta_box_ods($post)
	{
		include OBS_PLUGIN_TEMPLATE . 'admin/indicadores-meta-box-ods.php';
	}

	public function add_custom_content_meta_box_metodo_calculo($post)
	{
		include OBS_PLUGIN_TEMPLATE . 'admin/indicadores-meta-box-metodo-calculo.php';
	}

	public function add_custom_content_meta_box_dados($post, $metabox)
	{
		include OBS_PLUGIN_TEMPLATE . 'admin/indicadores-meta-box-dados.php';
	}

	public function custom_save_post($post_id)
	{

		/**
		 * Descrição do Indicador
		 */
		if (isset($_POST['description'])) {
			update_post_meta($post_id, OBS_PREFIX . 'description', $_POST['description']);
		}

		/**
		 * Método Calculo
		 */
		if (isset($_POST['metodo_calculo'])) {
			update_post_meta($post_id, OBS_PREFIX . 'metodo_calculo', $_POST['metodo_calculo']);
		}

		/**
		 * ODS
		 */
		if (isset($_POST['ods'])) {
			update_post_meta($post_id, OBS_PREFIX . 'ods', $_POST['ods']);
		}

		if (isset($_POST['ods_meta'])) {
			update_post_meta($post_id, OBS_PREFIX . 'ods_meta', $_POST['ods_meta']);
		}

		if (isset($_POST['ods_meta_vinculada'])) {
			update_post_meta($post_id, OBS_PREFIX . 'ods_meta_vinculada', $_POST['ods_meta_vinculada']);
		}

		if (isset($_POST['ods_meta_vinculada'])) {
			update_post_meta($post_id, OBS_PREFIX . 'ods_meta_vinculada', $_POST['ods_meta_vinculada']);
		}

		/**
		 * Dados (Municipios e Rigiões)
		 */
		if (isset($_POST['municipio']) || isset($_POST['municipio_slug'])) {
			update_post_meta($post_id, OBS_PREFIX . 'dados', $_POST['municipio']);
			update_post_meta($post_id, OBS_PREFIX . 'municipios', $_POST['municipio_slug']);

			if ($_POST['municipio']) {
				foreach ($_POST['municipio'] as $slug => $anos) {
					$anos_municipio = array();
					ksort($anos);
					update_post_meta($post_id, OBS_PREFIX . $slug, $anos);

					foreach ($anos as $v) {
						array_push($anos_municipio, $v['ano']);
						// update_post_meta($post_id, OBS_PREFIX . $slug . '_' .  $v['ano'], $v['value']);
					}

					sort($anos_municipio);
					update_post_meta($post_id, OBS_PREFIX . $slug . '_anos', $anos_municipio);
				}
			}
		}
	}
}
