jQuery(document).ready( function(){
    var reg, fielsVoid;
    var validator = new Object();
    validator.email = /^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/;
    validator.url = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
    validator.name =  /^[a-zA-Zа-яА-ЯёЁ ]+$/;
    validator.title = /^[a-zA-Zа-яА-ЯёЁ ]+$/;
    validator.login = /^[a-z0-9_-]{1,16}$/;
    validator.password = /^[a-zA-Zа-яА-ЯёЁ ]{1,20}$/;

    testFild = function(validator, reg) {


    validator.errors = false;

    if(validator.оbligatory) {
        if (!validator.field.val().replace(/\s+/g, '').length) {
            validator.errors = true;
        }
    }



     if(validator.confirm) {
         validator.field.closest('form').find('#'+validator.confirm).each(function(){
             if (validator.field.val() == $(this).val()) {
                 return validator.errors = false;
             } else {
                 return validator.errors = true;
             }
         })
     }


     if (!validator[reg].test(validator.field.val())) {
         validator.errors = true;
     }

     if(!validator.errors && validator.ajaxceck){
         var ajax,dataArray;
         var id = $('#send-form').find('#id-input').val();
         var name =  validator.field.attr('name');
         var field = {
             name : name,
             value: validator.field.val(),
             id: id
         };

         var str = JSON.stringify(field);

         ajax = $.ajax({
             type: "POST",
             url: validator.urlvalid,
             data: "data="+str,
             dataType: "text",
             async: false,
             success: function (data){data;}
        }).responseText;
         dataArray = $.parseJSON(ajax);
         validator.errors = dataArray.errors;
         $('.errorMessage').remove();
         $('<p class = "errorMessage">'+dataArray.message+'</p>').appendTo(validator.field.closest('.input-group'));

     }

     if ( !validator.errors) {
         console.log(validator.errors);
         return  validator.field.removeClass('valid-input').removeClass('error-input').addClass('valid');
     } else {
         console.log(validator.errors);
         return  validator.field.removeClass('valid').removeClass('error-input').addClass('error-input');
     }
    };

    $('.validate-input').on('keyup', function() {
        validator.field = $(this);
        reg = $(this).data('reg');
        validator.оbligatory = $(this).data('оbligatory');
        validator.ajaxceck = $(this).data('ajaxceck');
        validator.confirm = $(this).data('confirm');
        validator.urlvalid = $(this).closest('form').data("url");
        return testFild(validator, reg);
    });

    $('.validate-input').on('change', function() {
        validator.field = $(this);
        reg = $(this).data('reg');
        validator.оbligatory = $(this).data('оbligatory');
        validator.ajaxceck = $(this).data('ajaxceck');
        validator.confirm = $(this).data('confirm');
        validator.urlvalid = $(this).closest('form').data("url");
        return testFild(validator, reg);
    });

    $('#send-form').submit(function(event) {
        $(this).find('input').each(function(){
            if($(this).data('оbligatory')) {
                validator.field = $(this);
                reg = $(this).data('reg');
                validator.оbligatory = $(this).data('оbligatory');
                validator.ajaxceck = $(this).data('ajaxceck');
                validator.confirm = $(this).data('confirm');
                validator.urlvalid = $(this).closest('form').data("url");
                testFild(validator, reg);
            }
        });
        if($(this).find('.error-input').length){
            event.preventDefault();
            event.returnValue = false;
        }
    })

});
