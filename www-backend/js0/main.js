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


function getCookie() {
    var cookie = " " + document.cookie;
    var search = "menuStatus=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {

        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = cookie.substring(offset, end);
        }
    }
    return(setStr);
}

function showMenu() {
    var status = getCookie();
      if( status == 'full_main_menu') {
          $('.main_menu').addClass('display_none');
          $('.full_main_menu').removeClass('display_none');
      } else if (status == 'main_menu') {
          $('.full_main_menu').addClass('display_none');
          $('.main_menu').removeClass('display_none');
      }
}

function Filter() {
    var _filters = {};
    this.render = function ($parent) {
        $parent.empty();
        var html = '';
        forEach(_filters, function(element, key) {
            html += '<div style="display: inline-block; margin: 5px;"><h4>' + key + '</h4>';
            html += '<div>';
            forEach(element, function (v) {
                html += '<label><input type="checkbox" style="display:inline-block" id="' + v['id'] + '" value="' + v['filter_value_id'] +'">'
                    +  v['filter_value_value'] + '</label></input><br/>';
                $('body').on('change', '#' + v['id'], function() {
                    updateFilters(v['id']);
                });
            });

            html += '</div></div>';
        });
        $parent.append(html);

    };
    this.setFilters = function (filters) {
        _filters = filters;
    };

    this.getFilters = function () {
        var ids = [];
        forEach(_filters, function(element) {
            forEach(element, function (v) {
                if(v.checked)
                    ids.push(v.id);
            });
        });
        return ids;
    };

    function updateFilters (filter_id) {
        forEach(_filters, function(element) {
            forEach(element, function (v) {
                if(v.id == filter_id)
                    v.checked = !v.checked;
            });
        });
    }
}

function Catalog(catalog) {
    var _catalog = catalog;

    this.getCatalog = function() {
        return _catalog;
    };

    this.getSub = function getSub(catalog_id, catalog) {
        var result = null;
        forEach(catalog, function (element) {
            if(element.id == catalog_id) {
                result = element.sub;
            }
            if(element.sub) {
                var t = getSub(catalog_id, element.sub);
                result = t || result;
            }
        });
        return result;
    };

    this.renderSub = function (sub) {
        var select = '<select class="catalog" id="catalog">';
        select += '<option disabled selected label=" "></option>';
        forEach(sub, function (element) {
            select += '<option value="' + element.id + '">' + element.title + '</option>';
        });
        select += '</select>';
        return select;
    }
}

function generateCode(length) {
    var code = '';
    for(var i = 0; i < length; i++)
        code += Math.floor(Math.random() * 10);
    return code;
}

function forEach(obj, callback) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key)) {
            callback(obj[key], key);
        }
    }
}

$(document).ready(function()
{
    showMenu();

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
            document.cookie = "menuStatus=full_main_menu";

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
            document.cookie = "menuStatus=main_menu";
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

    $( 'textarea').each( function() {

        CKEDITOR.replace( $(this).attr('id') );

    });


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


    $("#uploadify").uploadify({
        'swf'    : '/js0/uploader/uploadify.swf',
        'uploader'     : '/downloadImages',
        'checkScript'  : '/js0/uploader/check-exists.php',
        'cancelImg'   : '/js0/uploader/uploadify-cancel.png',
        'queueID'    : 'fileQueue',
        'auto'      : true,
        'multi'     : true,
        'fileDesc'   : 'jpg',
        'fileExt'   : '*.jpg',
        'buttonText' : '  Загрузить Картинки  ',
        'formData'         : {'someKey' : 'someValue'},
        'onUploadStart' : function() {
            $("#uploadify").uploadify("settings", 'formData',{"directory": $('#directory').val()});
        },
        'onUploadSuccess' : function(file, data, response) {
            var ajax = $.parseJSON(data);
            $('#directory').val(ajax.directory);
            $('#uploadify').closest('.input_wrapper').append('<div>'+ajax.message+'</div>');
        }

    });

    ////////////////////////////////////////////////////////////////////////////
    $('#templates_block').on('change', function() {
        var id = $(this).val();
        $.post( '/email_templates_get_one_data',{id: id}, function(data) {
            var ajax = $.parseJSON(data);

            CKEDITOR.instances.template_text.updateElement();
            CKEDITOR.instances.template_text.setData(ajax.text);
            $('#template_title').val(ajax.title);
            $('#directory').val('');
            $('#template_name').val(ajax.name);
        });

    });


    $('.send_method').on('change', function() {

        if($('#send_method_to_all').prop("checked")){
            $('#send_method_users_table').css('display', 'none');
        }
        if($('#send_method_to_selected').prop("checked")){
            $('#send_method_users_table').css('display', 'block');
        }
    });

    $( "#utm_campaign" ).autocomplete({
        source: "/get_campaign_data",
        select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
            $(this).parents("tr").find(".input-categoryId").val(ui.item.value);
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
/////////////////////////////////////////////////////////////////////////////////////////
    $('#autocomplete_user_email').on('keyup', function() {
        var like =  $(this).val();

        if(like.length >9){
            $.post( '/get_product_like',{like: like}, function(data) {
                var ajax = $.parseJSON(data);
                var count = ajax.length;
                var block = $('#result');
                block.html('');
                for(var i = 0; i<count; i++){
                    var row ="<tr><td id='meta_title'>"+ajax[i]['meta_title']+"</td><td><p data-group-id='"+ajax[i]['group_id']+"' class = 'btn btn-primary select-row'>Добавить в список</p></td></tr>";
                    block.append(row);
                }
            });
        }
    });

    $('#autocomplete_user_email').on('change', function() {
        var like =  $(this).val();

        if(like.length >9){
            $.post( '/get_product_like',{like: like}, function(data) {
                var ajax = $.parseJSON(data);
                var count = ajax.length;
                var block = $('#result');
                block.html('');
                for(var i = 0; i<count; i++){
                    var row ="<tr><td id='meta_title'>"+ajax[i]['meta_title']+"</td><td><p data-group-id='"+ajax[i]['group_id']+"' class = 'btn btn-primary select-row'>Добавить в список</p></td></tr>";
                    block.append(row);
                }
            });
        }
    });


    $('#result').on('click','.select-row', function() {
        var group_id = $(this).data('group-id');
        console.log(group_id);
        var row = $(this).closest('tr');
        var block = $('#users-list');
        var name = row.find('#meta_title').html();
        var new_row ="<tr><td id='name'>"+name+"</td><td><p class = 'btn btn-primary delete-row'>Убрать из списка</p>" +
            "<input type='hidden' value='"+group_id+"' name='group_id[]'></td></tr>";
        block.append(new_row);
        row.remove();
    });

    $('#users-list').on('click','.delete-row', function() {
        var row = $(this).closest('tr');
        row.remove();
    });



/////////////////////////////////////////////////////////////////////////////////
});