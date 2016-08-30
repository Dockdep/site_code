$( document ).ready(function() {
    $( ".blocks-p-email-02-1 input:radio" ).click(function() {
        var r1 = $('#theme-3-4');
        if($(r1).is(":checked")) {
           $('.email-set-area').css({display:'block'})
        } else {
            $('.email-set-area').css({display:'none'});
        }
    });
});