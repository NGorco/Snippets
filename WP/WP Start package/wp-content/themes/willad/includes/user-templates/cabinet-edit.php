<? wp_enqueue_script('user-scripts', TPL . "/assets/js/template-user.js",array('jquery'), '',true );?>
<header>   
    <h1>Редактирование профиля</h1>
</header>
<div class="login-content row">
    <form action="/user?cabinet-edit" method="post" enctype="multipart/form-data" class="register-end-1">
    <input type="hidden" name="cabinet-edit">
    <div class="col-md-12">
        <? $user_id = get_current_user_id();?>
        <div class="row">
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
                    <input type="text" required value="<?=get_user_meta( $user_id, 'first_name', true );?>" required name="user[first_name]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    <span>*</span>Фамилия
                </div>
                <div class="col-md-8 value">
                    <input type="text" required value="<?=get_user_meta( $user_id, 'last_name', true );?>" required name="user[last_name]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    <span>*</span>E-mail
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'custom_email', true );?>" required name="user[custom_email]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Пол
                </div>
                <div class="col-md-8 value">
                    <? $gender = get_user_meta( $user_id, 'gender', true );?>

                    <input type="radio" name="user[gender]" <?=($gender == 'M' ? "checked=checked" : "")?> value="M" id="gender_m"><label for="gender_m">Мужчина</label>
                    <input type="radio" name="user[gender]" <?=($gender == 'F' ? "checked=checked" : "")?> value="F" id="gender_f"><label for="gender_f">Женщина</label>
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Дата рождения
                </div>
                <div class="col-md-8 value">
                    <input type="date" value="<?=get_user_meta( $user_id, 'birthdate', true );?>" name="user[birthdate]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Страна
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'country', true );?>" name="user[country]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Город
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'city', true );?>" name="user[city]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Компания
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'company', true );?>" name="user[company]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Должность
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'role', true );?>" name="user[role]">
                </div>
            </div>
            <div class="field_container">
                <div class="col-md-4 c_label">
                    Бизнес интересы
                </div>
                <div class="col-md-8 value">
                    <textarea name="user[business]"><?=get_user_meta( $user_id, 'business', true );?></textarea>
                </div>
            </div>                                      
            <div class="field_container">
                <div class="col-md-4 c_label">
                    
                </div>
                <div class="col-md-8 value">
                    <input type="submit" name="continue_step_1" value="Сохранить данные">
                </div>
            </div>    
        </div>
        
        <div class="row social-fields">
            <div class="field_container">
                <div class="fb col-md-4 c_label">
                    Facebook<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_fb', true );?>" name="user[social_fb]">
                </div>
            </div>
            <div class="field_container">
                <div class="tw col-md-4 c_label">
                    Twitter<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_tw', true );?>" name="user[social_tw]">
                </div>
            </div>
            <div class="field_container">
                <div class="vk col-md-4 c_label">
                    Vkontakte<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_vk', true );?>" name="user[social_vk]">
                </div>
            </div>
            <div class="field_container">
                <div class="vm col-md-4 c_label">
                    Vimeo<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_vm', true );?>" name="user[social_vm]">
                </div>
            </div>
            <div class="field_container">
                <div class="lj col-md-4 c_label">
                    LiveJournal<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_lj', true );?>" name="user[social_lj]">
                </div>
            </div>

            <div class="field_container">
                <div class="li col-md-4 c_label">
                    LinkedIn<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'social_li', true );?>" name="user[social_li]">
                </div>
            </div>
            <div class="field_container">
                <div class="yt col-md-4 c_label">
                    Youtube<span class="soc-icon"></span>
                </div>
                <div class="col-md-8 value">
                    <input type="text" value="<?=get_user_meta( $user_id, 'soical_yt', true );?>" name="user[soical_yt]">
                </div>
            </div>
        </div>
        <br>
        <div class="row">       
        </div>
        <? $all_cats = get_terms('category',array('exclude' => array(13,14)));
            $activeCats = FSSubscribeCore::userSubscibeList();
           
        ?>
        <ul class="subscribes">
            <? foreach($all_cats as $cat)
            {
                $active = 'selected';

                if(!in_array($cat->term_id, $activeCats))
                {
                    $active = '';
                }
                ?>
                <li class="<?=$active?>">
                    <input type="checkbox" <?=($active != '' ? "checked=checked" : '')?> class="subscribe" id="sbscr_<?=$cat->term_id?>" name="subscribe[<?=$cat->term_id?>]" value="Y">
                    <span class="check-icon">
                        <span class="glyphicon-ok glyphicon"></span>      
                    </span>
                    <label for="sbscr_<?=$cat->term_id?>"><?=$cat->name?></label>
                </li>
            <?}?>
        </ul>
         <div class="text-right col-md-6">
            <input type="submit" value="ПРОДОЛЖИТЬ" class="submit-btn">
        </div>
    </div>
    </form>
</div>