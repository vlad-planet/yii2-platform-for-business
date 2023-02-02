const ButtonShowMore = {

	/** Объекты */
	ajax: null,

	/** Селекторы */
	selectors: {
		showMore:   '.js--show-more-btn',
		totalCount: '.topline__result__text'
	},

	/** Сообщения */
	messages: {
		Error:   'Произошла ошибка на сервере. Попробуйте позже.',
		Success: 'Успешно.'
	},

	/** Методы */
	methods: {

		/**
		 * Генерация url с get параметрами
		 * @author Vladislav Bashlykov
		 */
		createNewUrl: function(btn)
		{
			let amp      = '';
			let url      = '';
			let get      = '';
			let href     = btn.attr('href');
			let gets     = href.slice(href.indexOf('?') + 1).split('&');
			let view     = window.location.pathname;
			let num_page = parseInt(btn.attr('data-page_number'));
			let param_name = btn.attr('data-get_param_page');

			if (href.indexOf('?') !== -1)
			{
				for (var i = 0; i < gets.length; i++) {
					get = gets[i].split('=');

					if (param_name !== get[0]) {
						url = url + amp + get[0] + '=' + get[1];
						amp = '&';
					}
				}

				btn.attr('data-page_number', ++num_page);
			}

			btn.attr('href', view + '?' + url + amp + param_name + '=' + num_page);
		}
	},

	/** Обработчики */
	handlers() {

		/**
		 *  Запрос 'Показать Еще'
		 *  @author Vladislav Bashlykov
		 */
		$(document).on('click', ButtonShowMore.selectors.showMore, function() {

			let btn = $(this);


			// loader при выполнении ajax
			Loader.show();

			// отключить активность кнопки 'показать еще'
			$(this).css('pointer-events','none');

			// формирование url
			ButtonShowMore.methods.createNewUrl($(this));

			// отправить запрос
			ButtonShowMore.ajax = $.ajax({
				url: btn.attr('href'),
				dataType: 'html',
				context: this,

				success: function(data) {
					window.history.pushState(null, null, btn.attr('href'));

					// добавить записи в шаблон
					$('table.personal-style tbody').append(data);

					// включить активность кнопки 'показать еще'
					Loader.hide();
					btn.css('pointer-events','auto');

					// спрятать кнопку 'показать еще'
					if (parseInt(btn.attr('data-limit')) <= parseInt(btn.attr('data-page_number'))) {
						btn.remove();
					}
				},

				error: function(jqXHR, errMsg) {
					Loader.hide();
					alert(ButtonShowMore.messages.Error);
				}

			}).always(function () {
				ButtonShowMore.ajax = null;
			});

			return false;
		});

	},

	/** Инициализация скрипта */
	init() {
		ButtonShowMore.handlers();
	}
}

$(document).ready(function () {
	ButtonShowMore.init();
});