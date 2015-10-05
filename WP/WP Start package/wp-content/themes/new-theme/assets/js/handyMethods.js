/*HandyAjax.prototype.LoadMoreCategoryNews = function(curr_page){
    
    this.request(arguments.callee,{nextPage:curr_page+1},function(data){
        
        window.location.reload();
    });
};*/

var $ = $ || jQuery;

HandyAjax.prototype.captcha = function(img)
{
    var rand = getRandomInt(0,10000000000);
    img.src = "/?method=captcha&AJAX_REQUEST=Y&req=" + rand;
};

HandyAjax.prototype.logout = function()
{
  this.request(arguments.callee, {}, function(data){
        if(data.status != 'success'){
          alert(data.user_error);
          return false;
        }else{
          window.location.reload();
        }
  });
};

HandyAjax.prototype.formSubmit = function(form, clbk)
{
    var $ = $ || jQuery;
    clbk = clbk || function(){};
    var params = $(form).serializeObject();

    var action = $(form).attr("action");

    this.request(action, params, function(data){

        if(data.status == 'success'){


            clbk(data);
        }else{
            alert(data.user_error);
        }
    });
};

HandyAjax.prototype.addCalendarEvent = function(form)
{
    var $ = $ || jQuery;
    this.formSubmit(form, function(data)
    {
        $(form).html('<h4 style="color:green">Событие успешно добавлено!</h4>');

        setTimeout(function(){window.location.reload()}, 3000);
    });
}


HandyAjax.prototype.contactFormFeedback = function(form)
{
    this.formSubmit(form, function(data)
    {
        $(".alert-success").removeClass('hide').slideDown();
        $(".form-container").slideUp();

        setTimeout(function(){window.location.reload()}, 3000);
    });
}

HandyAjax.prototype.recoverPass = function(form)
{
    var input = $(form).find("input[name=email]").hide().after("<div style='text-align:center'><img src='/wp-content/themes/willad/images/ajax-loader.gif'></div>");


  this.request(arguments.callee, $(form).serializeObject(), function(data)
  {
        if(data.status == 'success')
        {            
            input.next().remove();
            input.after("<span style='color:green'>Письмо с новым паролем успешно отправлено на Вашу почту.</span>");
        }else{
            input.show().next().remove();

            var html = '';

            Object.keys(data.message.errors).forEach(function(item)
            {
                var item = data.message.errors[item];

                html += item[0] + '<br>';
            });
            $("#errors_area").html(html).fadeIn();

            setTimeout(function(){$("#errors_area").fadeOut()}, 4000);           
        }
  });
};

HandyAjax.prototype.login = function(form)
{
    this.request(arguments.callee, $(form).serializeObject(), function(data)
    {
        if(data.status == 'success')
        {            
            window.location = "/user?cabinet";
        }else{            

            var html = '';

            Object.keys(data.message.errors).forEach(function(item)
            {
                var item = data.message.errors[item];

                html += item[0] + '<br>';
            });
            $("#errors_area").html(html).fadeIn();

            setTimeout(function(){$("#errors_area").fadeOut()}, 4000);           
        }
    });
};

HandyAjax.prototype.registerUser = function(form)
{
    if($('input[name="pass"]').val() != $('input[name="pass_two"]').val())
    {
        alert("Пароли не совпадают!");
        return false;
    }


    this.request(arguments.callee, $(form).serializeObject(), function(data)
    {
        if(data.status == 'success')
        {            
            window.location = '/user?end-register-1';
        }else{

            var html = '';

            Object.keys(data.message.errors).forEach(function(item)
            {
                var item = data.message.errors[item];

                html += item[0] + '<br>';
            });
            $("#errors_area").html(html).fadeIn();

            setTimeout(function(){$("#errors_area").fadeOut()}, 4000);
            
            $("#cap_gen").click();
        }
    });

    return false;
};