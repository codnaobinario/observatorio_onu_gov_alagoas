<script>
	(function($) {
		$(document).ready(function() {
			<?php echo 'const ctxLine_' . get_the_ID() ?> = document.getElementById('myChart-line-<?php echo get_the_ID() ?>').getContext('2d');
			<?php echo 'const dataseatAlagoas_' . get_the_ID() ?> = {
				label: 'Alagoas',
				data: <?php echo json_encode($alagoas_data['data']) ?>,
				backgroundColor: [
					'<?php echo $alagoas_data['ods']->color ?>',
				],
				borderColor: [
					'<?php echo $alagoas_data['ods']->color ?>',
				],
				borderWidth: 4,
				tension: 0.1,
				spanGaps: true,

			}

			<?php echo 'const myChartLine_' . get_the_ID() ?> = new Chart(<?php echo 'ctxLine_' . get_the_ID() ?>, {
				type: 'line',
				data: {
					labels: <?php echo json_encode($alagoas_data['labels']) ?>,
					datasets: [<?php echo 'dataseatAlagoas_' . get_the_ID() ?>],
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							reverse: true,
							labels: {
								boxWidth: 15,
								boxHeight: 1,
								font: {
									size: 10,
								},
							}
						},
					},
					scales: {
						x: {
							ticks: {
								font: {
									size: 9,
								},
							},
						},
						y: {
							ticks: {
								font: {
									size: 9,
								},
							},
							// title: {
							// 	display: true,
							// 	text: '<?php printf('%s %s', $unidadeMedida->name, get_the_title()) ?>',
							// 	font: {
							// 		size: 9,
							// 	},
							// },
						},
					},
				},
			});

			<?php echo 'const datasetBarInit_' . get_the_ID() ?> = <?php echo json_encode($chartBar_datasets) ?>;
			<?php echo 'const labelsBarInit_' . get_the_ID() ?> = <?php echo json_encode($chartBar_labels) ?>;

			<?php echo 'const dataseatBar_' . get_the_ID() ?> = {
				label: '% de Municípios',
				data: <?php echo 'datasetBarInit_' . get_the_ID() ?>,
				backgroundColor: [
					'<?php echo $alagoas_data['ods']->color ?>',
				],
				borderColor: [
					'<?php echo $alagoas_data['ods']->color ?>',
				],
				borderWidth: 4,
				inflateAmount: 4,
				spanGaps: true,
			}

			<?php echo 'const ctxBar_' . get_the_ID() ?> = document.getElementById('myChart-bar-<?php echo get_the_ID() ?>').getContext('2d');
			<?php echo 'const myChartBar_' . get_the_ID() ?> = new Chart(<?php echo 'ctxBar_' . get_the_ID() ?>, {
				type: 'bar',
				data: {
					labels: <?php echo 'labelsBarInit_' . get_the_ID() ?>,
					datasets: [<?php echo 'dataseatBar_' . get_the_ID() ?>],
				},
				options: {
					plugins: {
						legend: {
							display: false,
							// position: 'bottom',
							// labels: {
							// 	font: {
							// 		size: 9,
							// 	},
							// },
						},
					},
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								font: {
									size: 9,
								},
							},
							title: {
								display: true,
								text: '% de Municipios',
								font: {
									size: 9,
								},
							},
						},
						x: {
							ticks: {
								font: {
									size: 9,
								},
							},
							title: {
								display: true,
								text: '<?php printf('%s %s', $unidadeMedida->name, get_the_title()) ?>',
								font: {
									size: 9,
								},
							},
						}
					},

				}
			});

			if ($('#indicador-municipio-<?php echo get_the_ID() ?>').length) {
				const select = $('#indicador-municipio-<?php echo get_the_ID() ?>');
				const selectVal = select.val();
				const dataName = select.children('option:selected').attr('data-name');
				const dataType = select.attr('data-type');

				if (selectVal) {
					loadChart.updateLine(
						<?php echo 'myChartLine_' . get_the_ID() ?>,
						<?php echo 'myChartBar_' . get_the_ID() ?>,
						<?php echo 'dataseatAlagoas_' . get_the_ID() ?>,
						dataName,
						selectVal,
						<?php echo get_the_ID() ?>,
						$('#year-preview-<?php echo get_the_ID() ?>').val(),
						'<?php echo $alagoas_data['ods']->color ?>',
						dataType,
						<?php echo 'datasetBarInit_' . get_the_ID() ?>,
						<?php echo 'labelsBarInit_' . get_the_ID() ?>,
					);
				}
			}

			if ($('#indicador-regiao-<?php echo get_the_ID() ?>').length) {
				const select = $('#indicador-regiao-<?php echo get_the_ID() ?>');
				const selectVal = select.val();
				const dataName = select.children('option:selected').attr('data-name');
				const dataType = select.attr('data-type');

				if (selectVal) {
					loadChart.updateLine(
						<?php echo 'myChartLine_' . get_the_ID() ?>,
						<?php echo 'myChartBar_' . get_the_ID() ?>,
						<?php echo 'dataseatAlagoas_' . get_the_ID() ?>,
						dataName,
						selectVal,
						<?php echo get_the_ID() ?>,
						$('#year-preview-<?php echo get_the_ID() ?>').val(),
						'<?php echo $alagoas_data['ods']->color ?>',
						dataType,
						<?php echo 'datasetBarInit_' . get_the_ID() ?>,
						<?php echo 'labelsBarInit_' . get_the_ID() ?>,
					);
				}
			}

			$(document).on('change', '#indicador-municipio-<?php echo get_the_ID() ?>, #indicador-regiao-<?php echo get_the_ID() ?>', function() {

				if ($(this).attr('id') === 'indicador-municipio-<?php echo get_the_ID() ?>') {
					$('#indicador-regiao-<?php echo get_the_ID() ?>').val('');
				} else {
					$('#indicador-municipio-<?php echo get_the_ID() ?>').val('');
				}

				loadChart.updateLine(
					<?php echo 'myChartLine_' . get_the_ID() ?>,
					<?php echo 'myChartBar_' . get_the_ID() ?>,
					<?php echo 'dataseatAlagoas_' . get_the_ID() ?>,
					$(this).children('option:selected').attr('data-name'),
					$(this).val(),
					<?php echo get_the_ID() ?>,
					$('#year-preview-<?php echo get_the_ID() ?>').val(),
					'<?php echo $alagoas_data['ods']->color ?>',
					$(this).attr('data-type'),
					<?php echo 'datasetBarInit_' . get_the_ID() ?>,
					<?php echo 'labelsBarInit_' . get_the_ID() ?>,
				);
			});
		});
	})(jQuery);
</script>
