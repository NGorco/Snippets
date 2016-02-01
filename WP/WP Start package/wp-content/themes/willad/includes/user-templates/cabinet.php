<header>
    <? CUtil::breadcrumb()?>
    
    <h1><? the_title()?></h1>
</header>
<div class="login-content row">
    <div class="col-md-12">  
    <? $user_id = get_current_user_id();?>  	
    	<div class="row vertical-align-middle">
        	<div class="img col-md-3">
        		<? $av_id = get_user_meta( $user_id, 'avatar_id',true );
            
                    $url = wp_get_attachment_image( $av_id, 'medium' , "","id=avatar_preview");
                ?>
              
                <?if($url != ''){?>
                <?=$url?>
                <?}else{?>
                <img src="<?=TPL?>/images/dummy_avatar.jpg" id="avatar_preview" width="150" alt="">
                <?}?>
        	</div>
			<div class="col-md-4">
            <?get_currentuserinfo(); ?>
				<p class="login"><?=$current_user->user_login?></p>
			</div>
            <div class="col-md-5">
                <input type="button"  onclick="window.location = '/user?cabinet-edit'" class="submit-btn edit-user-info-top" value="Редактировать профиль">
            </div>
    	</div>
        <br>
    	<p class="cabinet-warn">Личные данные</p>
    	<div class="row cabinet-fields">
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Имя
    			</div>                
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'first_name', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Фамилия
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'last_name', true );?>
    			</div>
    		</div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    E-mail
                </div>
                <div class="col-md-8 value user-cab">
                    <?=get_user_meta( $user_id, 'custom_email', true );?>
                </div>
            </div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Пол
    			</div>
    			<div class="col-md-8 value user-cab">
    				<? $gender = get_user_meta( $user_id, 'gender', true );?>
                    <? if($gender == 'M'){?>
                    Мужчина
                    <?}else{?>
                    Женщина
                    <?}?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Дата рождения
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'birthdate', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Страна
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'country', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Город
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'city', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Компания
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'company', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Должность
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'role', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="col-md-4 c_label">
    				Бизнес интересы
    			</div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'business', true );?>
    			</div>
    		</div>	
    	</div>
        <br>
    	<br>
        <div class="divider"></div>
<br>
        <br>
        <p class="cabinet-warn">Социальные сети</p>
    	<div class="row cabinet-social-fields">
    		<div class="field_container">
    			<div class="fb col-md-4 c_label">
                    Facebook<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_fb', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="tw col-md-4 c_label">
                    Twitter<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_tw', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="vk col-md-4 c_label">
                    Vkontakte<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_vk', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="vm col-md-4 c_label">
                    Vimeo<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_vm', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="lj col-md-4 c_label">
                    LiveJournal<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_lj', true );?>
    			</div>
    		</div>

    		<div class="field_container">
    			<div class="li col-md-4 c_label">
                    LinkedIn<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_li', true );?>
    			</div>
    		</div>
    		<div class="field_container">
    			<div class="yt col-md-4 c_label">
                    Youtube<span class="soc-icon"></span>
                </div>
    			<div class="col-md-8 value user-cab">
    				<?=get_user_meta( $user_id, 'social_yt', true );?>
    			</div>
    		</div>
    </div>
<br>
<br>
    <div class="divider"></div>
    <br>
<br>
    <p class="cabinet-warn">ПОДПИСКА НА РУБРИКИ</p>
    <ul class="subscribes cabinet">
        <? $subscribes = FSSubscribeCore::userSubscibeList();     
        foreach($subscribes as $cat_id)
        {
            $cat = get_the_category_by_ID($cat_id);         
        ?>
        <li class="selected">            
            <span class="check-icon">
                <span class="glyphicon-ok glyphicon"></span>      
            </span>
            <label for="sbscr_2"><?=$cat?></label>
        </li>                   
        <?}?>
    </ul>

    <div class="overflow-hidden">
        <input type="button" class="submit-btn" onclick="window.location = '/user?cabinet-edit'" value="Редактировать профиль">
    </div>
</div>