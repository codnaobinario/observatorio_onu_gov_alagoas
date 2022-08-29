<?php
defined('ABSPATH') or die('No script kiddies please!');
?>
<div class="wrap">
	<h2 class="admin-plugin-title">
		<span class="dashicons dashicons-database-import"></span>
		<?php _e('Importar Dados', OBS_TEXT_DOMAIN) ?>
	</h2>
	<div class="obs-import-data">
		<div class="container">
			<div class="row">

				<div class="card mt-4">
					<div class="card-body">

						<form action="" class="row">
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<label for="indicador" class="">
												<?php _e('Selecione a Função', OBS_TEXT_DOMAIN) ?>
											</label>
										</th>
										<td>
											<select name="action_type" id="action-type" class="form-control">
												<option value="">
													<?php _e('Selecione...', OBS_TEXT_DOMAIN) ?>
												</option>
												<option value="import_matriz">
													<?php _e('Matriz') ?>
												</option>
												<option value="import_municipios_regioes">
													<?php _e('Municipios e Regiões') ?>
												</option>

											</select>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="" class="form-label">
												<?php _e('Selecionar Arquivo XLSX', OBS_TEXT_DOMAIN) ?>
											</label>
										</th>
										<td>
											<input type="file" class="form-control" id="obs-file-import">
										</td>
									</tr>
									<tr>
										<td colspan="2" class="text-center">
											<button type="button" class="btn btn-primary btn-upload-xls">
												<span class="dashicons dashicons-upload" role="status" aria-hidden="true"></span>
												<?php _e('Enviar dados', OBS_TEXT_DOMAIN) ?>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</form>

					</div>
					<!-- card-body -->
				</div>
				<!-- card -->

				<!-- <div class="col-md-12 mt-4">
					<div class="progress progress-bar-large">
						<div class="progress-bar progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
					</div>
				</div> -->
				<?php obs_preview_log() ?>


			</div>
			<!-- row -->
		</div>
		<!-- container -->
	</div>
</div>
