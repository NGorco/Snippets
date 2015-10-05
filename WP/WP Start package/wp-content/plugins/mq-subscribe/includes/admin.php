<?php


$FSSubscribeCore = new FSSubscribeCore();
add_action('admin_menu', 'fs_subs_menu');

function fs_subs_menu() {

add_menu_page('Новостная рассылка', 'Список подписчиков', 'administrator', __FILE__, 'fs_subs_page');
//add_menu_page('FSSubscribe', 'Рассылка новостей', 'administrator', __FILE__, 'site_settings_page');
 // add_action( 'admin_init', 'register_settings' );
}

if(isset($_POST['email'])){

	$FSSubscribeCore->add($_POST['email']);
}

if(isset($_POST['remove'])){

	$FSSubscribeCore->remove($_POST['ids']);
}

add_action("wp_ajax_fs_subscribe", "user_subscribe", 1); 	

function user_subscribe(){

	if(filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){

	global $wpdb;
	$row = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . TABLE_NAME . ' WHERE email = "' . $_REQUEST['email'] . '"' );

	$FSSubscribeCore = new FSSubscribeCore();

	if(!$row){
		if( $FSSubscribeCore->add($_REQUEST['email']) > 0) echo "add_success";
	}else{
		if( $FSSubscribeCore->remove($_REQUEST['email']) == 1) echo "remove_success";	
	}

	die();
	}else{

		die("error");
	}
}

function post_published_notification( $ID, $post ) {

	if($post->post_type != 'post') return false;

	global $wpdb;
    $author = $post->post_author; /* Post author ID. */
    $name = get_the_author_meta( 'display_name', $author );
    $email = get_the_author_meta( 'user_email', $author );
    $title = $post->post_title;
    $permalink = get_permalink( $ID );
    $edit = get_edit_post_link( $ID, '' );
    $to[] = sprintf( '%s <%s>', $name, $email );

    $mails = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . TABLE_NAME , ARRAY_A);

    foreach ($mails as $key => $value) {
    	$to[] = sprintf( '<%s>',$value );
    }
    $subject = sprintf( 'Рассылка новостей сайта ФАУ Главгосэкспертиза' );
    $message = sprintf ('На нашем сайте опубликована новость \'%s' . "'\n\n", $title );
    $message .= sprintf( 'Просмотреть можно у нас на сайте %s/press-centr#p1.' ."\r\n\r\n", $_SERVER['SERVER_NAME'] );

    $message .= 'Вы получаете эту рассылку, потому что подписаны на нашем сайте. Отписаться можно в разделе Настройка подписки.';
    $headers[] = 'From: ФАУ «Главгосэкспертиза России» <info@gge.ru>';
    wp_mail( $to, $subject, $message, $headers );
}
add_action( 'publish_post', 'post_published_notification', 10, 2 );

function fs_subs_page() {

	global $wpdb;

	$list = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}" . TABLE_NAME, ARRAY_A);
	?>
<div class="wrap">
	<h1>Список подписчиков</h1>
	<div class="subscriber-add-wrapper">
		<form method="POST" >
			<input name="email" id="" placeholder="Введите email нового подписчика" />
			<br>
			<input type="submit" value="Добавить подписчика">
		</form>
	</div>
	<h3>Подписчики</h3>
	<form method="POST" action="">
	<div style="height:200px; overflow-y:scroll" class="subscribers-wrapper">
	
	<table>
	<?	if( $list ) {
		foreach ( $list as $item ) {
			?>
			<tr>
			<td><input type="checkbox" id="rm<?=$item['id']?>" name="ids[]" value="<?=$item['id']?>">
			<td>
				<div class="subscriber"><label for="rm<?=$item['id']?>"><?=$item['email'];?></div>
			</td>
</tr>
			<?
		}
		}?>
	</div>
</table>
</div>
<br>
<input name="remove" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Удалить выбранных подписчиков">
</form>

		<?

}
/*
function site_settings_page(){

	$Core->site_settings_page();
}


function register_settings() {
  
	$settings = array(

		
	);

  foreach ($settings as $value) {
    register_setting( 'site-settings-group', $value );
  }  
}
*/
class FSSubscribeCore{

	public $TABLE_NAME = 'fs-subscribe-list';

	public function site_settings_page(){}

	public function add($mail){

		global $wpdb;

		if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

			$row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}" . TABLE_NAME . ' WHERE email = "' . $mail . '"' );
			
			if(!$row){
				
				return $wpdb->insert(
					$wpdb->prefix . TABLE_NAME,
					array('id'=>'', 'email'=>$mail)
				);
			}
		}else{
			return false;
		}
	}

	public function remove($ids){

		global $wpdb;
		if(is_string($ids)){
			
			return $wpdb->delete($wpdb->prefix . TABLE_NAME , array('email' => $ids ));
		}else{

			if(count($ids) > 0){

				foreach($ids as $id){
					$wpdb->delete($wpdb->prefix . TABLE_NAME , array('ID' => $id ));
				}
			}

			return true;	
		}
	}
}

?>