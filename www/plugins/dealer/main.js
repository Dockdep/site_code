function p(val)
{
    console.info(val);
}

var val;

function get()
{
    getNovaPoshtaCity();
}

function getNovaPoshtaCity()
{
    $( "#order_city_novaposhta" ).autocomplete({
        source: function( request, response )
        {
            $.ajax({
                url: '/ajax/get_cities',
                data        :
                {
                    term    : request.term
                },
                scriptCharset: "utf-8",
                type : "POST",
                dataType: 'json',
                success: function( data )
                {
                    if( val == 1 )
                    {
                        response( data );
                        $('#loading_city').addClass('display_none');
                        $('.owner_city .description').addClass('display_none');
                    }
                },
                error: function()
                {
                    console.info('error');
                }
            })

                .fail(function()
                {
                    $( '.order_city_novaposhta .description' ).removeClass('display_none');
                    $( "#order_city_novaposhta" ).val('');
                    $('#loading_city').addClass('display_none');
                });

            $('#loading_city').removeClass('display_none');
        },
        minLength: 2,
        select: function( event, ui )
        {
            $( "#order_city_novaposhta" ).val( ui.item.value );
            $( "#order_city_ref" ).val( ui.item.ref );
            $('#loading_city').addClass('display_none');

            getNovaPoshtaOffice( ui.item.value );

            return false;
        }
    });
}

function getNovaPoshtaOffice( city )
{
    $('#loading_office').removeClass('display_none');
    $.ajax(
        {
            url: '/ajax/get_offices/',
            data        :
            {
                'city' : city
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                var html = '';
                if( data )
                {
                    for( var i in data )
                    {
                        html += '<option value="'+data[i]['number']+'-'+data[i]['address']+'" data-store_ref="'+data[i]['store_ref']+'">'+data[i]['address']+'</option>';
                    }

                    $('#store_address').html(html);
                    $('#loading_office').addClass('display_none');

                    var option = $('select#store_address option:selected').data('store_ref');

                    $( "#order_store_address_ref").val($('select#store_address option:selected').data('store_ref'));

                    $('#store_address').on(
                        'click',
                        function()
                        {
                            $( "#order_store_address_ref").val($('select#store_address option:selected').data('store_ref'));
                        });
                }
            },
            error: function()
            {
                console.info('error');
            }
        });
}





