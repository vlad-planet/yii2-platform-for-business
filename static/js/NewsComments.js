const NewsComments = {

    /** Селекторы */
    ajax: null,
    selectors: {
        comments:   '.js--open-new-comment',
        form:       '.js--new-comment-form',
        events:     'disable-events'
    },

    messages: {
        Error:   'Произошла ошибка на сервере. Попробуйте позже.',
        Success: 'Ваш комментарий появится после модерации.'
    },

    /** Обработчики */
    handlers() {

        /**
         *  Отображение коментариев соотвествующих новостит
         *  @author Vladislav Bashlykov
         */
        $(document).on('click', NewsComments.selectors.comments + ':not(.'+NewsComments.selectors.events+')', function() {

            id = $(this).data('id_news');
            $(this).addClass(NewsComments.selectors.events);

            NewsComments.ajax = $.ajax({
                url:        $(this).data('url_get_comments'),
                dataType:   'html',
                context:    this,

                success:    function(data) {
                   $(`div[data-id_news_comments='${id}'`).html(data);
                },

                error: function(jqXHR, errMsg) {
                    alert(NewsComments.messages.Error);
                }

            }).always(function () {
                NewsComments.ajax = null;
            });

        });
        
        /**
         *  Форма добавления комментария к новости
         *  @author Vladislav Bashlykov
         */
        $(document).on('submit', NewsComments.selectors.form, function() {

			Loader.show();
            NewsComments.ajax = $.ajax({
                url:        $(this).prop('action'),
                data:       $(this).serialize(),
                type:       $(this).prop('method'),
                context:    this,

                success:    function (response) {
	                Loader.hide();
                    if (response.result === true) {
                        Alert.show(NewsComments.messages.Success);
                        $(this).parent().html(NewsComments.messages.Success);
                    } else {
	                    Alert.show(NewsComments.messages.Error);
                    }
                },

                error: function(jqXHR, errMsg) {
	                Loader.hide();
	                Alert.show(NewsComments.messages.Error);
                }

            }).always(function () {
                NewsComments.ajax = null;
            });

            $(this).find('textarea').val('');

            return false;
        });

    },

    /** Инициализация скрипта */
    init() {
        NewsComments.handlers();
    }
}

$(document).ready(function () {
	NewsComments.init();
});