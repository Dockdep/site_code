function p(val)
{
    console.info(val);
}

function translit( text )
{
    var space   = '-';

    var i       = 0;


    var transl = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
        'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
        ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
        '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
        '(': space, ')': space,'-': space, '=': space, '+': space, '[': space,
        ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
        '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
        '?': space, '<': space, '>': space, '№':space,
        'і': 'i', 'ї':'yi', 'є':'ye'
    }

    var result = '';
    var curent_sim = '';

    for(i=0; i < text.length; i++)
    {
        if(transl[text[i]] != undefined)
        {
            if(curent_sim != transl[text[i]] || curent_sim != space)
            {
                result += transl[text[i]];
                curent_sim = transl[text[i]];
            }
        }
        else
        {
            result += text[i];
            curent_sim = text[i];
        }
    }

    result = TrimStr(result);

    return result;

}
function TrimStr(s)
{
    s = s.replace(/^-/, '');
    return s.replace(/-$/, '');
}





$(document).ready(function()
{
    ///////////////////////////////////////////////////////////////////////

    $('#profiler span.profiler-sql-show').on(
        'click',
        function(e)
        {
            e.preventDefault()

            if( $('#profiler-sql').is( ':visible' ) )
            {
                $('#profiler-sql').hide();
            }
            else
            {
                $('#profiler-sql').show();
            }
        }
    );

    ///////////////////////////////////////////////////////////////////////

    $('#admin_login').validate({
        rules: {
            email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            email: {
                required: "Пожалуйста, введите email",
                minlength: "Email должен содержать как минимум 3 символа",
                maxlength: "Длина email больше максимальной",
                email: "Пожалуйста, введите валидный email"
            },
            passwd: {
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать как минимум 3 символа",
                maxlength: "Длина пароля больше максимальной"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('.main_menu').on(
        'click',
        ('.point1'),
        function(e)
        {
            e.preventDefault();

            $('.main_menu').addClass('display_none');
            $('.full_main_menu').removeClass('display_none');
        }
    );

    $('.full_main_menu').on(
        'click',
        ('.point1'),
        function(e)
        {
            e.preventDefault();

            $('.full_main_menu').addClass('display_none');
            $('.main_menu').removeClass('display_none');
        }
    );

    ///////////////////////////////////////////////////////////////////////

    $('.sidebar').on(
        'click',
        ('.head'),
        function(e)
        {
            e.preventDefault();

            if( $(this).next().hasClass('display_none') )
            {
                $(this).next('.body').removeClass('display_none');
            }
            else
            {
                $(this).next('.body').addClass('display_none');
            }
            //$('.main_menu').removeClass('display_none');
        }
    );

    ///////////////////////////////////////////////////////////////////////

    $('#addEdit').on(
        'click',
        ('.change_lang'),
        function(e)
        {
            var lang = $(this).val();

            if( lang == 1 )
            {
                $('.version_1').removeClass('display_none');
                $('.version_2').addClass('display_none');
            }
            else
            {
                $('.version_2').removeClass('display_none');
                $('.version_1').addClass('display_none');
            }
        }
    );

    ///////////////////////////////////////////////////////////////////////

    /*$('#page_content_text_1').redactor({
        toolbarFixedBox: true,
        buttons: ['bold', 'italic', 'deleted', '|',
            'unorderedlist', 'orderedlist', '|',
            'table', 'link', '|', 'alignment', '|', 'html', '|', 'image'],
        autoresize: true,
        minHeight: 300
       // allowedTags: ['p', 'b', 'strong', 'i', 'em', 'ul', 'ol', 'li', 'table', 'tr', 'td', 'th', 'a', 'br' ]
    });

    $('#page_content_text_2').redactor({
        toolbarFixedBox: true,
        buttons: ['bold', 'italic', 'deleted', '|',
            'unorderedlist', 'orderedlist', '|',
            'table', 'link', '|', 'alignment', '|', 'html', '|', 'image'],
        autoresize: true,
        minHeight: 300,
        allowedTags: ['p', 'b', 'strong', 'i', 'em', 'ul', 'ol', 'li', 'table', 'tr', 'td', 'th', 'a', 'br' ]
    });

    */

    CKEDITOR.replace("page_content_text_1");
    CKEDITOR.replace("page_content_text_2");



    /*

    $('#news_add_edit').on(
        'click',
        '.news_submit',
        function(e)
        {
            //e.preventDefault();
            var html = $('#page_content_text_1').redactor('get');

            p(html);

            $('.page_content_text_1').html(html);
            //var content = $('#post_content').text();



            if( content.length <1 || title.length <1 )
            {
                if( content.length <1 )
                {
                    $('#post_add .redactor_box').addClass('error');
                }
                if( title.length <1 )
                {
                    $('#post_add #post_title').addClass('error');
                }

                return false;
            }



            return true;
        }
    );
*/
    ///////////////////////////////////////////////////////////////////////

    /*
    $('#news_add_edit').validate({
        rules: {
            "page_title[1]": {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            page_content_text: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            page_title: {
                required: "Пожалуйста, заполните поле",
                minlength: "Поле должно содержать как минимум 3 символа",
                maxlength: "Длина поля больше максимальной"
            },
            page_content_text: {
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать как минимум 3 символа",
                maxlength: "Длина пароля больше максимальной"
            }
        }
    });

    */

    ///////////////////////////////////////////////////////////////////////

    $('#page_title_1').keyup(function()
    {
        var text    = $(this).val().toLowerCase();
        var result  = translit(text);

        $('#page_alias_1').val( '/'+result );
    });

    $('#page_title_2').keyup(function()
    {
        var text    = $(this).val().toLowerCase();
        var result  = translit(text);

        $('#page_alias_2').val( '/'+result );
    });

    ///////////////////////////////////////////////////////////////////////

})