<?php
defined('ABSPATH') or die('No script kiddies please!');
$indicador_args = array(
	'post_type' => 'indicadores',
	'posts_per_page' => 999999,
	'order' => 'ASC',
	'orderby' => 'title',
);

$indicadores = new \WP_Query($indicador_args)

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
							<input type="hidden" id="action-type" name="action_type" value="data_indicadores">
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<label for="indicador" class="">
												<?php _e('Indicador', OBS_TEXT_DOMAIN) ?>
											</label>
										</th>
										<td>
											<?php if ($indicadores->have_posts()) : ?>
												<select name="indicador" id="indicador" class="select2 orm-control">
													<option value="">
														<?php _e('Selecione...', OBS_TEXT_DOMAIN) ?>
													</option>
													<?php while ($indicadores->have_posts()) : $indicadores->the_post() ?>
														<option value="<?php echo get_the_ID() ?>">
															<?php echo get_the_title() ?>
														</option>
													<?php endwhile; ?>

												</select>
											<?php endif; ?>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="" class="form-label">
												<?php _e('Arquivo XLSX', OBS_TEXT_DOMAIN) ?>
											</label>
										</th>
										<td>
											<input type="file" class="form-control" id="obs-file-import">
										</td>
									</tr>
									<tr>
										<td colspan="2" class="text-center">
											<button type="button" class="btn btn-primary btn-upload-xls-indicador">
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
