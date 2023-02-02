/**
 * Все формы, которые должны отправится аяксом на сервер и получить ответ
 */
const AjaxForms = {
	/**
	 * Отправка формы на сервер
	 * @constructor
	 */
	Request: function (form, reload = true) {
		Loader.show();
		let data =  $(form).serialize()

		/** если есть файлы в форме */
		if($(form).find("input[type='file']").length > 0){
			data = new FormData();
			$.each($(form).find("input[type='file']"), function(i, tag) {
				$.each($(tag)[0].files, function(i, file) {
					data.append(tag.name, file);
				});
			});

			let params = $(form).serializeArray();
			$.each(params, function (i, val) {
				data.append(val.name, val.value);
			});
		}

		$.ajax({
			url: $(form).prop('action'),
			data: data,
			type: $(form).prop('method'),
			processData: false,
			//contentType: false,
			success: function(response) {
				if (response.result === false) {
					$('.js-form_errors_container').show()
					AjaxForms.setErrorClass(form, response.errors)
					AjaxForms.ShowErrors(response.errors, $(form).find('.js-form_errors'));
				} else {
					if(true === reload){
						window.location.reload();
					}
				}
			}
		})
			.always(() => Loader.hide())
			.fail(() => Loader.error())
	},
	ShowErrors: function (errors, errorContainer) {
		$(errorContainer).html('');

		for (let i in errors) {
			$(errorContainer).append('<p>' + errors[i] + '</p>');
		}

		$(errorContainer).show();
	},
	setErrorClass: function (form, errors) {
		$(form).find('.error').removeClass('error')

		for (let value of Object.keys(errors)) {
			$(form).find(`[name="${value}"]`).addClass('error')
			$(form).find(`.select2[name="${value}"], .select2-multiselect[name="${value}"]`).next().addClass('error')
		}
	}
};