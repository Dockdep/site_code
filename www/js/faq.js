/*
$(document).ready(function () {
    $('ul.questions_ li .questions_a a').click(function (e) {
        e.preventDefault()
        $('ul.questions_ li').removeClass('active')
        $(this).parent().parent().addClass('active')
        $(this).find('.title_new').remove()
        var thisOffset = $(this).parent().parent().offset().top
        $('body, html').animate({scrollTop: thisOffset},400);
    })
    var longQuestions = $('.questions_ li .questions_a a')
    for (var i=0; i<longQuestions.length; i++) {
        if(($(longQuestions[i]).html().length)>=118) {
            $(longQuestions[i]).parent().addClass('long_')
            $(longQuestions[i]).attr('data-title',$(longQuestions[i]).text())
        }
    }
    $('ul.questions_ li .questions_a.long_ > a').hover(function () {
        var newTitle = $(this).attr('data-title')
        $(this).parent().parent().append('<div class=\"title_new\">'+newTitle+'</div>')
    },function () {
        $(this).parent().parent().find('.title_new').remove()
    })
*/