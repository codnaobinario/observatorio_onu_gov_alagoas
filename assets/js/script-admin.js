(function ($) {
	$(document).ready(function () {

		$('.maskYear').mask('9999');
		$('.select2').select2();

		$(document).on('click', '.btn-remove-tr', function () {
			lines.remove.tr($(this));
		}).on('click', '.add-value', function () {
			lines.add.tr($(this));
		});

		$(document).on('change', '.ods-change', function () {
			const desc = $(this).children('option:selected').attr('data-ods-desc');
			const odsValue = $(this).val();
			$('#ods-meta').val(desc);
			const imagePath = $('#img-preview-ods').attr('data-image-path');
			$('#img-preview-ods').attr('src', `${imagePath}SDG-${odsValue}.png`);
		});

		$(document).on('click', '.btn-upload-xls', function (e) {
			importXlsx.importMunicipiosRegioes($(this));
		}).on('click', '.btn-upload-xls-indicador', function (e) {
			importXlsx.importDataIndicadores($(this));
		}).on('click', '.btn-upload-xls-all', function (e) {
			importXlsx.importMatrizAll($(this));
		});

	});
})(jQuery);
