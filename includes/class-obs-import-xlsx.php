<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Obs_Import_Xlsx
{
	public static $_instance = null;

	public $ajax_load = [
		'import_municipios_regioes',
		'data_indicadores',
		'preview_indicador_chart_line',
		'download_indicador',
		'import_matriz',
		'dados_abertos_indicadores',
	];

	public static function get_instance()
	{
		self::$_instance = empty(self::$_instance) ? new Obs_Import_Xlsx() : self::$_instance;

		return self::$_instance;
	}

	function __construct()
	{
		foreach ($this->ajax_load as $ajax) {
			add_action('wp_ajax_' . OBS_PREFIX . $ajax, array($this, $ajax));
			add_action('wp_ajax_nopriv_' . OBS_PREFIX . $ajax, array($this, $ajax));
		}
	}

	public function import_municipios_regioes()
	{
		$atts = isset($_POST['atts']) ? $_POST['atts'] : '';

		foreach ($atts as $key => $values) {
			foreach ($values as $key => $value) {
				if ($key === 0) {
					$value = array_map('strtoupper', $value);
					$key_cod = array_search('CODIGO', $value);
					$key_name = array_search('NOME', $value);
				}

				if ($key > 0) {
					$terms_args = array(
						'slug' => $value[$key_cod],
						'description' => $value[$key_name],
					);

					$taxonomy = strlen($value[$key_cod]) == 4 ? 'regiao' : 'municipios';
					$insert = wp_insert_term($value[1], $taxonomy, $terms_args);

					if ($insert->errors['term_exists']) {
						$args_update = array(
							'name' => $value[$key_name],
							'slug' => $value[$key_cod],
							'description' => $value[$key_name],
						);
						wp_update_term($insert->error_data['term_exists'], $taxonomy, $args_update);
					}
				}
			}
		}

		wp_send_json(
			array(
				'status' => 'success',
				'msg' => 'Dados importados com sucesso!',
			),
		);

		exit;
	}

	public function import_matriz()
	{
		$atts = isset($_POST['atts']) ? $_POST['atts'] : '';

		$insert_terms = array();
		$key_arquivos = array();

		foreach ($atts as $key => $values) {
			foreach ($values as $key => $value) {
				if ($key === 0) {
					$value = array_map('strtoupper', $value);
					$key_arquivo = array_search('NOME ARQUIVO', $value);
					$key_title = array_search('INDICADOR', $value);
					$key_desc = array_search('DESCRICAO INDICADOR', $value);
					$key_conceitos_definicoes = array_search('CONCEITOS E DEFINICOES', $value);
					$key_meta = array_search('META', $value);
					$key_meta_vinculada = array_search('META VINCULADA', $value);
					$key_ref = array_search('REFERENCIA', $value);
					$key_responsavel_coleta = array_search('RESPONSAVEL COLETA', $value);
					$key_coleta_cebrap = array_search('COLETA CEBRAP', $value);
					$key_ods = array_search('ODS', $value);
					// $key_objetivo = array_search('OBJETIVO', $value);
					$key_tipo_base = array_search('TIPO DE BASE', $value);
					// $key_periodo = array_search('PERIODO', $value);
					$key_fonte = array_search('FONTE', $value);
					$key_unidade_medida = array_search('UNIDADE DE MEDIDA', $value);
					$key_metodo_calc = array_search('METODO DE CALCULO', $value);
					$key_numerador = array_search('NUMERADOR', $value);
					$key_fonte_numerador = array_search('FONTE NUMERADOR', $value);
					$key_denominador = array_search('DENOMINADOR', $value);
					$key_fonte_denominador = array_search('FONTE DENOMINADOR', $value);
					// $key_responsavel = array_search('RESPONSAVEL', $value);
				}

				if ($key > 0) {

					if ($value[$key_title]) {
						$get_post = get_page_by_title($value[$key_title], OBJECT, 'indicadores');

						$args_meta = array(
							OBS_PREFIX . 'ods' 										=> $value[$key_ods],
							OBS_PREFIX . 'ods_meta'								=> $value[$key_meta],
							OBS_PREFIX . 'ods_meta_vinculada'			=> $value[$key_meta_vinculada],
							OBS_PREFIX . 'ods_meta_vinculada'			=> $value[$key_meta_vinculada],
							OBS_PREFIX . 'description'						=> $value[$key_desc],
							OBS_PREFIX . 'concepts_definitions'		=> $value[$key_conceitos_definicoes],
							OBS_PREFIX . 'metodo_calculo'					=> $value[$key_metodo_calc],
							OBS_PREFIX . 'arquivo'								=> $value[$key_arquivo],
						);

						if (!$get_post) {
							$args = array(
								'post_title'		=> $value[$key_title],
								'post_type'			=> 'indicadores',
								'post_status'		=> 'publish',
								'meta_input'		=> $args_meta,
							);

							$insert_id = wp_insert_post($args);
						} else {
							$insert_id = $get_post->ID;

							wp_update_post(array(
								'ID'			=> $get_post->ID,
								'post_title'		=> $value[$key_title],
								'post_type'			=> 'indicadores',
								'post_status'		=> 'publish',
								'meta_input'		=> $args_meta,
							));
						}


						if ($insert_id) {
							if ($key_ref !== false) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_ref], 'referencia');
							}

							if ($key_responsavel_coleta !== false && $value[$key_responsavel_coleta]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_responsavel_coleta], 'responsavel-coleta');
							}

							if ($key_coleta_cebrap !== false && $value[$key_coleta_cebrap]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_coleta_cebrap], 'coleta-cebrap');
							}

							if ($key_tipo_base !== false && $value[$key_tipo_base]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_tipo_base], 'tipo-base');
							}

							if ($key_fonte !== false && $value[$key_fonte]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_fonte], 'fontes');
							}

							// if ($key_metodo_calc !== false && $value[$key_metodo_calc]) {
							// 	$insert_terms[] = obs_insert_terms($insert_id, $value[$key_metodo_calc], 'metodo-calculo');
							// }

							if ($key_numerador !== false && $value[$key_numerador]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_numerador], 'numerador');
							}

							if ($key_fonte_numerador !== false && $value[$key_fonte_numerador]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_fonte_numerador], 'fonte-numerador');
							}

							if ($key_denominador !== false && $value[$key_denominador]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_denominador], 'denominador');
							}

							if ($key_fonte_denominador !== false && $value[$key_fonte_denominador]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_fonte_denominador], 'fonte-denominador');
							}

							if ($key_unidade_medida !== false && $value[$key_unidade_medida]) {
								$insert_terms[] = obs_insert_terms($insert_id, $value[$key_unidade_medida], 'unidade-medida');
							}

							if ($key_arquivo !== false && $value[$key_arquivo]) {
								$file_name = explode('.', $value[$key_arquivo]);
								$key_arquivos[$file_name[0]] = $insert_id;
							}
						}
					}
				}
			}
		}

		if (!$insert_id) {
			wp_send_json(
				array(
					'status' => 'error',
					'msg' => 'Foram encontrados erros ao inserir dados.',
					'insert_id' => $insert_id,
				),
			);
		}

		wp_send_json(
			array(
				'status' => 'success',
				'msg' => 'Dados importados com sucesso!',
				'insert_id' => $insert_id,
				'arquivos' => $key_arquivos,
			),
		);

		exit;
	}

	public function data_indicadores()
	{
		$atts = isset($_POST['atts']) ? $_POST['atts'] : '';
		$indicador_id = isset($_POST['indicador_id']) ? $_POST['indicador_id'] : '';
		$year = isset($_POST['year']) ? $_POST['year'] : '';
		$full = isset($_POST['full']) ? $_POST['full'] : null;

		if (!$indicador_id) {
			wp_send_json(
				array(
					'status' => 'error',
					'msg' => 'Indicador não selecionado.',
				),
			);
			exit;
		}

		$indicador = get_post($indicador_id);

		if (!$indicador) {
			wp_send_json(
				array(
					'status' => 'error',
					'msg' => 'Indicador não encontrado.',
				),
			);
			exit;
		}

		foreach ($atts as $key => $values) {
			$args = array();
			$key_cod = 0;
			$key_name = 1;
			$key_ano = 2;
			$key_val = 3;
			foreach ($values as $key => $value) {
				if ($key === 0) {
					$value = array_map('strtoupper', $value);
					$key_cod = array_search('CODIGO', $value);
					$key_name = array_search('NOME', $value);
					$key_ano = array_search('ANO', $value);
					$key_val = array_search('VALOR', $value);
					continue;
				}

				if ($key > 0) {
					$taxonomy = strlen($value[$key_cod]) == 4 ? 'regiao' : 'municipios';
					$term = get_term_by('slug', $value[$key_cod], $taxonomy);
					$slug = $term->slug;

					$ano = $value[$key_ano];
					$val = $value[$key_val];

					$anos[$slug][] = $ano;

					$args[$slug][$ano] = array(
						'ano' => $ano,
						'value' => $val,
					);
				}
			}
		}

		$municipios = array();

		foreach ($anos as $slug => $value) {
			sort($value);
			update_post_meta($indicador_id, OBS_PREFIX . $slug . '_anos', $value);
			// $municipios[] = $slug;
		}

		foreach ($args as $slug => $values) {
			ksort($values);
			update_post_meta($indicador_id, OBS_PREFIX . $slug, $values);
			$municipios[] = $slug;
		}

		update_post_meta($indicador_id, OBS_PREFIX . 'municipios', $municipios);

		wp_send_json(
			array(
				'status' => 'success',
				'msg' => 'Dados importados com sucesso!',
				'term' => $term,
				'slug' => $slug,
				'args' => $args,
				'anos' => $anos,
				'key_cod' => $key_cod,
				'key_name' => $key_name,
				'key_ano' => $key_ano,
				'key_val' => $key_val,
			),
		);

		exit;
	}

	public function preview_indicador_chart_line()
	{

		$indicador_id = isset($_POST['indicador_id']) ? $_POST['indicador_id'] : 0;
		$slug = isset($_POST['slug']) ? $_POST['slug'] : 0;
		$year = isset($_POST['year']) ? $_POST['year'] : '';
		$color = isset($_POST['color']) ? $_POST['color'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';

		$args = obs_get_data_municipio_regiao($indicador_id, $slug);

		$chartBar = obs_get_data_chart_bar($indicador_id, $year, $type);
		$qty = count($chartBar);

		$position = array_search($slug, array_column($chartBar, 'slug'));
		$name = $chartBar[$position]['name'];

		$chartBar = obs_chart_bar_order($chartBar);

		$loc = [];
		foreach ($chartBar as $value) {
			$local = array_search($slug, array_column($value, 'slug'));
			$loc[] = $local;
			if ($local !== false) {
				$colors[] = 'rgba(64, 84, 178, 1)';
			} else {
				$colors[] = $color;
			}
		}

		$chartBar_labels = array();
		$chartBar_datasets = array();
		foreach ($chartBar as $key => $data) {
			$data_next = $chartBar[$key + 1] ? $chartBar[$key + 1] : $chartBar[$key];

			$chartBar_labels[] = "'[" . number_format((float)$data[0]['value'], 1, '.', '')  . ',' . number_format((float)$data[count($data) - 1]['value'], 1, '.', '') . "']";

			$chartBar_datasets2[] = count($data);
			$chartBar_datasets[] = (100 / $qty) * count($data);
		}


		wp_send_json(
			array(
				'status' => 'success',
				'indicador_id' => $indicador_id,
				'slug' => $slug,
				'args' => $args,
				'chartBar' => array(
					'position' => $position + 1,
					'qty' => $qty,
					'colors' => $colors,
					'name' => $name,
					'datasets' => $chartBar_datasets,
					'datasets2' => $chartBar_datasets2,
					'labels' => $chartBar_labels,
				),
				'chart' => $chartBar,
				'local' => $loc,

			),
		);

		exit;
	}

	public function download_indicador()
	{
		$indicador_id = isset($_POST['indicador_id']) ? $_POST['indicador_id'] : 0;

		$arquivo = get_post_meta($indicador_id, OBS_PREFIX . 'arquivo', true);

		$data = obs_get_municipios_and_regioes($indicador_id);
		$atts = array();

		foreach ($data as $values) {
			foreach ($values as $slug) {
				$atts[$slug] = get_post_meta($indicador_id, OBS_PREFIX . $slug, true);
			}
		}

		$xlsx = array();

		foreach ($atts as $slug => $values) {
			if (strlen($slug) == 4) {
				$term = get_term_by('slug', $slug, 'regiao');
			} else {
				$term = get_term_by('slug', $slug, 'municipios');
			}

			foreach ($values as $att) {
				$dados = (object)array(
					'CODIGO' => $slug,
					'NOME' => $term->name,
					'ANO' => $att['ano'],
					'VALOR' => str_replace('.', ',', $att['value']),
				);

				$xlsx[] = $dados;
			}
		}

		function cmp($a, $b)
		{
			$al = $a->CODIGO;
			$bl = $b->CODIGO;

			if ($al == $bl) {
				return 0;
			}

			return ($al > $bl) ? +1 : -1;
		}

		usort($xlsx, 'cmp');



		wp_send_json(
			array(
				'status' => 'success',
				'msg' => 'Dados importados com sucesso!',
				'indicador_id' => $indicador_id,
				'data' => $data,
				'atts' => $atts,
				'xlsx' => $xlsx,
				'title' => get_the_title($indicador_id),
				'arquivo' => $arquivo,
			),
		);

		exit;
	}

	public function dados_abertos_indicadores()
	{

		$indicador_args = array(
			'post_type' => 'indicadores',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => OBS_PREFIX . 'municipios',
					'compare' => 'EXISTS',
				)
			),
		);

		$query = new \WP_Query($indicador_args);

		$indicadores = array();

		if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
				$indicadores[] = get_the_ID();
			endwhile;
		endif;

		wp_send_json(
			array(
				'status' => 'success',
				'msg' => 'Dados importados com sucesso!',
				'indicadores' => $indicadores
			),
		);

		exit;
	}
}
