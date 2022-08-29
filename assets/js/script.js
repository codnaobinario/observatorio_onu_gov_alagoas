(function ($) {
	$(document).ready(function () {
		$('.select2').select2();

		$(document).on('click', '.download-indicador', function () {
			downloadData.indicador($(this));
		});

		$(document).on('click', '.clear-form', function (e) {
			e.preventDefault();
			Forms.clear($(this));
		}).on('click', '.btn-filter', function (e) {
			e.preventDefault(e);
			Forms.submit($(this));
		});

		$(document).on('click', '.share-indicador', function () {
			const btn = $(this);
			const indicador_id = btn.attr('data-indicador-id');
			const indicador_title = btn.attr('data-indicador-title');
			html2canvas(document.querySelector(`#indicador-card-${indicador_id}`)).then(canvas => {
				// $('#preview-download').html(canvas);
				const imageData = canvas.toDataURL('image/png');
				const newData = imageData.replace(/^data:image\/png/, 'data:application/octet-stream');

				var link = document.createElement('a');
				link.download = `${indicador_title}.png`;
				link.href = newData;
				link.click();
			});
		});

		$(document).on('click', '.dados-abertos', function () {
			downloadData.all($(this));
		});

		$(document).on('change', 'ul.navbar-nav select', function () {
			// console.log("Mudou");
		});

	});
})(jQuery);
