<?php
class Obs_Terms
{
	public static $_instance = null;
	private $post_type = 'indicadores';

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Terms() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		$this->create_terms();
	}

	public function create_terms()
	{
		$this->terms_municipios();
		$this->terms_regiao();
		// $this->terms_ods();
		$this->terms_coleta_cebrap();
		$this->terms_denominador();
		$this->terms_fonte_denomminador();
		$this->terms_fonte_numerador();
		$this->terms_fonte();
		// $this->terms_metodo_calculo();
		$this->terms_numerador();
		$this->terms_referencia();
		$this->terms_respossavel_coleta();
		$this->terms_tipo_base();
		$this->terms_unidade_medida();
	}

	public function terms_municipios()
	{
		$labels = array(
			'name'              => _x('Municípios', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Município', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Municípios', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Municípios', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Município', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Município', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Município', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Município', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Municípios', OBS_TEXT_DOMAIN),
			'slug_field_description'	=> __('O \'slug\' deverá ser preenchido com o código do municipio', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'meta_box_cb'					=> false,
			'rewrite'           	=> array('slug' => 'municipios'),
		);

		register_taxonomy('municipios', array($this->post_type), $args);
	}

	public function terms_regiao()
	{
		$labels = array(
			'name'              => _x('Regiões', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Região', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Regiãos', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos as Regiões', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Região', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Região', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Região', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Região', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Regiões', OBS_TEXT_DOMAIN),
			'slug_field_description'	=> __('O \'slug\' deverá ser preenchido com o código da região', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'meta_box_cb'					=> false,
			'rewrite'           	=> array('slug' => 'regiao'),
		);

		register_taxonomy('regiao', array($this->post_type), $args);
	}

	public function terms_referencia()
	{
		$labels = array(
			'name'              => _x('Referências', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Referência', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Referências', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Referências', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Referência', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Referência', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Referência', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Referência', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Referências', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'referencia'),
		);

		register_taxonomy('referencia', array($this->post_type), $args);
	}

	public function terms_respossavel_coleta()
	{
		$labels = array(
			'name'              => _x('Responsáveis Coleta', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Responsável Coleta', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Responsáveis Coleta', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Responsáveis Coleta', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Responsável Coleta', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Responsável Coleta', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Responsável Coleta', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Responsável Coleta', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Responsável Coleta', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'responsavel-coleta'),
		);

		register_taxonomy('responsavel-coleta', array($this->post_type), $args);
	}

	public function terms_coleta_cebrap()
	{
		$labels = array(
			'name'              => _x('Coletas CEBRAP', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Coleta CEBRAP', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Coletas CEBRAP', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todas as Coletas CEBRAP', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Coleta CEBRAP', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Coleta CEBRAP', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Coleta CEBRAP', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Coleta CEBRAP', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Coleta CEBRAP', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'coleta-cebrap'),
		);

		register_taxonomy('coleta-cebrap', array($this->post_type), $args);
	}

	public function terms_tipo_base()
	{
		$labels = array(
			'name'              => _x('Tipos Base', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Tipo Base', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Tipos Base', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Tipos Base', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Tipo Base', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Tipo Base', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Tipo Base', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Tipo Base', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Tipo Base', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'tipo-base'),
		);

		register_taxonomy('tipo-base', array($this->post_type), $args);
	}

	public function terms_fonte()
	{
		$labels = array(
			'name'              => _x('Fontes', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Fonte', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Fontes', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todas as Fontes', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Fonte', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Fonte', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Fonte', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Fonte', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Fontes', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'fontes'),
		);

		register_taxonomy('fontes', array($this->post_type), $args);
	}

	public function terms_metodo_calculo()
	{
		$labels = array(
			'name'              => _x('Métodos Cálculo', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Método Cálculo', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Métodos Cálculo', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Métodos Cálculo', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Método Cálculo', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Método Cálculo', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Método Cálculo', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Método Cálculo', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Método Cálculo', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'metodo-calculo'),
		);

		register_taxonomy('metodo-calculo', array($this->post_type), $args);
	}

	public function terms_numerador()
	{
		$labels = array(
			'name'              => _x('Numeradores', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Numerador', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Numeradores', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Numeradores', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Numerador', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Numerador', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Numerador', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Numerador', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Numerador', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'numerador'),
		);

		register_taxonomy('numerador', array($this->post_type), $args);
	}

	public function terms_fonte_numerador()
	{
		$labels = array(
			'name'              => _x('Fontes Numerador', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Fonte Numerador', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Fontes Numerador', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todas as Fontes Numerador', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Fonte Numerador', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Fonte Numerador', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Fonte Numerador', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Fonte Numerador', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Fonte Numerador', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'fonte-numerador'),
		);

		register_taxonomy('fonte-numerador', array($this->post_type), $args);
	}

	public function terms_denominador()
	{
		$labels = array(
			'name'              => _x('Denominadores', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Denominador', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Denominadores', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todos os Denominadores', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Denominador', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Denominador', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Denominador', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Denominador', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Denominador', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'denominador'),
		);

		register_taxonomy('denominador', array($this->post_type), $args);
	}

	public function terms_unidade_medida()
	{
		$labels = array(
			'name'              => _x('Unidades de Medida', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Unidade de Medida', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Unidade de Medida', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todas as Unidades de Medida', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Unidade de Medida', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Unidade de Medida', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Unidade de Medida', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Unidade de Medida', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Unidade de Medida', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'unidade-medida'),
		);

		register_taxonomy('unidade-medida', array($this->post_type), $args);
	}

	public function terms_fonte_denomminador()
	{
		$labels = array(
			'name'              => _x('Fontes Denominador', 'taxonomy general name', OBS_TEXT_DOMAIN),
			'singular_name'     => _x('Fonte Denominador', 'taxonomy singular name', OBS_TEXT_DOMAIN),
			'search_items'      => __('Buscar Fonte Denominador', OBS_TEXT_DOMAIN),
			'all_items'         => __('Todas as Fontes Denominador', OBS_TEXT_DOMAIN),
			'edit_item'         => __('Editar Fonte Denominador', OBS_TEXT_DOMAIN),
			'update_item'       => __('Atualizar Fonte Denominador', OBS_TEXT_DOMAIN),
			'add_new_item'      => __('Adicionar Fonte Denominador', OBS_TEXT_DOMAIN),
			'new_item_name'     => __('Novo nome Fonte Denominador', OBS_TEXT_DOMAIN),
			'menu_name'         => __('Fonte Denominador', OBS_TEXT_DOMAIN),
		);

		$args = array(
			'hierarchical'      	=> false,
			'labels'            	=> $labels,
			'show_ui'           	=> true,
			'show_admin_column' 	=> false,
			'query_var'         	=> true,
			'show_in_rest'				=> true,
			'show_in_quick_edit'	=> true,
			'rewrite'           	=> array('slug' => 'fonte-denominador'),
		);

		register_taxonomy('fonte-denominador', array($this->post_type), $args);
	}
}
