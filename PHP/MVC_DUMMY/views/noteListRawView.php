<ol>
<?
if(isset($res)&&!empty($res)){

	foreach($res as $item){
	
		?>
		<li id="board<?=$item['id']?>"><a href="/note/view/<?=$item['id']?>"><?=$item['title']?></a><a class="removeBoarda" onclick="removeBoard(<?=$item['id']?>)">Удалить</a></li>
		<?
	
	}

}else{
	?><p>У тебя пока нет заметок. <br /> <a style="text-decoration:underline;" href="/note/view/">Но они же будут, да? :)</a></p><?
}
?>
</ol>