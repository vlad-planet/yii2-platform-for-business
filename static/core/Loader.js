const Loader = {
    show(){
        $('.js-loader').show();
    },
    hide(){
        $('.js-loader').hide();
    },
    error(){
        alert('Ой! На сервере произошла ошибка!Если это повторится, обратитесь к администратору');
    }
}