jQuery(function($){
	$("#subscribe_email_btn").click(function(){

        var email = $("#subscribe_email").val();

        if(email.length > 0 )

        jQuery.get(
            "/wp-admin/admin-ajax.php?action=fs_subscribe&email="+ email,
             function(response) {
              
                if(response == "add_success") {

                  alert("Вы успешно подписались на рассылку.");
                }
                if(response == 'remove_success') {

                   alert("Вы успешно отписались от рассылки.");
                }

                if(response == 'error'){

                    ;alert('Ошибка обработки запроса. Попробуйте ввести корректную электронную почту.');
                }
             }
         );
    });
})