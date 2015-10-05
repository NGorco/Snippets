

//socials connection
function connect_vk(user){

	var userInfo = {"UF_VKID":user.session.user.id,"ID":Util.bid('user_id').value};
	Core.updateUser(userInfo,function(data){
		if(data.status){
			Util.bid("profile_vkid").value = user.session.user.id;
			$("#profile_vkid").show();			
			$("#vk_disconnect_button").show();			
			$("#vk_connect_button").hide();	
			$(".vk_status").html("Социальная сеть Вконтакте привязана к Вашему аккаунту!").show();
			setTimeout('$(".vk_status").fadeOut()',3000);
		}
	});
}

function connect_fb(response){

	var userInfo = {"UF_FACEBOOKID":response.id,"ID":Util.bid('user_id').value};
	Core.updateUser(userInfo,function(data){
		if(data.status){
			Util.bid("profile_fbid").value = response.id;
			$("#profile_fbid").show();			
			$("#fb_disconnect_button").show();			
			$("#fb_connect_button").hide();	
			$(".fb_status").html("Социальная сеть Facebook привязана к Вашему аккаунту!").show();
			setTimeout('$(".fb_status").fadeOut()',3000);
		}
	});
}


//disconnect socials

function disconnect_vk(id){

	var userInfo = {"UF_VKID":""};
	Core.updateUser(userInfo,function(data){
		if(data.status){
			
			Util.bid("profile_vkid").value = "";	
			$("#profile_vkid").hide();			
			$("#vk_disconnect_button").hide();			
			$("#vk_connect_button").show();			
			$(".vk_status").html("Аккаунт социальной сети отвязан от Вашего профиля!").show();
			setTimeout('$(".vk_status").fadeOut()',3000);
		}
	});
	
}

function disconnect_fb(id){

	var userInfo = {"UF_FACEBOOKID":""};
	Core.updateUser(userInfo,function(data){
		if(data.status){
			
			Util.bid("profile_fbid").value = "";	
			$("#profile_fbid").hide();			
			$("#fb_disconnect_button").hide();			
			$("#fb_connect_button").show();			
			$(".fb_status").html("Аккаунт социальной сети отвязан от Вашего профиля!").show();
			setTimeout('$(".fb_status").fadeOut()',3000);
		}
	});
	
}
 
//socials registration
function register_vk(response){

	if(response.status!=="connected"){
		
		alert("Ошибка соединения");
		return false;
	}
	var userInfo = {"USER":response.session.user,"VKID":response.session.user.id,"NETWORK_NAME":"vk"};
	Core.registerUserSocial(userInfo,function(data){
		if(data.status) {
			window.location.reload();
		}else{
			alert("Ошибка подключения учетной записи  Вконтакте!");
		}
	});
}

function register_fb(response){

	var userInfo = {"USER":response,"FACEBOOKID":response.id,"NETWORK_NAME":"fb"};
	Core.registerUserSocial(userInfo,function(data){
		if(data.status) {
			window.location.reload();
		}else{
			alert("Ошибка подключения учетной записи Facebook!");
		}
	});
}

//login socials
/*
function login_vk(response){

	if(response.status!=="connected"){
		
		alert("Ошибка входа");
		return false;
	}
	var userInfo = {"SOCIAL_ID":response.session.user.id};
	Core.request("loginSocial",userInfo,function(data){
		if(data.status) {
			window.location.reload();
		}else{
			alert("Ошибка входа на сайт!");
		}
	});
}

function login_fb(response){

	var userInfo = {"SOCIAL_ID":response.id};
	Core.request("loginSocial",userInfo,function(data){
		if(data.status) {
			window.location.reload();
		}else{
			alert("Ошибка входа на сайт!");
		}
	});
}

*/
/*FACEBOOK API*/

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '293819400824491',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  
function fb_connect_button_click(){
	FB.login(function(response){
		if(response.status == 'connected')
	 FB.api('/me', function(response) {
		  connect_fb(response);
		});
});
}


function fb_register_button_click(){
	FB.login(function(response){
		if(response.status == 'connected')
	 FB.api('/me', function(response) {
		  register_fb(response);
		});
});
}


function fb_login_button_click(){
	FB.login(function(response){
		if(response.status == 'connected')
	 FB.api('/me', function(response) {
		  login_fb(response);
		});
});
}

/*FACEBOOK SHARE BUTTON*/

function fb_share(PARAMS){

FB.ui(PARAMS, function(response){});
}