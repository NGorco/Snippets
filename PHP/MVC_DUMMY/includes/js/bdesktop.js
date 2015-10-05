//var createObj = false;
var activeObj = false;
var actId = '';
var mainFrame;
var drawMode = false;
var canvasMain;
var el = document.getElementById('r');

window.addEventListener('keydown',function(e){
	switch(e.which){
	case 83: if(e.ctrlKey){e.preventDefault();e.stopPropagation();Qdesk.saveNote();}break;
	case 90:
		if(!$("*").is(":focus")){
			mainFrame.style.zoom -= 0.1;
		};break;
	case 88:
		if(!$("*").is(":focus")){
			if(mainFrame.style.zoom<1)
			mainFrame.style.zoom =  parseFloat(mainFrame.style.zoom) + 0.1;
		};break;
	case 46: 
		/*if(!activeObj&&activeObj.children[1].style.opacity<1){
			activeObj.parentNode.removeChild(activeObj);
			activeObj = false;
		}*/
		break;
	case 66:if(!$(".uiobj.active .text").is(":focus"))if(drawMode){drawMode = false;canvasMain.style.cursor = "default"}else{drawMode = true;canvasMain.style.cursor = "crosshair"};break;
	}
	
});


/*Class QDesktop Item*/

function QDesktopItem(e){

	if(!e) return false;
	
	var newItem = document.createElement('div');
	newItem.setAttribute('class',"uiobj opened active");		
	newItem.style.position = "absolute";	
	
	var head = document.createElement('div');
	head.setAttribute('class','objHead');
	dragMaster.makeDraggable(head);
	
	var dots = document.createElement('span');
	dots.innerHTML = "×";
	head.appendChild(dots);

	
	newItem.appendChild(head);
	
	newItem.addEventListener('mousedown',function(){
		if(this.children[1].children[0].innerHTML!='')
		actId = this.id;
		activeObj = QDtemp[this.id]
	})
	
	var textarea = document.createElement('div');
	var inner_text = document.createElement('div')
	inner_text.setAttribute('contenteditable','');
	textarea.appendChild(inner_text);
	
	inner_text.addEventListener('change',function(e){
	Qdesk.processItem(getClickTarget(e).parentNode.parentNode)
	});
	inner_text.addEventListener("input", function(e){
		Qdesk.processItem(getClickTarget(e).parentNode.parentNode);
	});
	//textarea.addEventListener('input',function(e){ e.currentTarget = false;},false);
	inner_text.addEventListener('paste',function(e){		
		try{
			var clip = e.clipboardData.getData('Text');				
		}
		catch(e){
			console.log(e);
		}
		if(clip&&clip.indexOf('www.youtube.com/watch?')!=-1){
			var frame = document.createElement('iframe');
			var video_id = clip.split('=')[clip.split('=').length-1];
			frame.src = "//www.youtube.com/embed/"+video_id;
			frame.frameborder = 0;
			frame.style.width = "560px";
			frame.style.height = "315px";
			activeObj.text.contenteditable = "false";
			activeObj.text.appendChild(frame);
			e.clipboardData.clearData();
			$(activeObj).addClass('utub');
			e.preventDefault();
			return false;
		}
	},false);
	textarea.setAttribute('class','text');			
	newItem.appendChild(textarea);
	
	mainFrame.appendChild(newItem);
	
	if(!'id' in e)
	QDContent.elementCount++

	var range = document.createRange();
	var editor = inner_text;
	range.setStart(editor,0);
	range.collapse(true);
	  
	var sel = window.getSelection();
	sel.removeAllRanges();
	sel.addRange(range);
	editor.focus();
	newItem.setAttribute('class','uiobj opened active');
	
	if('id' in e&&e.id!=''){
	
		newItem.id = e.id;
		newItem.style.top = parseFloat(e.y)+"px";
		newItem.style.left = parseFloat(e.x)+"px";		
		inner_text.innerHTML = e.content;
	
	}else{
	
		newItem.id = "obj"+(QDContent.elementCount+1);
		newItem.style.top = (e.y-10)/mainFrame.style.zoom+"px";
		newItem.style.left = (e.x-10)/mainFrame.style.zoom+"px";
		inner_text.innerHTML = "";
	
	}
	
	dots.addEventListener('click',function(){
		Qdesk.removeObj(newItem.id);
	});
	
	this.Item = newItem
	this.dots = dots
	this.textarea = textarea
	this.text = inner_text
	this.head = head
	
	

}

var QDtemp = {}

