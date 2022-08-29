<?php
$post_ods = isset($_GET['ods']) ? $_GET['ods'] : null;
$post_meta = isset($_GET['meta']) ? $_GET['meta'] : null;
$post_territorio = isset($_GET['territorio']) ? $_GET['territorio'] : null;
$post_indicador = isset($_GET['indicador']) ? $_GET['indicador'] : null;
$paged = (get_query_var('page')) ? absint(get_query_var('page')) : 1;
$posts_per_page = ($settings['posts_per_page']) ? absint($settings['posts_per_page']) : 6;

$indicador_args = array(
	'post_type'					=> 'indicadores',
	'posts_per_page'		=> $posts_per_page,
	'paged'							=> $paged,
	'order'							=> $settings['order'],
	'orderby'						=> $settings['orderby'],
);

if ($post_indicador) {
	$indicador_args['p'] = $post_indicador;
}

$meta_query = array();

if ($post_territorio) {
	$meta_query[] = array(
		'key'			=> OBS_PREFIX . $post_territorio,
		'value'		=> '',
		'compare'	=> '!=',
	);
}

if ($post_meta) {
	$meta_query[] = array(
		'key'			=> OBS_PREFIX . 'ods_meta',
		'value'		=> $post_meta,
		'compare'	=> '=',
	);
}

if ($post_ods) {
	$meta_query[] = array(
		'key'			=> OBS_PREFIX . 'ods',
		'value'		=> $post_ods,
		'compare'	=> '=',
	);
}

if ($meta_query) {
	if (count($meta_query) > 1) {
		$meta_query['relation'] = 'AND';
	}
	$indicador_args['meta_query'] = $meta_query;
}

$get_ods = get_ods_json();

$regioes = get_terms(array(
	'taxonomy'		=> 'regiao',
	'hide_empty'	=> false,
));

$municipios = get_terms(array(
	'taxonomy'		=> 'municipios',
	'hide_empty'	=> false,
));

$indicadores_query = new \WP_Query($indicador_args);
?>

<!-- <div id="preview-download" style=""></div> -->

