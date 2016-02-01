<header>   
    <h1>Восстановление пароля</h1>
</header>
 <div class="login-content row">
    <div class="col-md-12">
        <form action="" onsubmit="Handy.recoverPass(this); return false;" id="login-form">
        	<div class="row">
        		<div class="col-md-6 col-sm-6">
        			<div class="field" style="height: 50px;">        				
        				<input type="email" required placeholder="Введите Ваш E-mail" name="email">
        			</div>        
                    <br> 		
        			<div class="field row">        				
        				<div class="col-md-12 col-sm-12 col-xs-12">
        					<button id="login-btn">НАПОМНИТЬ ПАРОЛЬ</button>
        				</div>
        			</div>
                    <br>  
        			<div class="field row">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left">                          
                            <a href="/user?register">Регистрация</a>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <a href="/user?login">Вход</a>
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