var QDContent = {
	data:{},
	elementCount:0
}
var Qdesk = {
	processItem : function(Item){
		QDContent.data[Item.id] = {
			'id': Item.id,
			'x': Item.offsetLeft,
			'y': Item.offsetTop,
			'content' : QDtemp[Item.id].text.innerHTML,
		}
	},
	addDeskObj : function(e){
		/*var actObjChild1 = true;
		if(activeObj){
			if(activeObj.children)
		}*/
		
		if($(getClickTargetDeskItem(e)).hasClass('active')) return false;
		
		if(!drawMode)
		if(!activeObj||(!$(getClickTargetDeskItem(e)).hasClass('active'))){
			activeObj = QDtemp["obj"+(QDContent.elementCount+1)] = new QDesktopItem(e)
			QDContent.elementCount++
		}else{
				activeObj.Item.style.top = (e.y-10)/mainFrame.style.zoom+"px";
				activeObj.Item.style.left = (e.x-10)/mainFrame.style.zoom+"px";
				activeObj.text.focus();
		}
		
	},
	removeObj:function(id){
		delete(QDContent.data[id]);
		delete(QDtemp[id]);
		mainFrame.removeChild(document.getElementById(id));
	},
	addObj: function(Obj){
		activeObj = QDtemp[Obj.id] = new QDesktopItem(Obj);
	},
	saveNote:function(){
		var id = '';
		if($("#id").val()){
			id = $("#id").val();
		}
		$.post('/note/save',{"data":JSON.stringify(QDContent),"title":$(".title").val(), "id":id},function(data){
			$("#notification").removeAttr('class').html('').show();
			try{
				var Json = $.parseJSON(data);
			}
			catch(e){
				console.log(e);
				$("#notification").html("Хьюстон, у нас проблемы. Ошибка сохранения").addClass('red');
				setTimeout('$("#notification").fadeOut("slow");',2000);
				return false;
			}
			if(Json.status == "newItem"){
				$("#notification").html('Заметка успешно сохранена и создана. Сейчас вы будете перенаправлены на страницу заметки.').addClass('green');
				window.location = "/note/view/"+Json.id;
				setTimeout('$("#notification").fadeOut("slow");',2000);
				return false;
			}
			if(Json.status == "updateSuccess"){
				$("#notification").html("заметка сохранена").addClass('green');
				setTimeout('$("#notification").fadeOut("slow");',2000);
			}else{
				$("#notification").html("Хьюстон, у нас проблемы. Ошибка сохранения").addClass('red');
				setTimeout('$("#notification").fadeOut("slow");',2000);
			}
		})
	}
	/*pasteImg: function(e) {
	// если поддерживается event.clipboardData (Chrome)
		  if (e.clipboardData) {
		  // получаем все содержимое буфера
		  var items = e.clipboardData.items;
		  if (items) {
			 // находим изображение
			 for (var i = 0; i < items.length; i++) {
				if (items[i].type.indexOf("image") !== -1) {
				   // представляем изображение в виде файла
				   var blob = items[i].getAsFile();
				   // создаем временный урл объекта
				   var URLObj = window.URL || window.webkitURL;
				   var source = URLObj.createObjectURL(blob);                
				   // добавляем картинку в DOM
				   createImage(source);
				}
			 }
		  }
	   // для Firefox проверяем элемент с атрибутом contenteditable
	   } else {      
		  setTimeout(checkInput, 1);
	   }
	}*/

}



function get(a) {
    var c = document,
        d = c.body,
        e = c.documentElement,
        f = "client" + a;
    a = "scroll" + a;
    return c.compatMode === "CSS1Compat" ? Math.max(e[f], e[a]) : Math.max(d[f], d[a])
}
/*
window.onresize = function () {
   var i = document.getElementById("img");
   if(i) document.body.removeChild(i);
    window.clearTimeout(b);
    b = window.setTimeout(function () {
        fon()
    }, 20)
};
*/


function onLoad(){
	document.styleSheets[0].addRule('#mainFrame .uiobj','max-width:'+(get("Width")*0.7)+'px');
	document.styleSheets[0].addRule('#mainFrame .uiobj .text','max-height:'+(get("Height")*0.7)+'px');
	mainFrame = document.createElement('div');
	mainFrame.id = "mainFrame";
	mainFrame.style.position = "relative"
	/*mainFrame.style.width = (screen.availWidth-21)+"px";
	mainFrame.style.height = (screen.availHeight-85)+"px";*/
	mainFrame.style.width = 2000+"px";
	mainFrame.style.height = 2000+"px";
	
	mainFrame.style.zoom = 1;
	mainFrame.addEventListener('dblclick',Qdesk.addDeskObj);
	mainFrame.addEventListener('click',function(e){
		if(e.ctrlKey)Qdesk.addDeskObj(e)
	});
	document.body.appendChild(mainFrame);	
	var canvas = document.createElement('canvas');
	canvas.id = "canvas";
	canvasMain = canvas;
	mainFrame.appendChild(canvas);
	
	Canva.init('canvas', parseInt(mainFrame.style.width), parseInt(mainFrame.style.height));
	
	if(loadNote){
		loadNote();
	}

if (!window.Clipboard) {
   var pasteCatcher = document.createElement("div");
    
   // Firefox вставляет все изображения в элементы с contenteditable
   pasteCatcher.setAttribute("contenteditable", "");
    
   pasteCatcher.style.display = "none";
   document.body.appendChild(pasteCatcher);
 
   // элемент должен быть в фокусе
   pasteCatcher.focus();
   document.addEventListener("click", function() { pasteCatcher.focus(); });
} 
}
window.addEventListener('paste', Qdesk.pasteImg, true);
window.onload = onLoad;


