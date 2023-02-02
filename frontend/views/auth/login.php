<?php

use frontend\controllers\AuthController;
use frontend\models\auth\AuthForm;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model AuthForm */
/* @var $this View */
/* @var $form ActiveForm */
?>
<div class="popup popup__auth">
	<div class="popup__box">
		<div class="popup__box_close">
			<button class="icon js--close-popup" type=""><i class="i i-times"></i>
			</button>
		</div>
		<div class="popup__box_body small">
			<div class="popup__box_content">
				<form action="#" method="POST">
					<div class="popup_title">Вход</div>
					<div class="groupmaterial text">
						<input type="text" placeholder="Email или телефон" name="" id="" />
					</div>
					<div class="groupmaterial password">
						<input type="password" placeholder="Пароль" name="" id="" />
					</div>
					<div class="popup_footer_auth">
						<div class="groupmaterial checkbox">
							<label for="ch">Запомнить меня</label>
							<input type="checkbox" name="" id="ch" />
							<div class="square"><i class="i i-check-solid"></i></div>
							<label for="ch"></label>
						</div>
						<button class="standart js--open-remider" type="">Забыли пароль?</button>
					</div>
					<div class="popup_footer_btn">
						<button class="auth" type="submit">Войти</button>
					</div>
				</form>
			</div>
			<div class="popup__box_content social">
				<div class="popup_small_title"><span>Войти через</span></div>
				<ul class="auth_social">
					<li><a href="#" title="Одноклассники" rel="nofollow"><i class="i i-od"></i></a></li>
					<li><a href="#" title="Вконтакте" rel="nofollow"><i class="i i-vk"></i></a></li>
					<li><a href="#" title="Google Plus" rel="nofollow"><i class="i i-google"></i></a></li>
					<li><a href="#" title="Facebook" rel="nofollow"><i class="i i-fb"></i></a></li>
				</ul>
			</div>
			<div class="popup__box_footer">
				<button class="reg js--open-reg" type="">Зарегистироваться</button>
			</div>
		</div>
	</div>
</div>
