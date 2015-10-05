

$(function(){

		if(getFromSt('quickdesk_quicklogin')=='true'){
			if(getFromSt("quickdesklogin")&&getFromSt("quickdeskpass")){
				login(getFromSt("quickdesklogin"),getFromSt("quickdeskpass"));
			}
		}

	$("#field45").focus(function(){
	   $("#passLabel").hide();
	});
    $("#field45").blur(function(){
        if($(this).val()=="") $("#passLabel").show();
    });

});

function login(login,pass){
     $(".forms .entet-login li em").hide();

		$("form#authorization-form  h2").append('<img class="loader login" src="/includes/images/ajax-loader.gif"/>');
		$(".loader").animate({"opacity":"0.5"},100);
		
		if(login&&pass&&login!=''&&pass!=''){
			var loginInfo = {
			  "email":login,
			  "psw":pass
			};
		}else{
			var loginInfo = {
			  "email":$("#field43e").val(),
			  "psw":$("#field45e").val()
			};
		}
		
		
		$.post("/usr/io/",{"type":"login","loginInfo":loginInfo},function(data){
			try{
			var Res = $.parseJSON(data);
			}
			catch(e){
				console.log(e);
				alert('Логин или пароль неверны!');
				return false;
			}
			if(!Res){
                $(".forms .entet-login li em").show();$(".loader").fadeOut(500);  return false;
            }else{  
                $("form#authorization-form h2 ~ *").hide();
                $(".loader").fadeOut(100);	
                $("form#authorization-form h2").after("<p style='text-align:center;color:white'>Вход успешно осуществлён</p>");
				setInSt('quickdesklogin',$("#field43e").val());
				setInSt('quickdeskpass',$("#field45e").val());
				setInSt('quickdesk_quicklogin','true');
				var inwork_url='';
				/*if(inwork_url = getFromSt("inwork")){
					window.location = inwork_url;
					return false;
				}*/
                window.location.reload();
                		
            }	            		
			
		});
		
	};

function recover(){
		$("#light-box-recovery").append('<img class="loader" src="/includes/images/ajax-loader.gif"/>');
		$(".loader").animate({"opacity":"0.5"},100);
		
		var email = $("#field43e6").val();
			
		$.post("/usr/io/",{"type":"recover","email":email},function(data){
			var Res = $.parseJSON(data);
			
			if(Res.status=='error'){
			     alert("Такой электронной почты не существует."); 
                 $(".recovery").click();
            }else{
                if(Res.status=='mail_sent'){
                alert('Вам на почту было выслано письмо с инструкцией по восстановлению пароля.');
            }
            }
           
			return false;					
		});
		
		$(".loader").fadeOut(500);
		
	};

function register(){
	
        var reg = new RegExp("[0-9a-z_]+@[0-9a-z_^.]+\\.[a-z]{2,3}", 'i');
        if(!reg.test($("#field43").val())){
            $("#field43").parent().addClass('error');
            $("#field43").focus(function(){$(this).parent().removeClass('error')});
            return false;
        }
		$("#light-box-reg").append('<img class="loader" src="/includes/images/ajax-loader.gif"/>');
		$(".loader").animate({"opacity":"0.5"},100);
		
		var usrInfo = {	
			"mail": $("#field43").val(),
            "psw": $('#field45').val()
		};

		$.post("/usr/io/",{"type":"register","regUsr":usrInfo},function(data){
		      try{
		          $.parseJSON(data.replace(" ",""));
		      }
              catch(e){
                alert("Ошибка регистрации. Попробуйте пройти регистрацию снова.");return false;
              }
			var Res = $.parseJSON(data);
			if('status' in Res && Res){
    			switch(Res.status){
    			    case"email_exist":
                        $(".loader").fadeOut(500);
        			    alert("Уже существует учетная запись с такой электронной почтой."); 
                        $(".sss").click();
                        break;
                    case"error":
                        alert("Ошибка регистрации. Попробуйте пройти регистрацию снова.");$(".sss").click();return false;break;
                    case"success":
						setInSt('quickdesklogin',$("#field43").val());
						setInSt('quickdeskpass',$("#field45 ").val());
						setInSt('quickdesk_quicklogin','true');
						
                        $("form#register-form  h2 ~ *").slideUp(200);
                        alert("Спасибо за регистрацию! \n\n На твою почту прийдёт письмо с подтверждением регистрации.");window.location.reload();break;
    			}
            }
			
			return false;
						
		});	
		
	};