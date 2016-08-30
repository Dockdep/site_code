$(document).ready(function(){
    $('.fertilizer-block-img img').width(function(i,val){
        $(this).css({marginLeft:-val/2})
    });
    $('.form-arrows-right-wr').hover(function(){
        $(this).css({background:'url("form-img/form-arrows.jpg") -10px -18px no-repeat'})
    }, function(){
        $(this).css({background:'url("form-img/form-arrows.jpg") -10px 0 no-repeat'})
    })
    $('.form-arrows-left-wr').hover(function(){
        $(this).css({background:'url("form-img/form-arrows.jpg") 0 -18px no-repeat'})
    }, function(){
        $(this).css({background:'url("form-img/form-arrows.jpg") 0 0 no-repeat'})
    })
});




