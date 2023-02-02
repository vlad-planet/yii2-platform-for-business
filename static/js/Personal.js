const Personal = {

	/** Объекты */
	ajax: null,

	/** Селекторы */
	selectors: {
		profile_form:   '.js--profile_form'
	},

	/** Сообщения */
	messages: {
		Error:   'Произошла ошибка на сервере. Попробуйте позже.',
		Success: 'Успешно.'
	},

	/** Методы */
	methods: {},

	/** Обработчики */
	handlers() {

		/**
		 * Функционал формы 'Профиль персоны'
		 * @author Vladislav Bashlykov
		 */
		$(document).on('click', 'input[name=passport_is_same_address]', function () {

			if ($(this).is(':checked')) {
				$resident_address = $('input[name=passport_resident_address]').val();
				$('input[name=passport_fact_resident_address]').val($resident_address);
			} else {
				$('input[name=passport_fact_resident_address]').val('');
			}

		});

	},

	/** Инициализация скрипта */
	init() {
		Personal.handlers();
	}
}

$(document).ready(function () {
	Personal.init();
});