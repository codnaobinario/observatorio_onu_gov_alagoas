<?php

function obs_get_template_admin(string $path, $variaveis = null)
{
	if (!is_admin()) return false;

	if (file_exists(OBS_PLUGIN_TEMPLATE . 'admin/' . $path . '.php')) {
		include_once OBS_PLUGIN_TEMPLATE . 'admin/' . $path . '.php';
	}
}

function obs_get_templates_parts(string $path)
{
	if (file_exists(OBS_PLUGIN_TEMPLATE . 'templates-parts/' . $path . '.php')) {
		include OBS_PLUGIN_TEMPLATE . 'templates-parts/' . $path . '.php';
	}
}

function get_ods_json()
{
	$get_ods = file_get_contents(OBS_PLUGIN_ASSETS . 'json/ods.json');

	if (!$get_ods) {
		return false;
	}

	return json_decode($get_ods);
}

function obs_get_term($post_id, string $term, bool $unique = false)
{
	$get_term = get_the_terms($post_id, $term);
	if (empty($get_term)) return false;
	if ($unique) return $get_term[0];

	return $get_term;
}

function obs_get_municipios_and_regioes($post_id)
{
	$municipios = array();
	$regioes = array();

	$slugs = get_post_meta($post_id, OBS_PREFIX . 'municipios', true);

	if (!$slugs) return false;

	foreach ($slugs as $slug) {
		if (strlen($slug) == 4) {
			array_push($regioes, $slug);
		} else {
			array_push($municipios, $slug);
		}
	}

	return array('municipios' => $municipios, 'regioes' => $regioes);
}

function obs_preview_log()
{
?>
	<div class="col-md-12 mt-4">
		<div id="import-status"></div>
		<textarea class="form-control infos-prograss-bar" rows="8" readonly><?php _e('Aguardando dados', OBS_TEXT_DOMAIN) ?></textarea>
	</div>
<?php
}

function obs_get_data_alagoas($post_id)
{
	$alagoas = get_post_meta($post_id, OBS_PREFIX . '27', true);

	$labels = array();
	$data = array();
	foreach ($alagoas as $key => $value) {
		$labels[] = $value['ano'];
		$data[] = $value['value'] || $value['value'] === '0' ? floatval($value['value']) : null;
	}

	$ano_ini = $labels[0];
	$ano_fim = $labels[count($labels) - 1];

	$get_ods = get_ods_json();
	$ods = get_post_meta($post_id, OBS_PREFIX . 'ods', true);

	$key_ods = array_search($ods, array_column($get_ods, 'id'));

	return array(
		'labels' 		=> $labels,
		'data'			=> $data,
		'ano_ini'		=> $ano_ini,
		'ano_fim'		=> $ano_fim,
		'ods'				=> $get_ods[$key_ods],
	);
}

function obs_get_data_municipio_regiao($post_id, $slug)
{
	$alagoas = get_post_meta($post_id, OBS_PREFIX . $slug, true);

	$labels = array();
	$data = array();
	foreach ($alagoas as $key => $value) {
		$labels[] = $value['ano'];
		$data[] = $value['value'] || $value['value'] === '0' ? floatval($value['value']) : null;
	}

	$ano_ini = $labels[0];
	$ano_fim = $labels[count($labels) - 1];

	$get_ods = get_ods_json();
	$ods = get_post_meta($post_id, OBS_PREFIX . 'ods', true);

	$key_ods = array_search($ods, array_column($get_ods, 'id'));

	return array(
		'labels' 		=> $labels,
		'data'			=> $data,
		'ano_ini'		=> $ano_ini,
		'ano_fim'		=> $ano_fim,
		'ods'				=> $get_ods[$key_ods],
	);
}

function obs_get_data_chart_bar($post_id, $year, $type = 'municipios')
{

	if ($type == 'municipios') {
		$municipios = get_terms(array(
			'taxonomy' => 'municipios',
			'hide_empty' => false,
		));
	}

	if ($type == 'regiao') {
		$municipios = get_terms(array(
			'taxonomy' => 'regiao',
			'hide_empty' => false,
		));
	}

	$metas = array();

	foreach ($municipios as $municipio) {
		$metas[$municipio->slug] = get_post_meta($post_id, OBS_PREFIX . $municipio->slug, true);
	}

	$infos = array();
	foreach ($metas as $slug => $municipio) {
		if (strlen($slug) != 2) {
			$key = array_search($slug, array_column($municipios, 'slug'));
			$slug_info = $municipios[$key]->slug;
			$name_info = $municipios[$key]->name;
		}

		if ($slug_info != 'codigo') {
			$infos[] = array(
				'slug'			=> $slug_info,
				'name'			=> $name_info,
				'value'			=> floatval($municipio[$year]['value']),
			);
		}
	}

	usort($infos, function ($a, $b) {
		$al = $a['value'];
		$bl = $b['value'];

		if ($al == $bl) {
			return 0;
		}

		return ($al > $bl) ? +1 : -1;
	});

	return $infos;
}

function obs_chart_bar_order($data)
{
	$infos_first = floor($data[0]['value']);
	$infos_last = ceil($data[count($data) - 1]['value']);
	$infos_qty = $infos_last - $infos_first;
	$info_media = $infos_qty / 8;
	$infos_order = array();
	foreach ($data as $inf) {
		$key = floor($inf['value'] / $info_media) - 1;
		$infos_order[$key][] = $inf;
	}

	return $infos_order;
}

function obs_get_territorios_all($order = 'slug')
{
	$municipios = get_terms(array(
		'taxonomy' => 'municipios',
		'hide_empty' => false,
	));

	$regioes = get_terms(array(
		'taxonomy' => 'regiao',
		'hide_empty' => false,
	));

	$territorios = array();

	foreach ($municipios as $municipio) {
		$territorios[] = $municipio;
	}

	foreach ($regioes as $regiao) {
		$territorios[] = $regiao;
	}

	if ($order === 'name') {
		usort($territorios, function ($a, $b) {
			$al = $a->name;
			$bl = $b->name;

			if ($al == $bl) {
				return 0;
			}

			return ($al > $bl) ? +1 : -1;
		});
	} else {
		usort($territorios, function ($a, $b) {
			$al = $a->slug;
			$bl = $b->slug;

			if ($al == $bl) {
				return 0;
			}

			return ($al > $bl) ? +1 : -1;
		});
	}

	return $territorios;
}


function obs_indicador_paginate($query, $paged = 1)
{
	$big = 999999999; // need an unlikely integer
	echo '<div class="indicador-pagination">';

	echo paginate_links(array(
		'base'									=> str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format'								=> '?paged=%#%',
		'current'								=> $paged,
		'total'									=> $query->max_num_pages,
	));

	echo '</div>';
}

function obs_insert_terms($post_id, $term, $taxonomy)
{
	$insert = term_exists($term, $taxonomy);

	if (!$insert) {
		$args = array(
			'description' => $term,
		);
		$insert = wp_insert_term($term, $taxonomy, $args);
	}

	$set_term = wp_set_post_terms($post_id, array((int) $insert['term_id']), $taxonomy, false);

	return $set_term;
}