function add_item_for_compare( check, item_id )
{
    $.ajax(
        {
            url: '/ajax/add_item_for_compare',
            data        :
            {
                'check'     : check,
                'item_id'   : item_id
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {

                var html = '';

                if( data.length == 0 )
                {
                    $('.compare_wrapper').empty();

                }
                else
                {
                    var count = 0;
                    html +=
                        '<div class="compare"><a href="#" title="Список порівняння">Список порівняння </a></div>'+
                        '<div class="compare_list">'+
                        '<div class="compare"><a href="#" title="Список порівняння">Список порівняння </a></div>'+
                        '<ul>';

                    for( var i in data )
                    {
                        for( var j in data[i] )
                        {   var url = (data[i][j]['url']).substr(2);
                            var del_url = (data[i][j]['url_del']).substr(2);

                            html += '<li class="clearfix"><a href="'+url+'" title="" class="float">'+data[i][j]['title']+' '+data[i][j]['count']+'</a><a href="'+del_url+'" title="" class="float"><img src="/images/compare_del.jpg" alt="" height="8" width="8" /></a></li>';
                            count += data[i][j]['count'];
                        }
                    }

                    html += '</ul></div>'

                    $('.compare_wrapper').html(html);
                    $('.compare').html('<a href="#" title="Список порівняння">Список порівняння '+count+'</a>');

                    $('.compare').click(function(e)
                    {
                        e.preventDefault();

                        $('.compare_list').toggle();
                    });
                }
            },
            error: function(data, err)
            {
                console.error(data);
                console.error('error: ' + err);
            }
        });
}

function change_items( next_page, block_class, news_id )
{  console.log( next_page+', '+block_class+', '+news_id);
    $.ajax(
        {
            url: '/change_top_items/',
            data        :
            {
                'block_class' : block_class,
                'next_page'   : next_page,
                'news_id'     : news_id
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                var html = '';
                if( data.length )
                {
                    for( var i in data )
                    {
                        html +=
                            '<div class="one_item float '+( (i == 4) ? 'last' : '' )+'">'+
                            '<div class="one_item_image">'+
                            '<a href="'+data[i]['alias']+'" title="'+data[i]['title']+'">'+
                            '<img src="'+data[i]['cover']+'" alt="'+data[i]['title']+'" width="126" height="200" />'+
                            '</a>'+
                            '</div>'+
                            '<div class="one_item_title">'+
                            '<a href="'+data[i]['alias']+'" title="'+data[i]['title']+'">'+
                            '<h3>'+data[i]['title']+'</h3>'+
                            '</a>'+
                            '</div>'+
                            '<div class="align_bottom">'+
                            '<div class="one_item_price">ціна від ' +
                            '<span>'+parseFloat(data[i]['price2']).toFixed(2)+'</span> грн</div>'+
                            '<div class="one_item_buttons">'+
                            '<a href="'+data[i]['alias']+'" title="'+data[i]['title']+'" class="btn green">детальніше</a>'+

                            '</div>'+
                            '</div>'+
                            '</div>';
                    }

                    $('.'+block_class+' .items').html(html);

                    $('.one_item_compare').on(
                        'change',
                        function()
                        {
                            var check   = 0;
                            var item_id = $(this).find('input').val();

                            if( $(this).find('input').prop('checked') )
                            {
                                check = 1;
                            }

                            add_item_for_compare( check, item_id );
                        });
                }
            },
            error: function()
            {
                console.info('error');
            }
        });
}

function change_similar_items( catalog_id, group_id, similar )
{
    $.ajax(
        {
            url: '/change_similar_items',
            data        :
            {
                //'item_id'       : item_id,
                'catalog_id'    : catalog_id,
                'group_id'      : group_id,
                'similar'       : similar
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                var html = '';

                for( var i in data )
                {
                    html +=
                        '<div class="one_item float '+( (i == 4) ? 'last' : '' )+'">'+
                        '<div class="new_top clearfix">'+
                        (
                            data[i]['is_new'] == 1
                                ?
                            '<div class="float">'+
                            '<img src="/images/new.png" alt="Новинки" width="47" height="14" />'+
                            '</div>'
                                :
                                ''
                        )+
                        (
                            data[i]['is_top'] == 1
                                ?
                            '<div class="float">'+
                            '<img src="/images/top.png" alt="Топ продаж" width="63" height="14" />'+
                            '</div>'
                                :
                                ''
                        )+
                        '</div>'+
                        '<div class="one_item_image">'+
                        '<a href="'+ data[i]['alias'] +'" title="'+data[i]['title']+'">'+
                        '<img src="'+data[i]['cover']+'" alt="'+data[i]['title']+'" width="126" height="200" />'+
                        '</a>'+
                        '</div>'+
                        '<div class="one_item_title">'+
                        '<a href="'+ data[i]['alias'] +'" title="'+data[i]['title']+'">'+
                        '<h3>'+data[i]['title']+'</h3>'+
                        '</a>'+
                        '</div>'+
                        '<div class="one_item_description">'+
                        '<p>'+data[i]['description']+'</p>'+
                        '</div>'+
                        '<div class="align_bottom">'+
                        '<div class="one_item_price">ціна від <span>'+parseFloat(data[i]['price']).toFixed(2)+'</span> грн</div>'+
                        '<div class="one_item_buttons">'+
                        '<a href="'+ data[i]['alias'] +'" title="детальніше" class="btn green">детальніше</a>'+
                        '</div>'+
                        '<div class="one_item_compare">'+
                        '<input type="checkbox" id="compare_item_'+data[i]['id']+'" value="'+data[i]['type']+'-'+data[i]['catalog']+'-'+data[i]['id']+'" '+(data[i]['checked'] ? 'checked="checked"' : '')+' />'+
                        '<label for="compare_item_'+data[i]['id']+'"><span></span>до порівняння</label>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                }

                $('.other_items .items').html(html);

                $('.one_item_compare').on(
                    'change',
                    function()
                    {
                        var check   = 0;
                        var item_id = $(this).find('input').val();

                        if( $(this).find('input').prop('checked') )
                        {
                            check = 1;
                        }

                        add_item_for_compare( check, item_id );
                    });

            },
            error: function()
            {
                console.info('error1');
            }
        });
}

function change_price( value1, value2 )
{
    var sort_params = $('.sort_params').val();
    var a_href      = $('input.current_url').val();
    var href        = 'price-'+value1+'-'+value2;
    var alias       = a_href+'--'+href;

    if( sort_params != 0 )
    {
        alias = alias.replace( /\/\-\-/,'\/')+'/sort-'+sort_params;
    }

    $('.price_ok').attr( 'href', alias.replace( /\/\-\-/,'\/' ) );
}

function add_to_basket( item_id, count_items )
{
    $.ajax({
        url: '/basket/add_item',
        data        :
        {
            'item_id'       : item_id,
            'count_items'   : count_items
        },
        type : "POST",
        dataType: 'json',
        success: function (data)
        {
            if( data == '0' )
            {
                /*Confirm('Такий товар вже є у кошику', 'Кошик', function(yes) {
                 if(yes)
                 {
                 document.location='/basket';
                 }
                 });*/
            }
            else
            {
                $('.basket_number a').html(data);
            }
        },
        error: function()
        {
            console.info('error');
        }
    });
}

function change_count_basket( item_id, count_items )
{
    $.ajax({
        url: '/basket/change_count_basket',
        data        :
        {
            'item_id'       : item_id,
            'count_items'   : count_items
        },
        type : "POST",
        dataType: 'json',
        success: function (data)
        {

        },
        error: function()
        {
            console.info('error');
        }
    });
}


$(document).ready(function()
{
    ///////////////////////////////////////////////////////////////////////
    checkTotalPeice();


    $('.content_wrapper_header_menu').on(
        'click',
        '.thumbs',
        function(e)
        {
            e.preventDefault();

            $.cookie('view', 'thumbs');
            $('#content .subcategory_list').addClass('subcategory');
            $('#content div').removeClass('subcategory_list');

            $(this).addClass('active');

            $(this).parent().find('.lists').removeClass('active');
        });

    $('.content_wrapper_header_menu').on(
        'click',
        '.lists',
        function(e)
        {
            e.preventDefault();
            $.cookie('view', 'lists');
            $('#content .subcategory').addClass('subcategory_list');
            $('#content div').removeClass('subcategory');

            $(this).addClass('active');

            $(this).parent().find('.thumbs').removeClass('active');

        });

    ///////////////////////////////////////////////////////////////////////

    function contentSliderSlide()
    {
        $('.content_items').find('.content_arrow_right').each(function(){


            var block_class     = $(this).parent().parent().parent().data('class');
            var current_page    = parseInt( $('.'+block_class+' .page_number').text() );
            var max_page        = $(this).parent().find('span.max_page').text();
            var news_id         = $(this).parent().parent().parent().data('news_id') ? parseInt( $(this).parent().parent().parent().data('news_id') ) : '0';
            //p(block_class);
            if( current_page < max_page )
            {
                var next_page = current_page + 1;
                $('.'+block_class+' .page_number').text( next_page, block_class);

                change_items( next_page, block_class, news_id );
            } else {
                var next_page = 1;
                $('.'+block_class+' .page_number').text( next_page, block_class);

                change_items( next_page, block_class, news_id );
            }
        })
    }


    //setInterval(contentSliderSlide,10000);


    $('.content_items').on(
        'click',
        '.content_arrow_right',
        function(e)
        {
            e.preventDefault();


            var block_class     = $(this).parent().parent().parent().data('class');
            var current_page    = parseInt( $('.'+block_class+' .page_number').text() );
            var max_page        = $(this).parent().find('span.max_page').text();
            var news_id         = $(this).parent().parent().parent().data('news_id') ? parseInt( $(this).parent().parent().parent().data('news_id') ) : '0';
            //p(block_class);
            if( current_page < max_page )
            {
                var next_page = current_page + 1;
                $('.'+block_class+' .page_number').text( next_page, block_class);

                change_items( next_page, block_class, news_id );
            } else {
                var next_page = 1;
                $('.'+block_class+' .page_number').text( next_page, block_class);

                change_items( next_page, block_class, news_id );
            }
        });


    $('.content_items').on(
        'click',
        '.content_arrow_left',
        function(e)
        {
            e.preventDefault();

            var block_class     = $(this).parent().parent().parent().data('class');
            var current_page    = parseInt( $('.'+block_class+' .page_number').text() );
            var news_id         = $(this).parent().parent().parent().data('news_id') ? parseInt( $(this).parent().parent().parent().data('news_id') ) : '0';

            if( current_page > 1 )
            {
                var next_page = current_page - 1;
                $('.'+block_class+' .page_number').text( next_page, block_class);

                change_items( next_page, block_class, news_id );
            }
        });

    ///////////////////////////////////////////////////////////////////////

    $('.plus ').on(
        'click',
        function(e)
        {
            e.preventDefault();

            var count   = parseInt($(this).parent().find('.count_input input').val()) + 1;
            var item_id = $(this).parent().find('.count_input input').data('item_id');

            change_count_basket( item_id, count );

            $(this).parent().find('.count_input input').val(count);

            if( $(this).parent().hasClass('order_third_column') )
            {
                var price = parseFloat( $(this).parent().parent().find('.order_second_column').find('span').html() );
                var total = price*count;

                if( total%1 !== 0 )
                {
                    total = total.toFixed(1);
                }

                $(this).parent().parent().find('.order_fourth_column').find('span.price').html( total );

                var total_sum = 0;
                $('.order_second_column .price').each(function()
                {
                    total_sum = total_sum + parseFloat( $(this).parent().parent().find('.order_fourth_column').find('span.price').html() );

                    //total_sum = total_sum.toFixed(1);
                    $('.order_last span.price').html(total_sum.toFixed(1));
                    checkTotalPeice();
                });


            }
        });

    $('.minus ').on(
        'click',
        function(e)
        {
            e.preventDefault();

            var count_  = parseInt($(this).parent().find('.count_input input').val());
            var count   = count_ - 1;
            var item_id = $(this).parent().find('.count_input input').data('item_id');

            change_count_basket( item_id, count );

            if( count_ > 1 )
            {
                $(this).parent().find('.count_input input').val(count);

                if( $(this).parent().hasClass('order_third_column') )
                {
                    var price = parseFloat( $(this).parent().parent().find('.order_second_column').find('span').html() );
                    var total = price*count;

                    if( total%1 !== 0 )
                    {
                        total = total.toFixed(1);
                    }

                    $(this).parent().parent().find('.order_fourth_column').find('span.price').html( total );

                    var total_sum = 0;
                    $('.order_second_column .price').each(function()
                    {
                        total_sum = total_sum + parseFloat( $(this).parent().parent().find('.order_fourth_column').find('span.price').html() );

                        $('.order_last span.price').html(total_sum.toFixed(1));
                        checkTotalPeice();
                    });
                }
            }

        });

    $('.count_input input').on(
        'keyup',
        function(e)
        {
            e.preventDefault();

            var count   = $(this).val();
            var item_id = $(this).data('item_id');

            //p(count);

            change_count_basket( item_id, count );

            if( count > 1 )
            {
                if( $(this).parent().parent().hasClass('order_third_column') )
                {
                    var price = parseFloat( $(this).parent().parent().parent().find('.order_second_column').find('span').html() );
                    var total = price*count;

                    if( total%1 !== 0 )
                    {
                        total = total.toFixed(1);
                    }

                    $(this).parent().parent().parent().find('.order_fourth_column').find('span.price').html( total );

                    var total_sum = 0;
                    $('.order_second_column .price').each(function()
                    {
                        total_sum = total_sum + parseFloat( $(this).parent().parent().parent().find('.order_fourth_column').find('span.price').html() );

                        $('.order_last span.price').html(total_sum.toFixed(1));
                        checkTotalPeice();
                    });
                }
            }

        });

    function checkTotalPeice(){
        var val = $('span[id=total_price]').html();
        if(val>100){
            $('.min_price_message').css("display", "none");
        } else {
            $('.min_price_message').css("display", "block");
        }
    }



    $('#send_order').click(function(e) {
        e.preventDefault();
        var val = $('span[id=total_price]').html();

        console.log(val);

        if (val<100) {

            Confirm_low(' Мінімальна сума замовлення складає 100 гривень. Замовте ще!', 'Кошик', function (yes) {
                if (yes) {
                    document.location = '/';
                }
            })
        } else {
            $('form[name=order_add]').submit();

        }
    });


    ///////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////

    $('.item').on(
        'click',
        '.group_sizes',
        function(e)
        {
            if( $(this).hasClass( 'not_exist' ) )
            {
                return false;
            }

            e.preventDefault();
            var item_id         = $(this).data('item_id');
            var catalog_id      = $(this).data('catalog_id');
            var group_alias     = $(this).data('group_alias');

            $(this).parent().find('a.group_sizes').removeClass('active');

            $(this).addClass('active');

            $.ajax(
                {
                    url: '/change_with_size',
                    data        :
                    {
                        'item_id'       : item_id,
                        'catalog_id'    : catalog_id,
                        'group_alias'   : group_alias
                    },
                    type : "POST",
                    dataType: 'json',
                    success: function (data)
                    {
                        var html            = data['html'];
                        /*
                        for( var i in data )
                        {
                            html +=
                                '<div class="clearfix buy_compare">'+
                                '<div class="one_item_price float">ціна ' +
                                '<ul>' +
                                    '<li><span>'+ parseFloat(data[i]['price2']).toFixed(2) +'</span> грн</li>';
                            if(data[i]['price3'])
                                html += '<li><span>'+ parseFloat(data[i]['price3']).toFixed(2) +'</span> грн</li>';
                            if(data[i]['price4'])
                                html += '<li><span>'+ parseFloat(data[i]['price4']).toFixed(2) +'</span> грн</li>';
                            if(data[i]['price5'])
                                html += '<li><span>'+ parseFloat(data[i]['price5']).toFixed(2) +'</span> грн</li>';
                            html +=
                                '</ul>' +
                                '</div>'+
                                '<div class="one_item_buttons float">'+
                                ((data[i]['status_real']!=2)?'<a href="'+ data[i]['alias'] +'" title="" class="btn green" id="show_confirm">придбати</a>':'')+
                                '</div>'+
                                '<div class="one_item_compare float">'+
                                '<input type="checkbox" id="compare_item_'+ item_id +'" value="'+data[i]['type']+'-'+data[i]['catalog']+'-'+data[i]['id']+'" />'+
                                '<label for="compare_item_'+ item_id +'"><span></span>до порівняння</label>'+
                                '<input type="hidden" class="item_id_for_basket" value="'+ item_id +'">'+
                                '<input type="hidden" class="current_item_size" value="'+ data[i]['size'] +'">'+
                                '</div>'+
                                '</div>'+
                                '<div class="clearfix features">';

                            for( var j in data[i]['filters'] )
                            {
                                html +=
                                    '<a href="#" class="float">'+ data[i]['filters'][j]['value_value'] +'</a>';
                            }

                            html +=
                                '</div>';

                            $('.item_images .thumbnails').html(data[i]['image']);
                            $('.presence_status').html(data[i]['status']);
                            $('.properties_article').html(data[i]['product_id']);
                            $('.colors').html(data[i]['color']);
                        }
                        */
                        $('.item_images .thumbnails').html(data['image']);
                        $('.presence_status').html(data['status']);
                        $('.properties_article').html(data['product_id']);
                        $('.colors').html(data['color']);
                        $('.change_with_size').html(html);

                        $('.thumbnail').iLightBox(
                            {
                                skin: 'metro-black',
                                path: 'horizontal',
                                maxScale: 1.3,
                                overlay: {
                                    opacity: .8
                                },
                                styles: {
                                    nextOffsetX: 75,
                                    nextOpacity: .55,
                                    prevOffsetX: 75,
                                    prevOpacity: .55
                                },
                                thumbnails: {
                                    normalOpacity: .9,
                                    activeOpacity: 1
                                },
                                controls: {
                                    thumbnail: 1,
                                    arrows: 1
                                }
                            });


                        $('#show_confirm').click(function(e) {
                            var inStock = $('#stock').data('stock');

                            console.log(inStock);
                            e.preventDefault();

                            if (!inStock) {

                                var count_items = $('.count_input .count_items').val();
                                add_to_basket(item_id, count_items);

                                Confirm('Ви замовляєте товар, який на сьогоднішній день<br><b>відсутній на складі</b>. Будь ласка,<br> узгодьте термін доставки даного товару.', 'Кошик', function (yes) {
                                    if (yes) {
                                        document.location = '/basket';
                                    }
                                })
                            } else {

                                var count_items = $('.count_input .count_items').val();
                                add_to_basket(item_id, count_items);

                                Confirm('Ви додали товар до кошика', 'Кошик', function (yes) {
                                    if (yes) {
                                        document.location = '/basket';
                                    }
                                })
                            }
                        });

                    },
                    error: function()
                    {
                        console.info('error');
                    }
                });
        });
		
$('.group_sizes:first').click();
    ///////////////////////////////////////////////////////////////////////

    $('.item').on(
        'click',
        '.change_with_color',
        function(e)
        {
            e.preventDefault();
            var item_id             = $(this).data('item_id');
            var type_id             = $(this).data('type_id');
            var subtype_id          = $(this).data('subtype_id');
            var group_id            = $(this).data('group_id');
            var group_alias         = $(this).data('group_alias');
            var color_id            = $(this).data('color_id');
            var current_item_size   = $('.current_item_size').val();

            $('.change_with_color a').removeClass('active');
            $('.change_with_color a').css('border-color', '#e2e2e2');

            $(this).find('a').addClass('active');


            $.ajax(
                {
                    url: '/change_with_color',
                    data        :
                    {
                        'item_id'           : item_id,
                        'type_id'           : type_id,
                        'subtype_id'        : subtype_id,
                        'group_id'          : group_id,
                        'group_alias'       : group_alias,
                        'color_id'          : color_id,
                        'current_item_size' : current_item_size
                    },
                    type : "POST",
                    dataType: 'json',
                    success: function (data)
                    {
                        var html            = '';

                        for( var i in data )
                        {
                            html +=
                                '<div class="clearfix buy_compare">'+
                                '<div class="one_item_price float">ціна <span>'+ parseFloat(data[i]['price2']).toFixed(2) +'</span> грн</div>'+
                                '<div class="one_item_buttons float">'+
                                '<a href="'+ data[i]['alias'] +'" title="" class="btn green" id="show_confirm">придбати</a>'+
                                '</div>'+
                                '<div class="one_item_compare float">'+
                                '<input type="checkbox" id="compare_item_'+ item_id +'" value="'+type_id+'-'+subtype_id+'-'+ item_id +'" />'+
                                '<label for="compare_item_'+ item_id +'"><span></span>до порівняння</label>'+
                                '<input type="hidden" class="item_id_for_basket" value="'+ item_id +'">'+
                                '<input type="hidden" class="current_item_size" value="'+ data[i]['size'] +'">'+
                                '</div>'+
                                '</div>'+
                                '<div class="clearfix features">';

                            for( var j in data[i]['filters'] )
                            {
                                html +=
                                    '<a href="#" class="float">'+ data[i]['filters'][j]['value_value'] +'</a>';
                            }

                            html +=
                                '</div>';

                            $('.item_images .thumbnails').html(data[i]['image']);
                            $('.presence_status').html(data[i]['status']);
                            $('.properties_article').html(data[i]['product_id']);
                            $('.colors').html(data[i]['color']);
                            $('.packing_images').html(data[i]['sizes']);
                            $('.item_properties').html(data[i]['properties']);

                            if( $('.change_with_color a').hasClass('active') )
                            {
                                $('.change_with_color a.active').css('border-color', data[i]['absolute_color']);
                            }
                        }

                        $('.change_with_size').html(html);


                        $('#show_confirm').click(function(e) {
                            var inStock = $('#stock').data('stock');

                            console.log(inStock);
                            e.preventDefault();

                            if (!inStock) {

                                var count_items = $('.count_input .count_items').val();
                                add_to_basket(item_id, count_items);

                                Confirm('Ви замовляєте товар, який на сьогоднішній день<br> відсутній на складі, будь ласка, після замовлення<br> узгодьте термін доставки товару.', 'Кошик', function (yes) {
                                    if (yes) {
                                        document.location = '/basket';
                                    }
                                })
                            } else {

                                var count_items = $('.count_input .count_items').val();
                                add_to_basket(item_id, count_items);

                                Confirm('Ви додали товар до кошика', 'Кошик', function (yes) {
                                    if (yes) {
                                        document.location = '/basket';
                                    }
                                })
                            }
                        });
                    },
                    error: function()
                    {
                        console.info('error');
                    }
                });
				
        });

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

    function dialogue(content, title) {
        content = $('<div />', {
            'class': 'dialogue clearfix'
        }).append(content);

        $.iLightBox([
                {
                    URL: content,
                    type: "html",
                    title: (title) ? title : null
                }
            ],
            {
                skin: 'light ilightbox-dialogue',
                minScale: 1,
                innerToolbar: true,

                overlay: {
                    blur: false
                },
                controls: {
                    fullscreen: false
                },
                callback: {
                    // Hide the iLightBox when any buttons in the dialogue are clicked
                    onRender: function(api) {
                        $('.btn', api.currentElement).click(function(){
                            $('.btn', api.currentElement).unbind('click');
                            api.hide();
                        });
                    },
                    // Hide the iLightBox when any buttons in the dialogue are clicked
                    onShow: function(api) {
                        $('.btn-primary', api.currentElement).focus();
                    }
                }
            });
    }


	function videoConfirm(callback){
            var message = $('<div />', { html: '<iframe width="560" height="315" src="https://www.youtube.com/embed/WR3kUJ6p3eE" frameborder="0" allowfullscreen></iframe>' }),
            cancel = $('<button />', {
                html: "Закрить",
                'class': 'btn alert_button',
				'style': 'display:block;margin:0px auto;width:150px;',
                click: function() { callback(false); }
            });
		dialogue( message.add(cancel), "Потрібна допомога?", function() { callback(false); } );
	}	
    function Confirm(question, title, callback)
    {
        // Content will consist of the question and ok/cancel buttons
        var message = $('<div />', { html: question }),
            ok = $('<button />', {
                html: "Перейти до кошику",
                'class': 'btn btn-primary alert_button',
                click: function() { callback(true); },
                keyup: function(e){
                    if(e.keyCode == 13) $(this).trigger('click');
                }
            }),
            cancel = $('<button />', {
                html: "Продовжити покупки",
                'class': 'btn alert_button',
                click: function() { callback(false); }
            });
            video = $('<button />', {
                html: "Потрібна допомога?",
                'class': 'btn alert_button',
				'style': 'display:block;margin:0px auto;width:200px;',
                click: function() { callback(false);videoConfirm(callback); }
            });
        dialogue( message.add(cancel).add(ok).add(video), title, function() { callback(false); } );
    }

    function Confirm_low(question, title, callback)
    {
        // Content will consist of the question and ok/cancel buttons
        var message = $('<p />', { html: question }),
            ok = $('<button />', {
                html: "Продовжити покупки",
                'class': 'btn btn-primary alert_button',
                click: function() { callback(true); },
                keyup: function(e){
                    if(e.keyCode == 13) $(this).trigger('click');
                }
            }),
            cancel = $('<button />', {
                html: "Залишитись в кошику",
                'class': 'btn alert_button',
                click: function() { callback(false); }
            });


        dialogue( message.add(cancel).add(ok), title, function() { callback(false); } );
    }

    function Alert(message, title)
    {
        // Content will consist of the message and an ok button
        var message = $('<p />', { html: message, 'class': 'dialogue_message' }),
            ok = $('<button />', { html: "OK", 'class': 'btn btn-primary alert_button', keyup: function(e){
                if(e.keyCode == 13) $(this).trigger('click');
            }
            });

        dialogue( message.add(ok) , title);
    }

    $('#show_confirm').click(function(e)
    {
        e.preventDefault();

        $(this).text('у кошику');

        var item_id     = $('.item_id_for_basket').val();
        var count_items = $('.count_input .count_items').val();

        $.ajax({
            url: '/basket/add_item',
            data        :
            {
                'item_id'       : item_id,
                'count_items'   : count_items
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                if( data == '0' )
                {
                    Confirm('Такий товар вже є у кошику', 'Кошик', function(yes) {
                        if(yes)
                        {
                            document.location='/basket';
                        }
                    });
                }
                else
                {
                    $('.basket_number a').html(data);
                }
            },
            error: function()
            {
                console.info('error');
            }
        });


        var inStock = $('#stock').data('stock');

        console.log(inStock);
        e.preventDefault();

        if (!inStock) {

            var count_items = $('.count_input .count_items').val();
            add_to_basket(item_id, count_items);

            Confirm('Ви замовляєте товар, який на сьогоднішній день<br> відсутній на складі, будь ласка, після замовлення<br> узгодьте термін доставки товару.', 'Кошик', function (yes) {
                if (yes) {
                    document.location = '/basket';
                }
            });
        } else {

            var count_items = $('.count_input .count_items').val();
            add_to_basket(item_id, count_items);

            Confirm('Ви додали товар до кошика', 'Кошик', function (yes) {
                if (yes) {
                    document.location = '/basket';
                }
            });
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('.order_fifth_column a').click(function(e)
    {
        e.preventDefault();

        var item_id     = $(this).data('item_id');

        $.ajax({
            url: '/basket/delete_item',
            data        :
            {
                'item_id'       : item_id
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                if( data == '0' )
                {
                    document.location = '/';
                }
                else
                {
                    $('.basket_number a').html(data);
                    document.location = '/basket';
                }
            },
            error: function()
            {
                console.info('error');
            }
        });
    });

    ///////////////////////////////////////////////////////////////////////

    if( window.location.pathname=='/' )
    {
        var results_order = document.cookie.match( '(^|;) ?order=([^;]*)(;|$)' );
        var results_callback = document.cookie.match( '(^|;) ?callback=([^;]*)(;|$)' );

        if( results_order && results_order[2] == 1 )
        {
            document.cookie = "order=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
            Alert('Ви успішно оформили замовлення', 'Кошик');
        }

        if( results_callback && results_callback[2] == 1 )
        {
            document.cookie = "callback=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
            Alert('Ви успішно відправили повідомлення', 'Зворотній зв\'язок');
        }
    }

    ///////////////////////////////////////////////////////////////////////

    $('.order_fifth_column a').click(function(e)
    {
        e.preventDefault();

        var item_id     = $(this).data('item_id');

        $.ajax({
            url: '/basket/delete_item',
            data        :
            {
                'item_id'       : item_id
            },
            type : "POST",
            dataType: 'json',
            success: function (data)
            {
                if( data == '0' )
                {
                    document.location = '/';
                }
                else
                {
                    $('.basket_number a').html(data);
                    document.location = '/basket';
                }
            },
            error: function()
            {
                console.info('error');
            }
        });
    });

    ///////////////////////////////////////////////////////////////////////

    $('.cabinet .my_orders').click(function(e)
    {
        e.preventDefault();

        $('.toggle').toggle();
    });

    $('.compare').click(function(e)
    {
        e.preventDefault();

        $('.compare_list').toggle();
    });

    ///////////////////////////////////////////////////////////////////////





    ///////////////////////////////////////////////////////////////////////

    $(".bind").click(function()
    {
        val = 1;

        $('.owner_city').addClass('display_none');
        $('.order_city_novaposhta').removeClass('display_none');

        if( $(this).val() == 3 )
        { 

			$('.owner_address').addClass('display_none');
            $('.store_address').removeClass('display_none');
            $('.owner_address_s').addClass('display_none');

        }
        else
        {
            $('.store_address').addClass('display_none');
            $('.owner_address').removeClass('display_none');
            $('.owner_address_s').addClass('display_none');
        }

        get();

        $( '.owner_city .description' ).addClass('display_none');
    });

    $(".unbind").click(function()
    {
        val = 2;

        $('.order_city_novaposhta').addClass('display_none');
        $('.store_address').addClass('display_none');
		$('.address_mark').addClass('display_none');

        if( $(this).val() == 1 )
        {
            $('.owner_city').addClass('display_none');
            $('.owner_address').addClass('display_none');
            $('.owner_address_s').addClass('display_none');
        }
        else if($(this).val() == 10){
            $('.owner_city').removeClass('display_none');
            $('.owner_address_s').removeClass('display_none');
            $('.owner_address').addClass('display_none');
        }
        else if($(this).val() == 7 || $(this).val() == 9 || $(this).val() == 11 || $(this).val() == 12)
        { 
            $('.owner_city').addClass('display_none');
            $('.owner_address').removeClass('display_none');
			$('.address_mark').removeClass('display_none');
            $('.owner_address_s').addClass('display_none');
        }		
        else
        {
            $('.owner_city').removeClass('display_none');
            $('.owner_address').removeClass('display_none');
            $('.owner_address_s').addClass('display_none');
        }

        $( '.owner_city .description' ).addClass('display_none');
    });

    ///////////////////////////////////////////////////////////////////////

    $( "#search_item" ).autocomplete({
        source: function( request, response )
        {
            $.ajax({
                url: '/ajax/get_items',
                data        :
                {
                    term    : request.term
                },
                scriptCharset: "utf-8",
                type : "POST",
                dataType: 'json',
                success: function( data )
                {
                    $('.site_search').addClass('active');
                    if( data.length )
                    {
                        var html = '<ul class="search_result clearfix">';

                        for( var i in data )
                        {
                            html +=
                                '<li class="clearfix">'+
                                '<a href="'+data[i]['alias']+'" title=""><img src="'+data[i]['cover']+'" height="100" alt="'+data[i]['title']+'" /></a>'+
                                '<a href="'+data[i]['alias']+'" class="search_result_title" title="'+data[i]['title']+'">'+data[i]['title']+'</a>'+
                                '<p class="search_result_price">ціна від <span class="price">'+data[i]['price2']+'</span> грн</p>'+
                                '</li>';
                        }

                        html += '</ul><a href="/search/'+request.term+'" title="" class="all_search_result">Всі результати пошуку</a>';

                        $('.search_result_display').html(html);
                    }
                    else
                    {
                        $('.search_result_display').html('<p class="no_search_result">Немає товарів за цим запитом</p>');
                    }
                },
                error: function()
                {
                    console.info('error');
                }
            })

                .fail(function()
                {

                });

            $('#loading_city').removeClass('display_none');
        },
        minLength: 2,
        select: function( event, ui )
        {
            //$( "#order_city_novaposhta" ).val( ui.item.value );

            //$('#loading_city').addClass('display_none');

            return false;
        }


    });


    $(document).click(function(e) {
        var target = e.target;

        if ( !$(target).is('.search_result_wrapper') && !$(target).is('#search_item') )
        {
            $('.site_search').removeClass('active');
        }
        else
        {
            $('.site_search').addClass('active');
        }
    });

    ///////////////////////////////////////////////////////////////////////
    $('body').on('change','.one_item_compare', function() {

            var check   = 0;
            var item_id = $(this).find('input').val();

            if( $(this).find('input').prop('checked') )
            {
                check = 1;
            }

            add_item_for_compare( check, item_id );
        });

    ///////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////

    $('.one_video_title').on(
        'click',
        function(e)
        {
            //e.preventDefault();

            var src = $(this).data('video_srs');
            //$('.video_iframe').attr('src', src);
        });

    ///////////////////////////////////////////////////////////////////////


    var getTop = function(obj){
        var height_odj = +obj.css('height').replace('px','') + 30;
        return height_odj;
    };

    $('.question_mark').hover(function(){
        var obj = $(this).siblings('.additional_info');
        var new_top = getTop(obj);
        obj.css("top",'-'+new_top+'px');
        obj.stop(false, true).fadeIn(300);
    }, function(){
        $(this).siblings('.additional_info').stop(false, true).fadeOut(300);
    });
    $('.additional_info').hover(function(){
        $(this).stop(false, true).fadeIn(300);
    }, function(){
        $(this).stop(false, true).fadeOut(300);
    });


    $('.subscription-wr-all').delay(29970).toggle(600);
    $('.sub-closed').click(function(){
        $('.subscription-wr-all').toggle(450);
    });

    var jVal = {
        'fullName' : function() {
            var ele = $('#fullname');
            if(ele.val().length < 2) {
                jVal.errors = true;
                $('.sub-sale-forma-blocks-name-first').removeClass('normal').addClass('wrong');
            } else {
                $('.sub-sale-forma-blocks-name-first').removeClass('wrong').addClass('normal');
            }
        },
        'email' : function() {
            var ele = $('#email');
            var patt = /^.+@.+[.].{2,}$/i;
            if(!patt.test(ele.val())) {
                jVal.errors = true;
                $('.sub-sale-forma-blocks-name').removeClass('normal').addClass('wrong');
            } else {
                $('.sub-sale-forma-blocks-name').removeClass('wrong').addClass('normal');
            }
        },
        'sendIt' : function (){
            if(!jVal.errors) {
                $('#jform').submit();
            }
        }
    };
// ====================================================== //
    $('#send').click(function (){
        var obj = $.browser.webkit ? $('body') : $('html');
        obj.animate({ scrollTop: $('#jform').offset().top }, 750, function (){
            jVal.errors = false;
            jVal.fullName();
            jVal.email();
            jVal.sendIt();
        });
        return false;
    });
    $('#fullname').change(jVal.fullName);
    $('#email').change(jVal.email);
});
