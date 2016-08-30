$('.lending_pic_p').css({opacity: 1});
$('.sales_box').hover(function(){
            $(this).find('.sales_box_price img').addClass("animated rubberBand");
            $(this).find('.end_sales').addClass('hover')
        },
        function(){
            $(this).find('.sales_box_price img').removeClass("animated rubberBand");
            $(this).find('.end_sales').removeClass('hover')
        }
    );
$('.user_tabs li a').click(function(){
        var currentAttrValue = jQuery(this).attr('href');
    $('.rewiew_text'+currentAttrValue).addClass('show').removeClass('hide').siblings().addClass('hide').removeClass('show');
    $(this).parent('li').addClass('active_user').siblings().removeClass('active_user');
        event.preventDefault();
    });

$('.why_block').hover(function(){
    $(this).find('img').toggleClass('borderImage');
});

    var jVal = {
        'fullName' : function() {
            var ele = $('.registration_box_name');
            if(ele.val().length < 2) {
                jVal.errors = true;

                $('.name_i').css({display:'block'});
            } else {
                $('.name_i').css({display:'none'});
            }
        },
        'phone' : function (){
            var ele = $('.registration_box_mail');
            var patt=/^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/;
            if(!patt.test(ele.val())) {
                jVal.errors = true;

                $('.mail_i').css({display:'block'});
            } else {
                $('.mail_i').css({display:'none'});
            }
        },
        'sendIt' : function (){

            if(!jVal.errors) {
                $('#jform1').submit();
            }
        }
    };
// ====================================================== //
    $('.send_button').click(function (){
        var obj = $('body');
        obj.animate({ }, 400, function (){
            jVal.errors = false;
            jVal.fullName();
            jVal.phone();
            jVal.sendIt();
        });
        return false;
    });
    $('.registration_box_name').change(jVal.fullName);
    $('.registration_box_mail').change(jVal.phone);

    var jVal1 = {
        'fullName' : function() {
            var ele = $('#sales_input');
            if(ele.val().length < 2) {
                jVal1.errors = true;

                $('.span_m').css({display:'inline-block'});
            } else {
                $('.span_m').css({display:'none'});
            }
        },
        'phone' : function (){
            var ele = $('#sales_input1');
            var patt=/^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/;
            if(!patt.test(ele.val())) {
                jVal1.errors = true;

                $('.span_e').css({display:'inline-block'});
            } else {
                $('.span_e').css({display:'none'});
            }
        },
        'sendIt' : function (){

            if(!jVal1.errors) {
                $('#jform2').submit();
            }
        }
    };
// ====================================================== //
    $('.sales_button').click(function (){
        var obj = $('body');
        obj.animate({ }, 400, function (){
            jVal1.errors = false;
            jVal1.fullName();
            jVal1.phone();
            jVal1.sendIt();
        });
        return false;
    });
    $('#sales_input').change(jVal1.fullName);
    $('#sales_input1').change(jVal1.phone);

    $('.link').bind("click", function(e){
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top-55
        }, 1000);
        e.preventDefault();
    });

$('.registration_box_footer a').click(function(e){
    e.preventDefault();
    $('.tooltip').toggleClass('tooltip_vis');
});
$('.cross_close').click(function(){
    $('.tooltip').removeClass('tooltip_vis');
});
$( ".registration_box_footer a , .tooltip" ).click(function(e) {
    e.stopPropagation();
    // Do something
});
$('body').click(function(){
    $('.tooltip').removeClass('tooltip_vis');
});


$(window).scroll(function() {
    var scrollTop = window.pageYOffset ? window.pageYOffset : (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
    if(scrollTop>=500){
        $('.menu').addClass('menu_fixed')
    }
    else{
        $('.menu').removeClass('menu_fixed')
    };
    if(scrollTop>=500 && scrollTop<=800){
        $('.active_menu').removeClass('active_menu');
        $('.f_b').addClass('active_menu');
    }
    if(scrollTop>=900 && scrollTop<=1200){
        $('.menu ul li').removeClass('active_menu');
        $('.s_b').addClass('active_menu');
    }
    if(scrollTop>=1229 && scrollTop<=1700){
        $('.menu ul li').removeClass('active_menu');
        $('.t_b').addClass('active_menu');
    }
    if(scrollTop>=1773 && scrollTop<=2050){
        $('.menu ul li').removeClass('active_menu');
        $('.fr_b').addClass('active_menu');
    }
    if(scrollTop>=2086){
        $('.menu ul li').removeClass('active_menu');
        $('.fv_b').addClass('active_menu');
    }
    if(scrollTop>=800){
        $('.why_block').addClass('bounceInUp');
    }
});
