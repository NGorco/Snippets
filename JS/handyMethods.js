HandyAjax.prototype.ChangeSort = function(sortvar){
    
    this.request(arguments.callee,{CAT_SORT:sortvar},function(data){
        
        window.location.reload();
    });
};

HandyAjax.prototype.ChangeAdvType = function(typevar){
    
    this.request(arguments.callee,{ADV_TYPE:typevar},function(data){
        
        window.location.reload();
    });
};

HandyAjax.prototype.sellerPhoneImg = function(adv_id, self){
   
   self.style.display = 'none';
   var img = document.getElementById( "seller_phone" ); 
   img.src = "/?method=sellerPhoneImg&params%5BADV_ID%5D=" + adv_id + "&AJAX_REQUEST=Y";
   img.style.display = 'inline';

};


HandyAjax.prototype.registerUser = function(form){

  if($('input[name="CONFIRM"]').is(":checked") == false){

    alert('Согласитесь с политикой нашего сайта, пожалуйста');
    return false;
  }

  if($('input[name="REG_PASS"]').val() != $('input[name="REG_PASS1"]').val()){

    alert("Пароли не совпадают!");
    return false;
  }

  if($(".status-icon.ok").length < 5){

    alert('Некорректно заполнены поля регистрации!');
    return false;
  }

  this.request(arguments.callee, $(form).serializeObject(), function(data){
        if(data.status == 'success'){
          alert('Спасибо за регистрацию!');
          window.location = '/personal/';
        }else{
          alert(data.user_error);
          $("#register #cap_gen").click();
        }
  });
};

HandyAjax.prototype.login = function(form){

  this.request(arguments.callee, $(form).serializeObject(), function(data){
        if(data.status != 'success'){
          alert(data.user_error);
          return false;
        }else{
          window.location.reload();
        }
  });
};

HandyAjax.prototype.recoverPass = function(form){

  this.request(arguments.callee, $(form).serializeObject(), function(data){
        if(data.status != 'success'){
          alert(data.user_error);
          return false;
        }else{
          alert('На вашу почту отправлено письмо для восстановления пароля');
          form.style.display = 'none';
          $("#login-form").show();
        }
  });
};

HandyAjax.prototype.getCommonTags = function(tag, clbk){

  this.request(arguments.callee, {TAG: tag}, function(data){
      if(clbk){
        clbk(data);
      }
  });
};


HandyAjax.prototype.logout = function(){

  this.request(arguments.callee, {}, function(data){
        if(data.status != 'success'){
          alert(data.user_error);
          return false;
        }else{
          window.location.reload();
        }
  });
};

HandyAjax.prototype.getAdvAddFields = function(section_id, clbk){

  this.request(arguments.callee, {CAT_ID: section_id}, function(data){
        if(clbk && data.status != 'user_error'){
          clbk(data);
        }
  });
};

HandyAjax.prototype.advAction = function(id, action){

  this.request(arguments.callee, {ID: id, ACTION: action}, function(data){
        if(data.status == 'success'){

          switch(action){

            case"publish":
            case"unpublish": window.location = "/personal/user-adverts.php";break;
          }
        }
  });
};

HandyAjax.prototype.addToFavourite = function(id){

  this.request(arguments.callee, {ID:id}, function(data){
        if(data.status != 'success'){
          alert(data.user_error);
          return false;
        }else{
          if(data.type == 'favoured'){
            $(".fv"+id).addClass('active');
            $(".favour_success_icon").html('Объявление добавлено в избранное')
          }else{
            $(".fv"+id).removeClass('active');
            $(".favour_success_icon").html('Объявление удалено из избранного')
          }
          
          $(".favour_success_icon").show();
          setTimeout('$(".favour_success_icon").fadeOut()', 800);

          $("#favour_link").html("Избранное " + data.count);
        }
  });
};

HandyAjax.prototype.formSubmit = function(form){

  var params = $(form).serializeObject();

  params.submitAction = $(form).attr("action");

  this.request(arguments.callee, params, function(data){
      
      if(data.status == 'success'){
        $(form).parent().hide().find("input, textarea").val('');
        $("#cap_gen").click();
        alert('Ваше письмо успешно оправлено');
      
      }else{
        alert(data.user_error);
      }
  });
};

HandyAjax.prototype.contactToSeller = function(form){

  this.request(arguments.callee, $(form).serializeObject(), function(data){
      
      if(data.status == 'success'){
        $(".contact-form").hide().find("input, textarea").val('');
        $("#cap_gen").click();
        alert('Ваше письмо успешно оправлено');
      
      }else{
        alert(data.user_error);
      }
  });
};

HandyAjax.prototype.captcha = function(img){

   img.src = "/?method=captcha&AJAX_REQUEST=Y";
};

HandyAjax.prototype.ChangeCatView = function(viewvar){
    
    this.request(arguments.callee,{CAT_VIEW:viewvar},function(data){});
};

HandyAjax.prototype.sendDetailMail = function(){
    
    this.request(arguments.callee,{CAT_VIEW:viewvar},function(data){});
};