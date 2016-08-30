$(document).ready(function(){
    $('.fertilizer-block-img img').width(function(i,val){
        $(this).css({marginLeft:-val / 2})
    });
    $('.plan-lending-circle-wrap a').click(function (e) {
        e.preventDefault();
    });

});