<?php if ($indicadores_query->have_posts()) : ?>
	<?php while ($indicadores_query->have_posts()) : $indicadores_query->the_post() ?>

		<section id="indicador-<?php echo get_the_ID() ?>" class="container-indicador">
			<div class="row">
				<div id="preview-indicador-<?php echo get_the_ID() ?>">

				</div>
				<div class="card indicador-card" id="indicador-card-<?php echo get_the_ID() ?>">

					<div class="col-md-12 indicador-card-top">
						<div class="row row-indicador-card-top">

							<!-- <div class="col-md-1 indicador-card-top-left">
								<div class="indicador-number">
									<span style="background-color: rgb(229, 36, 59);">

									</span>
								</div>
							</div> -->
							<div class="col-md-10 indicador-card-top-center">
								<div class="indicardor-title">
									<?php echo get_the_title() ?>
									<?php $unidadeMedida = obs_get_term(get_the_ID(), 'unidade-medida', true) ?>
									<?php if ($unidadeMedida) : ?>
										<span class="indicador-unidade-medida">
											<?php printf('(%s)', $unidadeMedida->name) ?>
										</span>
									<?php endif; ?>
								</div>
								<?php $indicador_fontes = obs_get_term(get_the_ID(), 'fontes', true) ?>
								<?php if ($indicador_fontes) : ?>
									<div class="indicardor-fonte">
										<strong>
											<?php _e('Fonte:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span>
											<?php echo $indicador_fontes->name ?>
										</span>
									</div>
								<?php endif; ?>


								<?php $ods_meta = get_post_meta(get_the_ID(), OBS_PREFIX . 'ods_meta', true) ?>
								<?php if ($ods_meta) : ?>
									<div class="indicardor-meta">
										<strong>
											<?php _e('Meta:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span class="desc">
											<?php printf('%s', $ods_meta) ?>
										</span>
									</div>
								<?php endif; ?>

								<?php $ods_meta_vinculada = get_post_meta(get_the_ID(), OBS_PREFIX . 'ods_meta_vinculada', true) ?>
								<?php if ($ods_meta_vinculada) : ?>
									<div class="indicardor-meta-vinculada">
										<strong>
											<?php _e('Meta Vinculada:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span class="desc">
											<?php printf('%s', $ods_meta_vinculada) ?>
										</span>
									</div>
								<?php endif; ?>
							</div>

							<div class="col-md-2 indicador-card-top-right">
								<?php $ods = get_post_meta(get_the_ID(), OBS_PREFIX . 'ods', true) ?>
								<?php if ($ods) : ?>
									<div class="indicador-img-ods">
										<img src="<?php printf('%sods/SDG-%s.png', OBS_IMAGE, $ods) ?>" alt="" title="Erradicação da Pobreza">
									</div>
								<?php endif; ?>
							</div>

						</div>
					</div>

					<div class="col-md-12 indicador-card-center">

						<?php $municipios_regioes = obs_get_municipios_and_regioes(get_the_ID()); ?>
						<?php if ($municipios_regioes) : ?>

							<?php if ($municipios_regioes['municipios']) : ?>
								<select name="<?php printf('indicador_municipio_%s', get_the_ID()) ?>" id="<?php printf('indicador-municipio-%s', get_the_ID()) ?>" class="slct-indicadores-municipios" data-type="municipios">
									<option value="">
										<?php _e('Municípios', OBS_TEXT_DOMAIN) ?>
									</option>
									<?php foreach ($municipios_regioes['municipios'] as $municipio) : ?>
										<?php $key = array_search($municipio, array_column($municipios, 'slug')); ?>
										<?php if (strlen($municipio) != 2) : ?>
											<option value="<?php printf('%s', $municipio) ?>" data-name="<?php printf('%s', $municipios[$key]->name) ?>" <?php echo $municipio == $post_territorio ? 'selected' : '' ?>>
												<?php printf('%s', $municipios[$key]->name) ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
							<?php if ($municipios_regioes['regioes']) : ?>
								<select name="<?php printf('indicador_regiao_%s', get_the_ID()) ?>" id="<?php printf('indicador-regiao-%s', get_the_ID()) ?>" data-type="regiao">
									<option value="">
										<?php _e('Regiões', OBS_TEXT_DOMAIN) ?>
									</option>
									<?php foreach ($municipios_regioes['regioes'] as $regiao) : ?>
										<?php $key = array_search($regiao, array_column($regioes, 'slug')); ?>
										<option value="<?php printf('%s', $regiao) ?>" data-name="<?php printf('%s', $regioes[$key]->name) ?>" <?php echo $regiao == $post_territorio ? 'selected' : '' ?>>
											<?php printf('%s', $regioes[$key]->name) ?>
										</option>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>

						<?php endif; ?>
						<!-- municipios_regioes -->
					</div>

					<div class="col-md-12 indicador-card-bottom">
						<div class="row row-indicador-card-bottom">

							<div class="col-md-9 indicador-card-bottom-left">
								<?php $alagoas_data = obs_get_data_alagoas(get_the_ID()); ?>
								<div class="indicador-chart indicador-chart-left">
									<?php include OBS_PLUGIN_TEMPLATE . 'templates-parts/card/chart-line.php' ?>
								</div>
								<div class="indicador-chart indicador-chart-right">
									<?php include OBS_PLUGIN_TEMPLATE . 'templates-parts/card/chart-bar.php' ?>
								</div>
								<?php include OBS_PLUGIN_TEMPLATE . 'templates-parts/card/charts-scripts.php' ?>
							</div>
							<input type="hidden" id="year-preview-<?php echo get_the_ID() ?>" value="<?php echo $alagoas_data['ano_fim'] ?>">
							<div class="col-md-3 indicador-card-bottom-right">

								<?php $description = get_post_meta(get_the_ID(), OBS_PREFIX . 'description', true); ?>
								<?php if ($description) : ?>
									<div class="indicador-descricao">
										<strong>
											<?php _e('Descriçao Indicador:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span class="desc">
											<?php printf('%s', $description) ?>
										</span>
									</div>
								<?php endif; ?>

								<?php $concepts_definitions = get_post_meta(get_the_ID(), OBS_PREFIX . 'concepts_definitions', true); ?>
								<?php if ($concepts_definitions) : ?>
									<div class="indicador-conceitos-definicoes">
										<strong>
											<?php _e('Conceitos e Definições:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span class="desc">
											<?php printf('%s', $concepts_definitions) ?>
										</span>
									</div>
								<?php endif; ?>

								<?php $metodoCalculo = get_post_meta(get_the_ID(),  OBS_PREFIX . 'metodo_calculo', true) ?>
								<?php if ($metodoCalculo) : ?>
									<div class="indicador-metodo-calculo">
										<strong>
											<?php _e('Método de Cálculo:', OBS_TEXT_DOMAIN) ?>
										</strong>
										<span class="desc">
											<?php printf('%s', $metodoCalculo) ?>
										</span>
									</div>
								<?php endif; ?>
								<div class="indicador-download">
									<button type="button" class="btn share-indicador" data-indicador-id="<?php echo get_the_ID() ?>" data-indicador-title="<?php echo get_the_title() ?>">
										<span class="dashicons dashicons-format-image"></span>
										<span>
											<?php _e('Exportar Indicador', OBS_TEXT_DOMAIN) ?>
										</span>
									</button>
									<button type="button" class="btn download-indicador" data-indicador-id="<?php echo get_the_ID() ?>">
										<span class="dashicons dashicons-download"></span>
										<span>
											<?php _e('Baixar dados', OBS_TEXT_DOMAIN) ?>
										</span>
									</button>
								</div>
							</div>

						</div>
					</div>
				</div> <!-- card -->
			</div>
		</section>

	<?php endwhile; ?>
	<?php if ($settings['show_pagination']) : ?>
		<?php obs_indicador_paginate($indicadores_query, $paged) ?>
	<?php endif; ?>
<?php else : ?>
	<section id="indicador-not-found">
		<div class="row">
			<div class="col-md-12">
				<?php _e('Nenhum Indicador encontrado com o filtro selecionado.', OBS_TEXT_DOMAIN) ?>

			</div>
		</div>
	</section>
<?php endif; ?>
