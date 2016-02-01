<header>   
    <h1>Авторизация</h1>
</header>
 <div class="login-content row">
    <div class="col-md-12">
        <form action="" onsubmit="Handy.login(this);return false;" id="login-form">
        	<div class="row">
        		<div class="col-md-6 col-sm-6">
        			<div class="field">
        				<label for=""><a href="/user?register">Регистрация</a></label>
        				<input type="text" name="login" placeholder="Логин">
        			</div>
        			<div class="field">
        				<label for=""><a href="user?pass-recover">Забыли свой пароль?</a></label>
        				<input type="password" name="password" placeholder="Пароль">
        			</div>
        			<div class="field row">
        				<div class="col-md-6 col-sm-6 col-xs-6 text-left">
        					<input type="checkbox" name="remember" value="Y" placeholder="">
        					<span>Запомнить</span>
        				</div>
        				<div class="col-md-6 col-sm-6 col-xs-6">
        					<button id="login-btn">ВХОД</button>
        				</div>
        			</div>
        			
        		</div>
        		<div class="col-md-6 col-sm-6">
        			<h4>ИЛИ ВОЙДИТЕ С ПОМОЩЬЮ:</h4>

        			<?=MQ_Socials::login()?>		  

        			<p class="social-login-message">
        				Используйте свой аккаунт в социальной сети для входа на сайт
        			</p>
        			<div id="errors_area"></div>
        		</div>
        	</div>	
        	
    	</form>	
    </div>
</div>