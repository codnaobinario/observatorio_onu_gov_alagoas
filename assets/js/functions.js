const $ = jQuery;

const loadChart = {
	datasetsNew: {},
	datasetsBarInit: {},
	clearData: function (myChartLine, myChartBar, datasetInitLine, indicador_id, color, datasetBarInit, labelsBarInit) {
		myChartLine.data.datasets = [datasetInitLine];
		myChartLine.update();

		myChartBar.data.datasets[0].backgroundColor = [color];
		myChartBar.data.datasets[0].borderColor = [color];
		myChartBar.data.datasets[0].data = datasetBarInit;
		myChartBar.data.labels = labelsBarInit;
		myChartBar.options.scales.y.title.text = '% de Municipios';
		myChartBar.update();

		$('#indicador-chart-desc').html('Valores relativos nos Municípios Alagoanos');

		$(`#indicador-chart-position-${indicador_id}`)
			.fadeOut();
	},
	addData: function (chart, label, data) {

	},
	updateLine: async function (
		myChartLine,
		myChartBar,
		datasetInitLine = {},
		label,
		slug,
		indicador_id,
		year,
		color,
		type,
		datasetBarInit,
		labelsBarInit,
	) {
		if (!slug) {
			this.clearData(myChartLine, myChartBar, datasetInitLine, indicador_id, color, datasetBarInit, labelsBarInit);
			return false;
		}

		const getResponse = await this.ajax('preview_indicador_chart_line', indicador_id, slug, year, color, type);
		// console.log(getResponse);

		this.datasetsLineNew = {
			label,
			data: getResponse.args.data,
			backgroundColor: [
				'rgba(64, 84, 178, 1)',
			],
			borderColor: [
				'rgba(64, 84, 178, 1)',
			],
			borderWidth: 4,
			tension: 0.1,
			spanGaps: true,
		};

		const datasetLine = [];
		datasetLine.push(datasetInitLine);
		datasetLine.push(this.datasetsLineNew);

		myChartLine.data.datasets = datasetLine.reverse();
		myChartLine.update();

		myChartBar.data.labels = getResponse.chartBar.labels;
		myChartBar.data.datasets[0].data = getResponse.chartBar.datasets;
		myChartBar.data.datasets[0].backgroundColor = getResponse.chartBar.colors;
		myChartBar.data.datasets[0].borderColor = getResponse.chartBar.colors;

		if (type === 'municipios') {
			myChartBar.options.scales.y.title.text = '% de Municipios';
			myChartBar.update();

			$(`#indicador-chart-position-${indicador_id}`)
				.html(`<span class="featured">${getResponse.chartBar.name}</span>`)
				.append(`&nbsp;<span>está em</span>`)
				.append(`&nbsp;<span class="featured">${getResponse.chartBar.position}º</span>`)
				.append(`&nbsp;<span>lugar entre os</span>`)
				.append(`&nbsp;<span class="featured">${getResponse.chartBar.qty}</span>`)
				.append(`&nbsp;<span>Municípios Alagoanos com informações do indicador.</span>`)
				.fadeIn();

			$('#indicador-chart-desc').html('Valores relativos nos Municípios Alagoanos');
		}

		if (type === 'regiao') {
			myChartBar.options.scales.y.title.text = '% de Regiões';
			myChartBar.update();

			$(`#indicador-chart-position-${indicador_id}`)
				.html(`<span class="featured">${getResponse.chartBar.name}</span>`)
				.append(`&nbsp;<span>está em</span>`)
				.append(`&nbsp;<span class="featured">${getResponse.chartBar.position}º</span>`)
				.append(`&nbsp;<span>lugar entre as Regiões Administrativas do Estado de Alagoas.</span>`)
				.fadeIn();
		}

		$('#indicador-chart-desc').html('Valores relativos nas Regiões Alagoanos');
	},
	ajax: async function (action, indicador_id, slug, year, color, type) {
		const data = {
			action: `${obs_options_object.obs_prefix}${action}`,
			indicador_id,
			slug,
			year,
			color,
			type,
		};

		const resp = $.ajax({
			type: "POST",
			url: obs_options_object.ajaxurl,
			data: data,
			dataType: "json",
			beforeSend: function () {
				// loadBlock.add(form);
			},
			complete: function () {
				// loadBlock.remove();
			},
			success: function (response) {
				// console.log(response);
				if (response.status === 'success') {
					return response;
				}

				if (response.status === 'error') {

				}

			},
			error: function (err) {

			}
		});

		return resp;
	}
};

