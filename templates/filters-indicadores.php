<?php
$territorios = obs_get_territorios_all('name');
$get_ods = get_ods_json();
$indicadores_args = array(
	'post_type' => 'indicadores',
	'posts_per_page' => 999999,
);

$meta_query = array();

$post_ods = isset($_GET['ods']) ? $_GET['ods'] : null;
$post_meta = isset($_GET['meta']) ? $_GET['meta'] : null;
$post_territorio = isset($_GET['territorio']) ? $_GET['territorio'] : null;
$post_indicador = isset($_GET['indicador']) ? $_GET['indicador'] : null;

if ($post_indicador) {
	$indicadores_args['p'] = $post_indicador;
}

if ($post_ods) {
	$meta_query[] = array(
		'key' => OBS_PREFIX . 'ods',
		'value' => $post_ods,
		'compare' => '=',
	);
}

if ($post_meta) {
	$meta_query[] = array(
		'key'			=> OBS_PREFIX . 'ods_meta',
		'value'		=> $post_meta,
		'compare'	=> '=',
	);
}

if ($meta_query) {
	if (count($meta_query) > 1) {
		$meta_query['relation'] = 'AND';
	}
	$indicadores_args['meta_query'] = $meta_query;
}

$indicadores = get_posts($indicadores_args);

$terriotrios_ods = array();
$territorios = array(
	'estado' => array(),
	'municipios' => array(),
	'regioes' => array(),
);

$reg = array();
$muni = array();
$est = array();

foreach ($indicadores as $indicador) {
	$ods_number = get_post_meta($indicador->ID, OBS_PREFIX . 'ods', true);
	$ods_meta = get_post_meta($indicador->ID, OBS_PREFIX . 'ods_meta', true);
	if (!$terriotrios_ods[$ods_number]) {
		$terriotrios_ods[$ods_number] = $ods_meta;
	}

	$municipios = get_post_meta($indicador->ID, OBS_PREFIX . 'municipios', true);

	foreach ($municipios as $slug) {
		if (strlen($slug) === 4) {
			$regiao = get_term_by('slug', $slug, 'regiao');
			if (!$reg[$slug]) {
				$reg[$slug] = $regiao->name;
			}
		} else if (strlen($slug) === 2) {
			$municipio = get_term_by('slug', $slug, 'municipios');
			if (!$est[$slug]) {
				$est[$slug] = $municipio->name;
			}
		} else {
			$municipio = get_term_by('slug', $slug, 'municipios');
			if (!$muni[$slug]) {
				$muni[$slug] = $municipio->name;
			}
		}
	}

	$territorios['estado'] = $est;
	$territorios['municipios'] = $muni;
	$territorios['regioes'] = $reg;
}


function compareASCII($a, $b)
{
	$at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
	$bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
	return strcmp($at, $bt);
}

uasort($territorios['estado'], 'compareASCII');
uasort($territorios['municipios'], 'compareASCII');
uasort($territorios['regioes'], 'compareASCII');

ksort($terriotrios_ods);

?>
<section id="filters-indicador">
	<nav class="navbar">
		<form action="<?php echo get_permalink() ?>" method="GET" data-permalink="<?php echo get_permalink() ?>">
			<div class="" id="navbarFilter">

				<ul class="navbar-nav">
					<li class="nav-item ps-0">
						<select name="ods" id="ods" class="nav-select" title="<?php _e('Objetivos do Desenvolvimento Sustentável (ODS)') ?>">
							<option value="">
								<?php _e('Objetivos do Desenvolvimento Sustentável (ODS)') ?>
							</option>
							<?php foreach ($terriotrios_ods as $ods => $name) : ?>
								<?php if ($ods != 'N') : ?>
									<?php $i = array_search($ods, array_column($get_ods, 'id')) ?>
									<option value="<?php echo $ods ?>" <?php echo $ods == $post_ods ? 'selected' : '' ?>>
										<?php printf('%s - %s', $ods, $get_ods[$i]->name) ?>
									</option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</li>
					<li class="nav-item">
						<select name="meta" id="meta" class="nav-select" title="<?php _e('Metas das ODS') ?>">
							<option value="">
								<?php _e('Metas das ODS') ?>
							</option>
							<?php foreach ($indicadores as $indicador) : ?>
								<?php $meta = get_post_meta($indicador->ID, OBS_PREFIX . 'ods_meta', true) ?>
								<?php if ($meta) : ?>
									<option value="<?php echo $meta ?>" <?php echo $meta == $post_meta ? 'selected' : '' ?>>
										<?php echo $meta ?>
									</option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</li>
					<li class="nav-item">
						<select name="territorio" id="territorio" class="nav-select" title="<?php _e('Territórios') ?>">
							<option value="">
								<?php _e('Territórios') ?>
							</option>

							<?php if ($territorios['estado']) : ?>
								<optgroup label="Estado">
									<?php foreach ($territorios['estado'] as $slug => $name) : ?>
										<option value="<?php echo $slug ?>" <?php echo $slug == $post_territorio ? 'selected' : '' ?>>
											<?php echo $name ?>
										</option>
									<?php endforeach; ?>
								</optgroup>
							<?php endif; ?>

							<?php if ($territorios['municipios']) : ?>
								<optgroup label="Municípios">
									<?php foreach ($territorios['municipios'] as $slug => $name) : ?>
										<option value="<?php echo $slug ?>" <? echo $slug == $post_territorio ? 'selected' : '' ?>>
											<?php echo $name ?>
										</option>
									<?php endforeach; ?>
								</optgroup>
							<?php endif; ?>

							<?php if ($territorios['regioes']) : ?>
								<optgroup label="Regiões">
									<?php foreach ($territorios['regioes'] as $slug => $name) : ?>
										<option value="<?php echo $slug ?>" <?php echo $slug == $post_territorio ? 'selected' : '' ?>>
											<?php echo $name ?>
										</option>
									<?php endforeach; ?>
								</optgroup>
							<?php endif; ?>

						</select>
					</li>
					<li class="nav-item">
						<select name="indicador" id="indicador" class="nav-select" title="<?php _e('Indicadores') ?>">
							<option value="">
								<?php _e('Indicadores') ?>
							</option>
							<?php foreach ($indicadores as $indicador) : ?>
								<option value="<?php echo $indicador->ID ?>" <?php echo $indicador->ID == $post_indicador ? 'selected' : '' ?>>
									<?php echo $indicador->post_title ?>
								</option>
							<?php endforeach; ?>
						</select>
					</li>
					<li class="nav-item pe-0">
						<button type="submit" class="btn btn-filter">
							<?php _e('Ir', OBS_TEXT_DOMAIN) ?>
						</button>
					</li>
				</ul>

			</div>
			<div class="box-clear-form">
				<a href="#" class="clear-form">Limpar filtros</a>
			</div>
		</form>
	</nav>
</section>
