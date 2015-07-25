<?php
/*
Plugin Name: Simple Site Settings
Version: 1.0
Description: Plugin creates very basic functionality of custom site settings. 
Author: Alex Petlenko
Site: http://massique.com
*/

$reg_options = array(
    'phonefax1', 
    'email1', 
    'phonefax2', 
    'email2', 
    'address1', 
    'email_get_mail'
  );

$options = array(

    Array('type'  => 'text',      'value'  => '1ый набор полей ( Пресс-центр, схема проезда, публикации СМИ)'),
    Array('type'  => 'phonefax1', 'value'  => 'Телефон/факс'),
    Array('type'  => 'email1',    'value'  => 'Электронная почта'),
    Array('type'  => 'br'),
    Array('type'  => 'br'),
    Array('type'  => 'text',      'value'  => '2ой набор полей ( Архив новостей)'),
    Array('type'  => 'phonefax2', 'value'  => 'Телефон/факс'),
    Array('type'  => 'email2',    'value'  => 'Электронная почта'),
    Array('type'  => 'br'),
    Array('type'  => 'br'),
    Array('type'  => 'text',      'value'  => 'Общие настройки'),
    Array('type'  => 'address1','field_type'=>'textarea',    'value'  => 'Почтовый адрес для СМИ'),
    Array('type'  => 'email_get_mail','field_type'=>'input',    'value'  => 'Почтовый адрес для получения извещений WordPress')
  );

add_action('admin_menu', 'sss_menu');

function sss_menu() {

  add_menu_page('Site Settings', 'Настройки сайта', 'administrator', __FILE__, 'site_settings_page',plugins_url('/images/icon.png', __FILE__));
  add_action( 'admin_init', 'register_settings' );
}


function register_settings() {
  global $reg_options;
  foreach ($reg_options as $value) {
    register_setting( 'site-settings-group', $value );
  }  
}


function site_settings_page() {

  global $options;
?>
<div class="wrap">
<h2>Настройки сайта ФАУ «Главгосэкспертиза России»</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'site-settings-group' ); ?>
    <?php do_settings_sections( 'site-settings-group' );?>
  <table class="site-settings">
    <? foreach($options as $arOption){

      if($arOption['type'] == 'br'){

        ?><tr><td colspan="2"><br></td></tr><?
        continue;
      }

      if($arOption['type'] == 'text'){

        ?><tr><td colspan="2"><?=$arOption['value']?></td></tr><?
        continue;
      }

      ?>
      <tr valign="top">
          <td>
            <strong><?=$arOption['value']?></strong>
          </td>         
          <td>
          	<? if($arOption['field_type'] == 'textarea'){?>
				 <textarea type="text" name="<?=$arOption['type']?>"><?=get_option($arOption['type'])?></textarea>	
          	<?}else{?>
            <input type="text" name="<?=$arOption['type']?>" value="<?=get_option($arOption['type'])?>" />
            <?}?>
          </td>
        </tr>
    <?}?> 
    </table>
    <?php submit_button(); ?>

</form>
</div>
<style>
  .site-settings td{
    vertical-align: middle;
  }
</style>
<?php } ?>