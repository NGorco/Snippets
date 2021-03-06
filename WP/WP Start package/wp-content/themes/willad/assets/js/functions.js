(function($) {
    "use strict";
    
    // Navigation slide down
    $("#menu .nav li").hover(function(){
        $(this).find('.dropnav-container, .subnav-container').slideDown(300);
    },function(){
        $(this).find('.dropnav-container, .subnav-container').hide();
    });
    
    // Subnav article loader
    $('#menu .subnav-menu li').hover(function() {
        $(this).parent().find('li').removeClass('current');
        $(this).addClass('current');
    });
    
    // Navigation Menu Expander
    $('#nav-expander').sidr({
        side: 'right'
    });
    
    $('#sidr li a.more').click(function(e) {
        e.preventDefault();
        $(this).parent().find('ul').toggle();
    });
    
    // Homepage slider
    $('#slider-carousel').carouFredSel({
        width: '100%',
        height: 'auto',
        prev: '#slider-prev',
        next: '#slider-next',
        auto: false,
        responsive: true,
        transition: true,
        swipe: {
                onMouse: true,
                onTouch: true
        },
        scroll : {
            items           : 1,
            easing          : "quadratic",
            duration        : 1000,                         
            pauseOnHover    : true
        }      
    });
    
    // Init photobox
    $('#weekly-gallery').photobox('a',{ time:0 });
    $('#article-gallery').photobox('a',{ time:0 });
    
    // Init datepicker for archive page
    $('#archive-date-picker').datepicker({
        format: 'mm/dd/yyyy'
    });
    
    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
    
    //Contact form
    var contactForm = $('#contactForm');
    var successForm = $('.alert-success', contactForm);
    var errorForm = $('.alert-danger', contactForm);

    if (typeof $.fn.validate === 'function') {
        $("#contactForm").validate({
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "mail/contact.php",
                    data: $(form).serialize(),
                    success: function () {
                        successForm.removeClass('hide').show();
                        errorForm.hide(); 
                    },
                    error: function() {
                        errorForm.removeClass('hide').show();
                        successForm.hide(); 
                    }
                 });
                 return false;           
            }
        });
    }
    
})(jQuery);