const downloadData = {
	indicador: async function (btn) {
		const indicador_id = btn.attr('data-indicador-id');
		const action = 'download_indicador';
		const resp = await this.ajax(action, indicador_id);
		const workSheet = XLSX.utils.json_to_sheet(resp.xlsx);

		var wb = XLSX.utils.book_new();

		XLSX.utils.book_append_sheet(wb, workSheet);

		XLSX.writeFile(wb, `${resp.title}.xlsx`);
	},
	all: async function (btn) {
		const btn_txt_old = btn.find('.btn-text').html();
		const btn_icon_old = btn.find('.btn-icon').html();
		btn.children('button').attr('disabled', true).find('.btn-text').html('Aguarde...');
		btn.children('button').find('.btn-icon').html('<i aria-hidden="true" class="fas fa-spinner fa-spin"></i>');

		const action = 'dados_abertos_indicadores';

		const resp = await this.ajax(action);

		var wb = XLSX.utils.book_new();

		for (let i = 0; i < resp.indicadores.length; i += 1) {
			const indicador_id = resp.indicadores[i];
			const action_indicador = 'download_indicador';
			const resp_indicador = await this.ajax(action_indicador, indicador_id);

			const workSheet = XLSX.utils.json_to_sheet(resp_indicador.xlsx);
			XLSX.utils.book_append_sheet(wb, workSheet, `${resp_indicador.arquivo}`);
		}

		await XLSX.writeFile(wb, `Observatório - Dados Abertos.xlsx`);

		btn.children('button').attr('disabled', false).find('.btn-text').text(btn_txt_old);
		btn.children('button').find('.btn-icon').html(btn_icon_old);

	},
	ajax: async function (action, indicador_id = null) {
		const data = {
			action: `${obs_options_object.obs_prefix}${action}`,
		};

		if (indicador_id) {
			data.indicador_id = indicador_id;
		}

		const resp = $.ajax({
			type: "POST",
			url: obs_options_object.ajaxurl,
			data: data,
			dataType: "json",
			beforeSend: function () {
				// loadBlock.add(form);
			},
			complete: function () {
				// loadBlock.remove();
			},
			success: function (response) {
				// console.log(response);
				if (response.status === 'success') {
					return response;
				}

				if (response.status === 'error') {

				}

			},
			error: function (err) {

			}
		});

		return resp;
	}
};

const Forms = {
	clear: function (btn) {
		const form = btn.closest('form');
		const link = form.attr('data-permalink');

		$(form).find('select, input').each((i, el) => {
			$(el).val('');
		});

		window.location.href = `${link}${filterGet}`;
	},
	submit: function (btn) {
		const form = btn.closest('form');
		const link = form.attr('data-permalink');
		let gets = [];

		form.find('select').each((i, el) => {
			if ($(el).val()) {
				gets[`${$(el).attr('name')}`] = $(el).val();
			}
		});

		if (!gets) return false;

		let filterGet = '?';
		Object.entries(gets).map((el) => {
			filterGet += `${el[0]}=${el[1]}&`;
		});

		if (filterGet === '?') {
			filterGet = '';
		}

		filterGet = filterGet.replace(/&$/, '');
		window.location.href = `${link}${filterGet}`;
	}
};
