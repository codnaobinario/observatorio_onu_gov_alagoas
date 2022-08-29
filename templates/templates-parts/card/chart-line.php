<?php
?>
<div class="indicador-chart-desc">
	<span>
		<?php _e(get_the_title(), OBS_TEXT_DOMAIN) ?>
	</span>
	<span>
		<?php printf('%s - %s', $alagoas_data['ano_ini'], $alagoas_data['ano_fim']) ?>
	</span>
</div>
<div class="indicador-chart-lines">
	<canvas id="myChart-line-<?php echo get_the_ID() ?>" height="250"></canvas>
</div>
