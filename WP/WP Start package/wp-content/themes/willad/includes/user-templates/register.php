<header>   
    <h1>Регистрация</h1>
</header>
<div class="login-content row">
    <div class="col-md-12">    	
        <form action="" onsubmit="Handy.registerUser(this); return false;" class="register" id="login-form">
        	<div class="row">
        		<div class="col-md-6 col-sm-6">
        			<div class="field">		                            				
        				<input type="text" required name="login" placeholder="Логин">
        			</div>
        			<div class="field">		                            				
        				<input type="password" required name="pass" placeholder="Пароль">
        			</div>
        			<div class="field">		                            				
        				<input type="password" required name="pass_two" placeholder="Подтвердите пароль">
        			</div>
        			<div class="field">		                            				
        				<input type="email" name="email" required placeholder="Email адрес">
        			</div>
        			<br>
        			<div class="field text-left">		                  
        				<img src="<?=TPL?>/images/cap-update.jpg" id="cap_gen" onclick="Handy.captcha(document.getElementById('cap'))" alt="">          				
        				<img src="/?method=captcha&AJAX_REQUEST=Y" id="cap" alt="">
        				<br>
        				<br>
        				<input type="text" name="cap" required placeholder="Код с картинки">
        			</div>
        			<div class="field row">
        				<div class="col-md-12 col-sm-12 col-xs-12">
        					<button id="login-btn">ЗАРЕГИСТРИРОВАТЬСЯ</button>
        				</div>
        			</div>
        			
        		</div>
        		<div class="col-md-6 col-sm-6">
        			<h4>ЗАРЕГИСТРИРУЙТЕСЬ С ПОМОЩЬЮ</h4>

        			<?=MQ_Socials::register()?>		  

        			<p class="social-login-message">
        				Используйте свой аккаунт в социальной сети для регистрации на сайте
        			</p>
        			<div id="errors_area"></div>	
        		</div>
        	</div>
    	</form>	
    </div>
</div>