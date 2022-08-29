<?php
$odss = get_ods_json();
$ods_id = get_post_meta($post->ID, OBS_PREFIX . 'ods', true);
$ods_meta = get_post_meta($post->ID, OBS_PREFIX . 'ods_meta', true);
$ods_meta_vinculada = get_post_meta($post->ID, OBS_PREFIX . 'ods_meta_vinculada', true);
?>

<?php if ($odss) : ?>
	<div class="container">
		<div class="row">

			<div class="col-md-10">
				<div class="row">

					<div class="col-md-4">
						<label for="ods" class="form-label">
							<?php _e('Número ODS', OBS_TEXT_DOMAIN) ?>
						</label>
						<select name="ods" id="ods" class="form-control ods-change">
							<option value="" data-ods-desc="">
								<?php _e('Selecione...', OBS_TEXT_DOMAIN) ?>
							</option>
							<?php foreach ($odss as $ods) : ?>
								<option value="<?php echo $ods->id ?>" data-ods-desc="<?php echo $ods->description ?>" <?php echo $ods->id == $ods_id ? 'selected' : '' ?>>
									<?php printf('%s - %s', $ods->id, $ods->name) ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-md-8">
						<label for="ods-meta" class="form-label">
							<?php _e('Descrição do ODS (Meta)',) ?>
						</label>
						<input type="text" name="ods_meta" id="ods-meta" class="form-control" value="<?php echo $ods_meta ?>">
					</div>

					<div class="col-md-12 mt-3">
						<label for="ods-meta-vinculada" class="form-label">
							<?php _e('ODS Vinculado (Meta Vinculada)',) ?>
						</label>
						<input type="text" name="ods_meta_vinculada" id="ods-meta-vinculada" class="form-control" value="<?php echo $ods_meta_vinculada ?>">
					</div>

				</div>
			</div>

			<div class="col-md-2 preview-ods">
				<div class="preview-ods-box">
					<img id="img-preview-ods" data-image-path="<?php echo OBS_IMAGE . 'ods/' ?>" src="<?php echo $ods_id ? OBS_IMAGE . 'ods/SDG-' . $ods_id . '.png' : OBS_IMAGE . 'ods/SDG-0.png' ?>" alt="">
				</div>
			</div>


		</div>
	</div>
<?php endif; ?>
