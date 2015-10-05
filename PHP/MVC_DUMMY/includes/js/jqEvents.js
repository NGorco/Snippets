$(document).ready(function(){

	$(document).on('mousedown',".uiobj.opened",function(){
		$(".uiobj").removeClass('active');
		$(this).addClass('active').find('.text').focus();
		
	})
	
	


});

$(document).ready(function(){  

    	var dropBox = $('#dropzone');
		
   dropBox.bind({
        dragenter: function() {
            $(this).addClass('highlighted');
            return false;
        },
        dragover: function() {
            return false;
        },
        dragleave: function() {
            $(this).removeClass('highlighted');
            return false;
        },
        drop: function(e) {
            var dt = e.originalEvent.dataTransfer;
            displayFiles(dt.files);
			$(this).removeClass('highlighted');
            return false;
        }
    });
    function displayFiles(files) {
        var imageType = /image.*/;
        
        $.each(files, function(i, file) {
					
			/*в ФФ возникает проблема при выгрузке файлов кириллицей, так что проверяем есть ли кириллические символы*/		
					
			if ( /[а-я]/i.test(file.name) ) {
				
				alert('название файлов должно быть только латинницей');
				/* или можно заменbnm русcкие буквы транслитом */
			}
			else
			{
				// Отсеиваем не картинки
				if (!file.type.match(imageType)) {
					alert('загрузить можно только изображения');
					return true;
				}
			
				var img = new Image();
				activeObj.text.appendChild(img);
				// Создаем объект FileReader и по завершении чтения файла, отображаем миниатюру и обновляем
				// инфу обо всех файлахiv
				var reader = new FileReader();
				reader.onload = (function(aImg) {
					return function(e) {
						aImg.src = e.target.result;
						Qdesk.processItem(activeObj.Item);
					};					
				})(img);
				reader.readAsDataURL(file);
			}
        });
		
    }
	})