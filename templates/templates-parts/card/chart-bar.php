<?php
$chartBar_data = obs_get_data_chart_bar(get_the_ID(), $alagoas_data['ano_fim']);
$data_total = count($chartBar_data);
$chartBar_data = obs_chart_bar_order($chartBar_data);

$chartBar_labels = array();
$chartBar_datasets = array();
foreach ($chartBar_data as $key => $data) {
	$data_next = $chartBar_data[$key + 1] ? $chartBar_data[$key + 1] : $chartBar_data[$key];

	$chartBar_labels[] = "'[" . number_format((float)$data[0]['value'], 1, '.', '')  . ',' . number_format((float)$data[count($data) - 1]['value'], 1, '.', '') . "']";

	$chartBar_datasets[] = ($data_total / 100) * count($data);
}

?>
<div class="indicador-chart-desc">
	<span id="indicador-chart-desc">
		<?php _e('Valores relativos nos Municípios Alagoanos', OBS_TEXT_DOMAIN) ?>
	</span>
	<span>
		<?php echo $alagoas_data['ano_fim'] ?>
	</span>
</div>
<div class="indicador-chart-bars">
	<canvas id="myChart-bar-<?php echo get_the_ID() ?>" height="250"></canvas>
</div>
<div class="indicador-chart-position" id="indicador-chart-position-<?php echo get_the_ID() ?>" style="display: none;">

</div>
