const Alert = {
	show(text){
		$('.js-alert_title').text(text);
		$('.js-alert').addClass('show');
	},
	hide(){
		$('.js-alert_title').text('');
		$('.js-alert').removeClass('show');
	}
}