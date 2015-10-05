<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/includes/style.css" />
<? getHeader();?>
<script type="text/javascript" src="/includes/js/functions.js"></script> 
<script type="text/javascript" src="/includes/js/settings.js"></script> 
<title>QuickDesk | Список заметок</title>
</head>
<body>
<div class="fixed inner">
<div class="logo">
            <a href="/"><img src="/includes/images/qdesk_logo_light.png"></a>
        </div><p class="logop usrPage"><!--Quick<br/><span>Desk</span>--></p>
</div>
<div class="hover_tracer quit_trace">
<a onclick="logout()" class="circle white quit"><img src="/includes/images/appbar.man.suitcase.run.png" alt="" /><p>Выход</p></a>
</div>
<div class="hover_tracer about_trace">
<a onclick="infoPage('/info/about.html')" class="circle white about"><img src="/includes/images/massique.png" alt="" /><p>О проекте</p></a>
</div>
<div class="hover_tracer sett_trace">
<a onclick="infoPage('/info/settings.html')" class="circle white settings"><img src="/includes/images/appbar.cog.png" alt="" /><p>Настройки</p></a>
</div>
<div class="fixed_">
<a onclick="getList()" id="left"><img src="/includes/images/appbar.list.png" alt="" /><p>Список</p></a>
<a href="/note/view/" id="right"><img src="/includes/images/appbar.page.add.png" alt="" /><p>Создать</p></a>
</div>
<div id="list_back"></div>
<div id="list"></div>
<div id="info"></div>
<div id="info_back"></div>


<script type="text/javascript">
<? if($show==true){?>
$(document).ready(function(){
	
	getList();
})

<?}?>
var inwork = getFromSt("inwork");

if(inwork>''&&inwork!='home') 
	{
		window.location = inwork;
	}
	else
	{
		setInSt("inwork","home");
	}
	
if(getFromSt('quickdesk_quicklogin')=='true') getList();
function infoPage(url){
$.get(url,function(data){
			if(data){
				$("#info").html(data).fadeIn();
			}
		})
}

function removeBoard(id){
	var boardTitle = document.getElementById("board"+id).children[0].innerText;
	if(confirm("Вы уверены, что хотите удалить рабочий стол \""+boardTitle+"\"?"))
	$.post("/note/removeboard",{"id":id},function(){
		$("#board"+id).fadeOut();
	});

}

function getList(){
$.get('/note/get_list',function(data){
			if(data){
				$("#list").html(data).fadeIn();
			}
		})
		}
</script>
</body>
</html>