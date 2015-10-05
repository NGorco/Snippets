


$(document).ready(function() {
    
	$(".reg .open-popup, .sss").click(function(){
		$(".light-box .close").click();
		$("#light-box-reg").show();
		$(".lightbox-fader").fadeIn().css({"height":"100%","position":"fixed","width":"100%"});
	});
	
	$(".light-box .close").click(function(){
		$(this).closest(".light-box").hide();
		$(".lightbox-fader").fadeOut();
	});
	
	$(".enter-link .open-popup, .open-popup-enter").click(function(){
		if(getCookie("auth_login")&&getCookie('auth_pass')){
			$("#field43e").val(getCookie("auth_login"))
			$("#field45e").val(getCookie("auth_pass"))
		}
		$(".light-box .close").click();
		$("#light-box-authorization").show();
		$(".lightbox-fader").fadeIn().css({"height":"100%","position":"fixed","width":"100%"});
	});
	
	$(".recovery").click(function(){
		$(".light-box .close").click();
		$("#light-box-recovery").show();
		$(".lightbox-fader").fadeIn().css({"height":"100%","position":"fixed","width":"100%"});
	});
	

//КОНСТРУКТОР
//самая левая стрелка, меню
$('.workSpace').click(function() {
	if($(this).parent().parent().hasClass('active')) {
		$(this).parent().parent().removeClass('active');
	} else {
		$(this).parent().parent().addClass('active');
	}
});

//чекбоксы
$('.check').click(function() {
	if($(this).hasClass('active')) {
		$(this).removeClass('active');
		$(this).find('input').prop('checked', false);
	} else {
		$(this).addClass('active');
		$(this).find('input').prop('checked', true);
	}
});

//проценты
$('.conPer').click(function() {
	if($(this).hasClass('active')) {
		$(this).removeClass('active');
	} else {
		$('.conPer').removeClass('active');
		$(this).addClass('active');
	}
});

//селекты
//$('.theSelect').selectbox();

//скроллы в селектах
$('.scrollbarBig').each(function(i) {
	$(this).attr('id','scrollbar'+(i+1));
	$('#'+'scrollbar'+(i+1)).tinyscrollbar({
		sizethumb : 59,
		track : 96
	});
});

//для нестандартных скролов расчет ширины для блоков в конструкторе
if($(window).width()>1024) {
	$('.contentRight').width($(window).width()-265-28-32-20);
} else {
	$('.contentRight').width(1024-265-28-32-1);
}
$('.conRow').each(function() {
	$(this).width($(this).find('.conCell').size()*174);
});
$('.conHor').width($('.conHor .columnName').size()*175);
$('.conVert').height($('.conVert .rowName').size()*175);
$('#conSrollx > .viewport').height($('#conSrollx > .viewport .overview').height());

//нестандартные сколы в конструкторе
/* $('#conSrollx').tinyscrollbar({
	 axis : 'x',
	sizethumb : 68
 });
$('#conSrolly').tinyscrollbar({
	axis : 'y',
	size : 695,
	sizethumb : 68,
	scroll : true
});*/

//для избежания конфликта скролов
$('#conSrollx > .scrollbar').appendTo($('#conSrolly > .viewport'));

//пересчет по ресайзу
$(window).resize(function() {
	if($(window).width()>1024) {
		$('.contentRight').width($(window).width()-265-28-32-1);
	} else {
		$('.contentRight').width(1024-265-28-32-1);
	}
	/*$('#conSrollx').tinyscrollbar_update({
		axis : 'x',
		sizethumb: 68
	});*/
	if($(window).height()>918) {
		$('.contentLeft').height($(window).height()-235-50);
	} else {
		$('.contentLeft').height('auto');
	}
});

if($(window).height()>918) {
	$('.contentLeft').height($(window).height()-235-50);
} else {
	$('.contentLeft').height('auto');
}




//АУДИОТЕСТ
/*
$('.comment').click(function() {
	$('.popComment .text').html($(this).find('.text').html());
	$('.cover').fadeIn();
	$('.popComment').fadeIn();
});
$('.popComment .popbutton').click(function() {
	$('.cover').fadeOut();
	$('.popComment').fadeOut();
	return false;
});
$('.timer').click(function() {
	$('.cover').fadeIn();
	$('.popResult').fadeIn();
});
$('.cover').click(function() {
	$('.cover').fadeOut();
	$('.popComment').fadeOut();
	$('.popResult').fadeOut();
});*/


$('.sButton.no').click(function() {
	$('.soundConfirm').addClass('bad');
	$('.soundCheck').removeClass('active');
	$('.sButton.yes').removeClass('active');
	$('.resButton.start').removeClass('active');
	return false;
});

$('.sButton.yes').click(function() {
	$(this).addClass('active');
	$('.soundConfirm').removeClass('bad');
	$('.soundCheck').removeClass('active');
	$('.resButton.start').addClass('active');
	return false;
});

$('.resButton.start').click(function() {
	$('.soundConfirm').removeClass('bad');
	if($('.sButton.yes').hasClass('active')) {
		$('.soundCheck').removeClass('active');
	} else {
		$('.soundCheck').addClass('active');
	}
	return false;
});

$('.playStart').click(function() {
	if($(this).hasClass('active')) {
		document.getElementById('test_sound').pause();
		$(this).removeClass('active');
	} else {
		document.getElementById('test_sound').play();
		$(this).addClass('active');
	}
	return false;
});



//ПРОИГРЫВАТЕЛИ



});

function Logout(){
    $.get("/usr/logout",function(){
        window.location.reload();
    });
}

var volIndex = 0;
$('.vol').click(function() {
	volIndex = $(this).parent().find('.vol').index($(this));
	$(this).parent().find('.vol').removeClass('active');
	for(var i=0;i<=volIndex;i++) {
		$(this).parent().find('.vol').eq(i).addClass('active');
	}
});

//ПРОИГРЫВАТЕЛИ
var eIndex = 0;
$('.ePage').click(function(i) {
	if($(this).hasClass('now')) {
		return false;
	} else {
		eIndex = $('.ePage').index($(this));
		$('.ePage').removeClass('done');
		$('.ePage').removeClass('now');
		for(var i=0; i<=eIndex; i++) {
			$('.ePage').eq(i).addClass('done');
		}
		$(this).addClass('now');
	}
});

var cIndex = 0;
$('.coursesList li').click(function() {
	if($(this).hasClass('now')) {
		return false;
	} else {
		eIndex = $('.coursesList li').index($(this));
		$('.coursesList li').removeClass('done');
		$('.coursesList li').removeClass('now');
		for(var i=0; i<=eIndex; i++) {
			$('.coursesList li').eq(i).addClass('done');
		}
		$(this).addClass('now');
	}
});

if (window.ActiveXObject) {
	$('body').addClass('isIE');
}

if (window.sidebar) {
	$('body').addClass('isFF');
}

if (window.chrome) {
	$('body').addClass('isCH');
}




/*Current-page data-storage using new HTML5 attribute data and old-school Object :) */

var Data = new Object;

function DData(cell,data){
	if($("#data_storage").length==0){
		var Data_Storage = document.createElement('div');
		Data_Storage.id = "data_storage";
		document.getElementsByTagName('body')[0].appendChild(Data_Storage);
		Data_Storage = $('#data_storage');
	}else{
		var Data_Storage = $("#data_storage");
	}
	if(cell&& cell.length!=0){
		if(data&&data.length!=0){
			return Data_Storage.data(cell,data);
		}else{
			return Data_Storage.data(cell);
		}
	}

}