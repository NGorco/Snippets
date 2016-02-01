<? wp_enqueue_script('user-scripts', TPL . "/assets/js/template-user.js",array('jquery'), '',true );?>
<header>   
    <h1>Завершение регистрации</h1>
</header>
<div class="login-content row">
    <form action="/" method="POST" class="register-end-1">
    <div class="col-md-12">
    	<div class="row steps">
    		<div class="col-md-6 col-sm-6 col-xs-6">
    			<h3>ШАГ 1</h3>
    			<h4>
    				Заполнение анкеты
    			</h4>
    		</div>
			<div class="col-md-6 col-sm-6 col-xs-6 active-step">
    			<h3>ШАГ 2</h3>
    			<h4>
    				Выбор интересующих рубрик
    			</h4>
    		</div>
    	</div>
        <br>
    	<input type="button" value="Выбрать всё" class="checkall hollow-btn">
    	<? $all_cats = get_terms('category',array('exclude' => array(13,14)));?>
    	<ul class="subscribes">
    		<? foreach($all_cats as $cat){?>
        		<li>
        			<input type="checkbox" class="subscribe" id="sbscr_<?=$cat->term_id?>" name="subscribe[<?=$cat->term_id?>]" value="Y">
        			<span class="check-icon">
                        <span class="glyphicon-ok glyphicon"></span>      
                    </span>
        			<label for="sbscr_<?=$cat->term_id?>"><?=$cat->name?></label>
        		</li>
    		<?}?>
    	</ul>
        <br>
        <br>
        <div class="row">
        <div class="col-md-7">
            <input type="submit" value="ЗАВЕРШИТЬ РЕГИСТРАЦИЮ" class="submit-btn">
        </div>
        </div>    	
    </div>
    <input type="hidden" name="end-register-2" value="Y">
    </form>
</div>