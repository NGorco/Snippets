<? wp_enqueue_script('user-scripts', TPL . "/assets/js/template-user.js",array('jquery'), '',true );?>
<header>   
    <h1>Завершение регистрации</h1>
</header>
<div class="login-content row">
    <form action="/user?end-register-2" method="post" enctype="multipart/form-data" class="register-end-1">
    <input type="hidden" name="register_end_1">
    <div class="col-md-12">
    	<div class="row steps">
    		<div class="col-md-6 col-sm-6 col-xs-6 active-step">
    			<h3>ШАГ 1</h3>
    			<h4>
    				Заполнение анкеты
    			</h4>
    		</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
    			<h3>ШАГ 2</h3>
    			<h4>
    				Выбор интересующих рубрик
    			</h4>
    		</div>
    	</div>
    	<div class="row">
        	<div class="img col-md-3">
        		<img src="<?=TPL?>/images/dummy_avatar.jpg" id="avatar_preview" width="150" alt="">
        	</div>
			<div class="col-md-7 text-center">
				<h5 class="file-uplod_warn">
					Выберите изображение на вашем компьютере
				</h5>
				<input type="file" name="avatar" id="user-avatar">
			</div>
    	</div>
    	<p class="fill_warn"><span>*</span> Обязательные для заполнения поля</p>
    	<div class="row fields">
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				<span>*</span>Имя
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" required name="user[first_name]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				<span>*</span>Фамилия
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" required name="user[last_name]">
    			</div>
    		</div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    E-mail
                </div>
                <div class="col-md-8 value">
                    <input type="text" name="user[custom_email]">
                </div>
            </div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Пол
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[gender]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Дата рождения
    			</div>
    			<div class="col-md-8 value">
    				<input type="date" name="user[birthdate]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Страна
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[country]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Город
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[city]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Компания
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[company]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Должность
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[role]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Бизнес интересы
    			</div>
    			<div class="col-md-8 value">
    				<textarea name="user[business]"></textarea>
    			</div>
    		</div>	                            		
    	</div>
    	<br>
    	<div class="row social-fields">
    		<div class="field_container">
    			<div class="fb col-md-4 c_label">
    				Facebook<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_fb]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="tw col-md-4 c_label">
    				Twitter<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_tw]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="vk col-md-4 c_label">
    				Vkontakte<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_vk]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="vm col-md-4 c_label">
    				Vimeo<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_vm]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="lj col-md-4 c_label">
    				LiveJournal<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_lj]">
    			</div>
    		</div>

    		<div class="field_container">
    			<div class="li col-md-4 c_label">
    				LinkedIn<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_li]">
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="yt col-md-4 c_label">
    				Youtube<span class="soc-icon"></span>
    			</div>
    			<div class="col-md-8 value">
    				<input type="text" name="user[social_yt]">
    			</div>
    		</div>
        </div>
        <br>
        <div class="row">
        <div class="text-right col-md-6">
            <input type="submit" value="ПРОДОЛЖИТЬ" class="submit-btn">
        </div>
        </div>
    </div>
    </form>
</div>