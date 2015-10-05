function saveNote(){
	
	
	
}

/*
 * Audero Context Menu is a cross-browser jQuery plugin that allows
 * you to show a custom context menu on one or more specified elements.
 *
 * @author  Aurelio De Rosa <aurelioderosa@gmail.com>
 * @version 2.0.0
 * @link    https://github.com/AurelioDeRosa/Audero-Context-Menu
 * @license Dual licensed under MIT (http://www.opensource.org/licenses/MIT)
 * and GPL-3.0 (http://opensource.org/licenses/GPL-3.0)
 */
(function($)
{
   var defaultValues = {
      idMenu: null, // string (required). The id of the menu that has to be shown
      posX: null,   // number (optional). The X coordinate used to show the menu
      posY: null,   // number (optional). The Y coordinate used to show the menu
      bindLeftClick: false // boolean (optional). If the menu has to be shown also on mouse left button Qdesk
   };

   var methods =
   {
      init: function(options)
      {
         if (typeof options === "string") {
            options = {idMenu: options};
         }
         options = $.extend(true, {}, defaultValues, options);

         if (options.idMenu == null) {
            $.error("No menu specified");
            return;
         } else if ($("#" + options.idMenu) == null) {
            $.error("The menu specified does not exist");
            return;
         }

         // Hide all if the user left-Qdesk or right-Qdesk outside the elements specified
         $("html").on(
            "contextmenu Qdesk",
            function() {
               $("#" + options.idMenu).hide();
            }
         );

         this.on(
            "contextmenu " + (options.bindLeftClick ? " Qdesk": ""),
            function(event) {
               event.preventDefault();
               event.stopPropagation();

               var posX = (options.posX == null) ? event.pageX : options.posX;
               var posY = (options.posY == null) ? event.pageY : options.posY;
               $("#" + options.idMenu)
                  .css({
                     top: posY + "px",
                     left: posX + "px"
                  })
                  .show();
            }
         );
      }
   };

   $.fn.auderoContextMenu = function (method) {
      if (methods[method])
         return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      else if (typeof method === "object" || typeof method === "string" || !method)
         return methods.init.apply(this, arguments);
      else
         $.error("Method " + method + " does not exist on jQuery.auderoContextMenu");
   };
})(jQuery);


function getChar(event) {

  if (event.which == null) {  // IE

    if (event.keyCode < 32) return null; // спец. символ

    return String.fromCharCode(event.keyCode)

  }

 

  if (event.which!=0 && event.charCode!=0) { // все кроме IE

    if (event.which < 32) return null; // спец. символ

    return String.fromCharCode(event.which); // остальные

  }

  return null; // спец. символ

}


function createImage(source) {
   var pastedImage = new Image();
   pastedImage.onload = function() {
      // теперь у нас есть изображение из буфера
   }
   pastedImage.src = source;
   activeObj.children[1].appendChild(pastedImage)
}
function checkInput() {
    var child = pasteCatcher.childNodes[0];   
   pasteCatcher.innerHTML = "";    
   if (child) {
// если пользователь вставил изображение – создаем изображение
      if (child.tagName === "IMG") {
         createImage(child.src);
      }
   }
}


