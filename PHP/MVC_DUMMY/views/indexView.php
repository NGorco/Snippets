<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>QuickDesk Beta</title>
	<link rel="stylesheet" type="text/css" href="/includes/all.css" />
	<link rel="stylesheet" type="text/css" href="/includes/style.css" />
	<link rel="stylesheet" type="text/css" href="/includes/custom.css" />
	<? getHeader();?>
	<link rel="stylesheet" type="text/css" href="/includes/main_style.css" />
	<script type="text/javascript" src="/includes/js/myscript.js"></script> 
	<script type="text/javascript" src="/includes/js/io.js"></script> 
</head>
<body>
<div class="cover"></div>
<style type="text/css">

</style>
<div class="fixed">
<div class="logo">
            <a href="/"><img src="/includes/images/qdesk_logo_light.png" alt="" style="
    position: relative;
   top: 25px;
left: -15px;
"><p class="logop"><!--Quick<br/><span>Desk</span>--></p>
</a>
        </div><ul class="enter">
				<li class="reg"><a class="open-popup" href="#">Регистрация</a></li>
				<li class="enter-link "><a class="open-popup" href="#">Вход</a></li>
			</ul>
</div>
<div class="hover_tracer about_trace">
<a onclick="infoPage('/info/about.html')" class="circle white about"><img src="/includes/images/massique.png" alt="" /><p>О проекте</p></a>
</div>
<div id="info"></div>
<div id="info_back"></div>

	<div class="light-box" id="light-box-reg">
	<a class="close" href="#">close</a>
		<div class="center-box">
			<div class="forms">
				<form id="register-form" action="#">
					<fieldset>
						<h2>Помни с QuickDesk</h2>
						<h3>Зарегистрируйся, и ты сможешь начать использовать сервис QuickDesk</h3>
						<ul>
							<li>
								<label for="field43">Электронная почта</label>
								<input id="field43" placeholder="Электронная почта" class="text" type="text" value=""/>
								<em>Не верно введена электронная почта</em>
							</li>
						</ul>
						<input type="button" class="button" onclick="register()" value="Зарегистрироваться"/>
						<p>Уже есть аккаунт QuickDesk? <a class="open-popup-enter" href="#">Войти</a></p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<div class="light-box" id="light-box-authorization">
		<a class="close" href="#">close</a>
		<div class="center-box">
			<div class="forms">
				<form id="authorization-form" action="#">
					<fieldset>
						<h2>Вход в QuickDesk</h2>
						<ul class="entet-login">
							<li>
								<label for="field43e">Электронная почта</label>
								<input id="field43e" class="text" type="text" placeholder="Электронная почта" value=""/>
								<em>Неверный логин или пароль.</em>
							</li>
							<li>
								<label for="field45e">Пароль</label>
								<input id="field45e" class="text" type="password" placeholder="Пароль" value=""/>
							</li>
							<li class="remember-row">
								<input id="field3z" class="checkbox" type="checkbox"/>
								<label class="txt" for="field3z">Запомнить меня</label>
							</li>
						</ul>
						<input type="button" class="button" onclick="login()" value="Войти"/>
						<div class="row-funk">
							<a href="#" class="recovery">Восстановить пароль</a>
							<a href="#" class="sss">Зарегистрироваться</a>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
		<div class="light-box" id="light-box-recovery">
		<a class="close" href="#">close</a>
		<div class="center-box">
			<div class="forms">
				<form id="recover-form" action="#">
					<fieldset>
						<h2>Восстановление пароля</h2>
						<h3>Для восстановления пароля введите свой e-mail, на который будет выслана ссылка с подтверждением. </h3>
						<ul>
							<li>
								<label for="field43e6">Электронная почта</label>
								<input id="field43e6" class="text" type="text" placeholder="Электронная почта" value=""/>
							</li>
						</ul>
						<input type="button" class="button" onclick="recover()" value="Восстановить"/>
						<div class="row-funk">
							<a href="#" class="open-popup-enter" style="float: left;">Войти</a>
							<a href="#" class="sss">Зарегистрироваться</a>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<script type="text/javascript">

function infoPage(url){
$.get(url,function(data){
			if(data){
				$("#info").html(data).fadeIn();
			}
		})
}
</script>
	</body>
</html>