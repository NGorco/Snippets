<!DOCTYPE html>
<html>
<head>
<? getHeader();?>
<script type="text/javascript" src="/includes/js/functions.js"></script>
<script type="text/javascript" src="/includes/js/bdesktop.js"></script>
<script type="text/javascript" src="/includes/js/jqEvents.js"></script>
<script type="text/javascript" src="/includes/js/draw.js"></script>
<link rel="stylesheet" href="/includes/style.css" />
<?if(!isset($title)) {$title_="заметки";}else{$title_="заметки ".$title;}?>
<title>QuickDesk | Просмотр <?=$title_?> </title>
</head>
<body>
<? if(isset($id)){?>
	<input type="hidden" id="id" value="<?=$id;?>" />
<?}?>
<?if(!isset($title)) $title="Название заметки";?>
<input type="text" class="title" value="<?=$title?>" />
<p id="notification"></p>
<div style="color:white!important" id="dropzone">Перетащите сюда картинки для загрузки в активный фрейм...</div>
<div class="fixed in_frame">
<div class="logo">
            <a href="/"><img src="/includes/images/qdesk_logo_light.png" >
</a>


        </div>
		

</div>
<div class="fixed_ in_frame">
<a href="/note/lists/show" onclick="setInSt('inwork','home')" id="left"><img src="/includes/images/appbar.list.png" alt="" /><p>Список</p></a>
<a href="/note/view" id="right"><img src="/includes/images/appbar.page.add.png" alt="" /><p>Создать</p></a>
<a href="#" onclick="Qdesk.saveNote()" id="right" class="save"><img src="/includes/images/appbar.disk.png" alt="" /><p>Сохранить</p></a>
</div>
<?if (isset($id)){?>
<script type="text/javascript">
function loadNote(){
		
		
		var gift_defense = '';
		if(<?=$id?>==30){
		
			gift_defense = prompt("Введите защитный код для получения содержимого данного рабочего стола");
		}
		
		$.get('/note/getnote/'+<?=$id?>+'/'+gift_defense,function(data){
			try{		
				var desk_content = jQuery.parseJSON(data);
			}
			catch(e){
				console.log(e);
			}
			
			if(desk_content){
			var uiObjs = document.querySelectorAll('.uiobj');
		if(uiObjs.length>0)
		for(var k =0;k<uiObjs.length;k++){
			uiObjs[k].parentNode.removeChild(uiObjs[k])
		}
			QDContent.elementCount = desk_content.elementCount;
				var items = desk_content.data;
				for(var key in items){
					Qdesk.addObj(items[key]);
					QDContent.data[key] = items[key]
				}
			
			}
		});
	}

	setInSt("inwork",window.location.href);
</script>
<?}?>
</body>
</html>