/*DRAGGABLE*/
var dragMaster = (function() {

    var dragObject
    var mouseOffset

    var dropTargets = []

    function mouseUp(e){
		e = fixEvent(e)

		for(var i=0; i<dropTargets.length; i++){
			var targ  = dropTargets[i]
			var targPos    = getPosition(targ)
			var targWidth  = parseInt(targ.offsetWidth)
			var targHeight = parseInt(targ.offsetHeight)

			if(
			(e.pageX > targPos.x)                &&
			(e.pageX < (targPos.x + targWidth))  &&
			(e.pageY > targPos.y)                &&
			(e.pageY < (targPos.y + targHeight))){
				alert("dragObject was dropped onto currentDropTarget!")
			}
		}
		if(QDContent.data[actId]){
		QDContent.data[actId].x = dragObject.parentNode.style.left
		QDContent.data[actId].y = dragObject.parentNode.style.top
		}
		dragObject = null
		removeDocumentEventHandlers()
    }

	function removeDocumentEventHandlers() {
		document.onmousemove = null
		document.onmouseup = null
		document.ondragstart = null
		document.body.onselectstart = null
	}

	function getMouseOffset(target, e) {
		var docPos	= getPosition(target)
		return {x:(e.x/mainFrame.style.zoom - docPos.x), y:(e.y/mainFrame.style.zoom - docPos.y)}
	}


	function mouseMove(e){
		e = fixEvent(e)

		with(dragObject.parentNode.style) {
			position = 'absolute'
			top = (e.y/mainFrame.style.zoom - mouseOffset.y) + 'px'
			left = (e.x/mainFrame.style.zoom - mouseOffset.x) + 'px'
		}
		return false
	}

	function mouseDown(e) {
		e = fixEvent(e)
		if (e.which!=1) return
		
		dragObject  = this
		mouseOffset = getMouseOffset(this, e)

		addDocumentEventHandlers()

		return false
	}

	function addDocumentEventHandlers() {
		document.onmousemove = mouseMove
		document.onmouseup = mouseUp

		// отменить перенос и выделение текста при клике на тексте
		document.ondragstart = function() { return false }
		document.body.onselectstart = function() { return false }
	}

    return {

		makeDraggable: function(element){
			element.onmousedown = mouseDown
		},

		addDropTarget: function(dropTarget){
			dropTargets.push(dropTarget)
		}
    }
}())

function getPosition(e){
	var left = 0;
	var top  = 0;

	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}

	left += e.offsetLeft;
	top  += e.offsetTop;

	return {x:left, y:top};
}

function fixEvent(e) {
	// получить объект событие для IE
	e = e || window.event

	// добавить pageX/pageY для IE
	if ( e.pageX == null && e.clientX != null ) {
		var html = document.documentElement
		var body = document.body
		e.pageX = e.clientX + (html && html.scrollLeft || body && body.scrollLeft || 0) - (html.clientLeft || 0)
		e.pageY = e.clientY + (html && html.scrollTop || body && body.scrollTop || 0) - (html.clientTop || 0)
	}

	// добавить which для IE
	if (!e.which && e.button) {
		e.which = e.button & 1 ? 1 : ( e.button & 2 ? 3 : ( e.button & 4 ? 2 : 0 ) )
	}

	return e
}


function strip(html)
{
   
var k = /\n/g;
   html = html.replace(k,"<br/>");
   var k = /background-color:\s[A-z\(\)0-9,\s]*;/g;
   html = html.replace(k,"");
   
   k = /\r/g;
   html = html.replace(k,"<br/>");
   k = /  /g;
   html = html.replace(k,"&nbsp;&nbsp;&nbsp;");
return html;
}

function strip_full(html)
{
var k = /<br\/?>/g;
   html = html.replace(k,"\n");
   
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
html =  tmp.textContent || tmp.innerText || "";  
var k = /\n/g;
   html = html.replace(k,"<br/>");
   k = /\r/g;
   html = html.replace(k,"<br/>");
   k = /  /g;
   html = html.replace(k,"&nbsp;&nbsp;&nbsp;");
return html;
}


function getClickTarget(e){
		if(e.toElement){
			var conCell = e.toElement
		}
		
		if(e.srcElement&&!conCell){			
			var conCell = e.srcElement
		}
		
		if(e.target&&!conCell){
			var conCell = e.target
		}
		return conCell
}

function getClickTargetDeskItem(e){
		if(e.toElement){
			var conCell = e.toElement
		}
		
		if(e.srcElement&&!conCell){			
			var conCell = e.srcElement
		}
		
		if(e.target&&!conCell){
			var conCell = e.target
		}
		return $(conCell).closest('.uiobj').get(0)
}

function logout(){
	$.get('/usr/logout',function(){
			setInSt('quickdesk_quicklogin','false');
		window.location.reload();
	})
	}
