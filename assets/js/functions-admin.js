const $ = jQuery;


const lines = {
	remove: {
		tr: function (btn) {
			const tr = btn.closest('tr');
			tr.fadeOut(function () {
				tr.remove();
			});
		},
		li: function (btn) {
			const li = btn.closest('li');
			li.remove();
		}
	},
	add: {
		tr: function (btn) {
			const slug = btn.attr('data-municipio-slug');
			const year = $(`#${obs_options_object.obs_prefix}${slug}-ano`).val();
			const values = $(`#${obs_options_object.obs_prefix}${slug}-valor`).val();

			if (!year || !values) {
				alert('Preencha o ano e o valor');
				return false;
			}

			if ($(`input[name="municipio[${slug}][${year}][ano]"]`).length) {
				alert('ESTE ANO JÁ FOI INSERIDO');
				return false;
			}

			const tableBody = $(`#table-${slug}`).children('tbody');
			tableBody
				.append(`<tr id="${slug}-${year}"></tr>`)
				.children('tr:last-child')
				// .append(`<input type="hidden" name="municipio[${slug}][]" value="${year}" />`)
				.append(`<td><input type="text" name="municipio[${slug}][${year}][ano]" value="${year}" placeholder="Ano" class="maskYear" /></td>`)
				.append(`<td><input type="text" name="municipio[${slug}][${year}][value]" value="${values}" placeholder="Valor" /></td>`)
				.append('<td></td>')
				.children('td:last-child')
				.append('<button type="button" class="btn btn-danger btn-remove-tr">Remover</button>')
				.children('button')
				.append('<span class="dashicons dashicons-trash"></span>');

		},
		li: function (btn) {

		}
	},
};

