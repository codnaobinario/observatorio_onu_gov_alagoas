<?php
$municipio = $metabox['args']['municipio'] ? $metabox['args']['municipio'] : $metabox['args']['regiao'];
$dados = get_post_meta($post->ID, OBS_PREFIX . $municipio->slug, true);
$anos = get_post_meta($post->ID, OBS_PREFIX . $municipio->slug . '_anos', true);
?>
<div class="container container-indicadores">
	<div class="row mb-3" id="insert-<?php echo $municipio->slug ?>">
		<input type="hidden" name="municipio_slug[]" value="<?php echo $municipio->slug ?>">
		<div class="col-md-1">
			<label for="<?php echo OBS_PREFIX . $municipio->slug . '-ano' ?>" class="form-label">
				<?php _e('Ano', OBS_TEXT_DOMAIN) ?>
			</label>
			<input type="text" class="form-control maskYear" id="<?php echo OBS_PREFIX . $municipio->slug . '-ano' ?>" placeholder="<?php _e('0000', OBS_TEXT_DOMAIN) ?>">
		</div>

		<div class="col-md-4">
			<label for="<?php echo OBS_PREFIX . $municipio->slug . '-valor' ?>" class="form-label">
				<?php _e('Valor', OBS_TEXT_DOMAIN) ?>
			</label>
			<input type="text" class="form-control" id="<?php echo OBS_PREFIX . $municipio->slug . '-valor' ?>" placeholder="<?php _e('Digite o Valor', OBS_TEXT_DOMAIN) ?>">
		</div>

		<div class="col-md-4 col-button">
			<button type="button" class="btn btn-success add-value" data-municipio-slug="<?php echo $municipio->slug ?>">
				<?php _e('Adicionar', OBS_TEXT_DOMAIN) ?>
				<span class="dashicons dashicons-plus"></span>
			</button>
		</div>

	</div>

	<div class="row">

		<div class="col-md-12">
			<div class="title-table">
				<?php _e('Dados Inseridos', OBS_TEXT_DOMAIN) ?>
			</div>
			<input type="hidden" name="slug" value="<?php echo $municipio->slug ?>">
			<table class="wp-list-table widefat fixed striped table-view-list table-indicadores" id="table-<?php echo $municipio->slug ?>">
				<thead>
					<tr>
						<th>
							<?php echo _e('Ano', OBS_TEXT_DOMAIN) ?>
						</th>
						<th>
							<?php echo _e('Valor', OBS_TEXT_DOMAIN) ?>
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dados as $dado) : ?>
						<tr id="<?php printf('%s-%s', $municipio->slug, $dado->ano) ?>">
							<td>
								<input type="text" name="<?php printf('municipio[%s][%s][ano]', $municipio->slug, $dado['ano']) ?>" placeholder="Ano" class="maskYear" value="<?php echo $dado['ano'] ?>" maxlength="4">
							</td>
							<td>
								<input type="text" name="<?php printf('municipio[%s][%s][value]', $municipio->slug, $dado['ano']) ?>" placeholder="Valor" value="<?php echo $dado['value'] ?>">
							</td>
							<td>
								<button type="button" class="btn btn-danger btn-remove-tr">
									<?php _e('Remover', OBS_TEXT_DOMAIN) ?>
									<span class="dashicons dashicons-trash"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

	</div>

</div>