const importXlsx = {
	fileJson: '',
	fileData: {},
	file: {},
	setInfosProgressBar: function (e, init = false) {
		const local = $('.infos-prograss-bar');
		if (init) local.text(`${e}`);
		if (!init) local.append(`\n${e}`);
		local.scrollTop(local[0].scrollHeight);
	},
	setImportStatus(status = '', msg = '') {
		const local = $('#import-status');
		if (status === 'error') {
			local.html(`<strong class="text-danger">Error: ${msg}</strong>`);
		} else if (status === 'success') {
			local.html(`<strong class="text-success">Success: ${msg}</strong>`);
		} else {
			local.html(`<strong class="">Status: ${msg}</strong>`);
		}
	},
	getFile: function () {
		this.file = $('#obs-file-import')[0].files[0];

		if (!this.file) {
			this.setImportStatus('error', 'Arquivo não selecionado.');
			return false;
		}


		const fileSize = (this.file.size / 1024).toFixed(2);

		this.setInfosProgressBar(`Arquivo: ${this.file.name}`);
		this.setInfosProgressBar(`Tamanho: ${fileSize} KB`);
	},
	xlsx_to_json: async function () {
		// const file = e.target.files[0];

		this.setInfosProgressBar('Lendo informações do arquivo');
		const data = await this.file.arrayBuffer();
		/* data is an ArrayBuffer */
		const workbook = XLSX.read(data);

		this.setInfosProgressBar('Montando envio');
		const result = {};
		workbook.SheetNames.forEach(function (sheetName) {
			const roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });
			if (roa.length) result[sheetName] = roa;
		});

		this.fileJson = JSON.stringify(result);
		this.fileData = result;

		this.setInfosProgressBar('Enviando dados');
	},
	importAjax: async function (action = '', atts, indicador = null, full = null) {
		const data = {
			action: `${obs_options_object.obs_prefix}${action}`,
			atts,
		};

		if (indicador) {
			data.indicador_id = indicador;
		}

		if (full) {
			data.full = full;
		}

		const response = $.ajax({
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
					importXlsx.setImportStatus('success', response.msg);
					importXlsx.setInfosProgressBar(response.msg);
				}

				if (response.status === 'error') {
					importXlsx.setImportStatus('error', response.msg);
					importXlsx.setInfosProgressBar(response.msg);
				}

			},
			error: function (err) {
				importXlsx.setImportStatus('error', 'Erro ao importar dados, contate o desenvolvedor.');
				importXlsx.setInfosProgressBar('Erro ao importar dados.');
			}
		});

		return response;
	},
	importMunicipiosRegioes: async function (btn) {
		this.setImportStatus(false, 'Importando');
		this.setInfosProgressBar('Iniciando importação', true);

		this.getFile();

		const action = $('#action-type').val();
		if (!action) {
			this.setImportStatus('error', 'Selecione uma função');
			return false;
		}

		if (!this.file) {
			this.setImportStatus('error', 'Nenhum arquivo selecionado');
			return false;
		}

		loadButton.load(btn, 'Aguarde...');

		await this.xlsx_to_json();
		await this.importAjax(action, this.fileData);

		loadButton.unload(btn, 'Enviar dados', 'dashicons dashicons-upload');
	},
	importDataIndicadores: async function (btn) {
		this.setImportStatus('', 'Importando');
		this.setInfosProgressBar('Iniciando importação', true);

		this.getFile();

		const action = $('#action-type').val();
		if (!action) {
			this.setImportStatus('error', 'Selecione uma função');
			return false;
		}

		if (!this.file) {
			this.setImportStatus('error', 'Nenhum arquivo selecionado');
			return false;
		}

		const indicador = $('#indicador').val();
		if (!indicador) {
			this.setImportStatus('error', 'Selecione um Indicador');
			return false;
		}

		loadButton.load(btn, 'Aguarde...');

		await this.xlsx_to_json();
		await this.importAjax(action, this.fileData, indicador);

		loadButton.unload(btn, 'Enviar dados', 'dashicons dashicons-upload');
	},
	importMatrizAll: async function (btn) {
		this.setImportStatus(false, 'Importando');
		this.setInfosProgressBar('Iniciando importação', true);

		this.getFile();

		const action = $('#action-type').val();
		if (!action) {
			this.setImportStatus('error', 'Selecione uma função');
			return false;
		}

		if (!this.file) {
			this.setImportStatus('error', 'Nenhum arquivo selecionado');
			return false;
		}

		loadButton.load(btn, 'Aguarde...');

		await this.xlsx_to_json();
		const response = await this.importAjax(action, this.fileData);

		console.log(response);
		this.importIndicadoresAll(response);

		loadButton.unload(btn, 'Enviar dados', 'dashicons dashicons-upload');
	},
	importIndicadoresAll: async function (response) {
		const files = response.arquivos;
		if (!files) return false;

		const arrayFiles = Object.keys(files);

		for (let x = 0; x < arrayFiles.length; x += 1) {
			const key = arrayFiles[x];
			console.log(files[key]);
			const filesIndicador = $('#obs-file-indicadores').get(0).files;
			// console.log(filesIndicador);
			const array_ = Object.values(filesIndicador);
			for (let i = 0; i < Object.values(array_).length; i += 1) {
				const f = array_[i];
				if (f.name === `${key}.xlsx`) {
					const data = await f.arrayBuffer();
					/* data is an ArrayBuffer */
					const workbook = XLSX.read(data);

					const result = {};
					workbook.SheetNames.forEach(function (sheetName) {
						const roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });
						if (roa.length) result[sheetName] = roa;
					});

					this.fileJson = JSON.stringify(result);
					this.fileData = result;
					console.log(f.name);
					console.log(result);
					this.setInfosProgressBar(`Inserindo arquivo ${f.name} no indicador ${files[key]}`);

					const insert = await this.importAjax('data_indicadores', this.fileData, files[key], 'true');

					console.log(insert);
				}
			}
		}
	}
};

const delay = function (delayInms) {
	return new Promise(resolve => {
		setTimeout(() => {
			resolve(2);
		}, delayInms);
	});
};

const loadButton = {
	load: function (btn, text = '') {
		btn
			.html('<span></span>')
			.children('span')
			.attr('class', 'spinner-border spinner-border-sm')
			.attr('role', 'status')
			.attr('aria-hidden', 'true');

		btn.append(text);

	},
	unload: function (btn, text = '', iconMyClass = '') {
		btn.html('<span></span>').children('span').attr('class', iconMyClass);
		btn.append(text);
	}
};
