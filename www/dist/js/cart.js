$('[data-toggle="popover"]').popover();

calculateFirmTotal();

calculateFirmRemain();

var $order = $('#order');

var $preorder = $('#preorder');

var delOrderItem = function (item_id) {
    $.ajax({
        url: '/basket/delete_item',
        data: {
            'item_id': item_id
        },
        type: "POST",
        dataType: 'json',
        success: function () {
        },
        error: function (e) {
            console.error(e);
        }
    });
};

var delPreOrderItem = function (item_id) {
    $.ajax({
        url: '/dealer/delete_preorder_item',
        data: {
            'item_id': item_id
        },
        type: "POST",
        dataType: 'json',
        success: function () {
        },
        error: function (e) {
            console.error(e);
        }
    });
};

var addOrderItem = function (item_id, count_items) {
    $.ajax({
        url: '/basket/add_item',
        data: {
            'item_id': item_id,
            'count_items': count_items
        },
        type: "POST",
        success: function () {
        },
        error: function (e) {
            console.error(e);
        }
    });
};

$('body, .popup_window').on('click', '.delete_but', function (e) {
    e.preventDefault();
    var $table_parent = $(this).parent().parent().parent();
    var $item = $(this).parent().parent();
    if ($item.attr('data-status') == 'order')
        delOrderItem($item.attr('data-id'));
    else
        delPreOrderItem($item.attr('data-id'));
    $item.remove();
    calculateTotalPrice($table_parent);
    calculateFirmTotal();
    calculateFirmRemain();
});


$('body, .popup_window').on('click', ".minus_button", function (e) {
    e.preventDefault();
    var $item = $(this).parents('.table_line');
    var $item_num = $(this).parent().find(".item_num");
    var a = $item_num.val();
    if (a != 1) {
        $item_num.val(--a);
        change_count_basket($item.data('id'), a);
        calculateSumPrice($item_num);
        calculateFirmTotal();
        calculateFirmRemain();
    }
});

$('body, .popup_window').on('click', ".plus_button", function (e) {
    e.preventDefault();
    var $item = $(this).parents('.table_line');
    var $item_num = $(this).parent().find(".item_num");
    var a = $item_num.val();
    $item_num.val(++a);
    change_count_basket($item.data('id'), a);
    calculateSumPrice($item_num);
    calculateFirmTotal();
    calculateFirmRemain();

});

$('body, .popup_window').on('change', '.item_num', function (e) {
    e.preventDefault();
    var $item = $(this).parents('.table_line');
    var a = $(this).val();
    change_count_basket($item.data('id'), a);
    calculateSumPrice($(this));
    calculateFirmTotal();
    calculateFirmRemain();
});

$(".last_order").click(function () {
    if ($(this).find("span").hasClass("arrow_down")) {
        $(this).find("span").removeClass("arrow_down").addClass("arrow_up");
        $(".last_order_block").removeClass("hidden");
    }
    else {
        $(this).find("span").removeClass("arrow_up").addClass("arrow_down");
        $(".last_order_block").addClass("hidden");
    }
});

$("#checkbox_all").change(function () {
    if ($(this).prop('checked')) {
        $('.single_checkbox').prop('checked', true);
    } else {
        $('.single_checkbox').prop('checked', false);
    }
});

$('.product_price').click(function (e) {
    e.preventDefault();
    $('.product_price').removeClass('activepr');
    $(this).addClass('activepr');
    var action_id = $(this).attr('data-id');
    getActionDiscount(action_id);
    calculateFirmRemain();
});

$('#add_to_order').click(function (e) {
    e.preventDefault();
    $('input[name]:checked').each(function () {
        var $item = $(this).parent().parent().detach();
        delPreOrderItem($item.attr('data-id'));
        addOrderItem($item.attr('data-id'), $item.find('.item_num').val());
        $item.find('.nopdrgt').removeClass('nopdrgt pdglt15');
        $item.find('input[type=checkbox]').parent().remove();
        $item.find('.count1').removeClass('count1');
        $item.attr('data-status', 'order');

        var $last = $('.table_line').last();
        $last.before($item);
    });
    calculateTotalPrice($order);
    calculateTotalPrice($preorder);
    calculateFirmTotal();
    calculateFirmRemain();
});


function getActionDiscount(action_id) {
    $.ajax({
        url: '/ajax/action_discount/' + action_id,
        dataType: 'html',
        success: function (data) {
            $('.actions').empty();
            $('.actions').html(data);
        },
        error: function (e) {
            console.error(e.data);
        }
    });
}

function calculateSumPrice($item_num) {
    var $table_line = $item_num.parents(".table_line");
    var price_per_unit = $table_line.find('.price_per_unit span').text();
    var sum = parseFloat(price_per_unit * $item_num.val()).toFixed(2);
    $table_line.find('.sum_price span').text(sum);
    calculateTotalPrice($table_line.parent());
}

function calculateTotalPrice($parent) {
    var sums = $parent.find('.sum_price span').get();
    var total = 0;
    $.each(sums, function (k, v) {
        total += +v.textContent;
    });
    //for reusability
    var $total_price = $parent.find('#total_price span').length ? $parent.find('#total_price span') : $('#total_price span');
    $total_price.text(total.toFixed(2));
}

function calculateFirmTotal() {
    var $table_lines = $('#order .table_line');
    var firm_sum = 0;
    $.each($table_lines, function (index, val) {
        if ($(val).attr('data-firm') == 'true') {
            firm_sum += +$(val).find('.sum_price span').text();
        }
    });
    $('#firm_total').find('span').text(firm_sum.toFixed(2));
}

function calculateFirmRemain() {
    var total = +$('#firm_total').find('span').text();
    var activepr = $('.activepr').find('span').text();
    var remain = activepr - total;
    if (remain < 0)
        remain = 0;
    $('#firm_remain').find('span').text(remain);
}

$('.popup_window').on('click', '.basket_element_prepack .group_sizes', function(event){
    event.preventDefault();
    if(!$(this).hasClass('active')) {
        var $packing_block = $(this).parent();
        var $element = $packing_block.parent();
        var $prev = $packing_block.find('.group_sizes.active');
        $prev.removeClass('active');
        $(this).addClass('active');
        var item_id = $(this).data('item_id');
        $.ajax({
            url: '/change_with_size',
            dataType: 'json',
            method: 'POST',
            data        :
            {
                'item_id' : item_id
            },
            success: function(data){
                var $item_num = $element.find('.item_num');
                delOrderItem($prev.data('item_id'));
                add_to_basket(item_id, $item_num.val());
                $element.find('.price_per_unit span').text(data['price']);
                calculateSumPrice($item_num);
            },
            error: function(e){
                console.error(e);
            }
        });
    }
});


//popup window
var getCartItems = function() {
    $.ajax({
        url: '/basket/get_cart_items',
        dataType: 'json',

        success: function (data) {

            var html = '';
            for (var i = 0; i < data['items'].length; i++) {

                var cover = data['items'][i].cover;
                html += '<div data-status="order" data-id="'+ data['items'][i]['id']
                    + '" class="basket_element table_line"><div class="basket_element_name"><img src="'
                    + cover + '" class="picture_element">'
                    + '<div class="title_element">' + data['items'][i].title
                    + '</div>'
                    + '</div>'
                    + '<div class="basket_element_prepack">';
                for(var j = 0; j < data['items'][i]['group_sizes'].length; j++) {
                    var size = data['items'][i]['group_sizes'][j]['size'];
                    html += '<a href="#" class="group_sizes'
                            + (data['items'][i]['group_sizes'][j]['size'] == data['items'][i]['size'] ? ' active' : '')
                            + '" style="text-align:start;padding-top:'+(j*3) + 'px; width:' + (31+(j*3))
                            + 'px" data-item_id="' + data['items'][i]['group_sizes'][j]['id'] + '" >'
                            + '<span class="group_sizes_header"></span>'
                            + '<span class="group_sizes_content">' + data['items'][i]['group_sizes'][j]['size'] + '</span>'
                            +'</a>';
                    if(data['items'][i]['group_sizes'][j+1] === undefined || size === data['items'][i]['group_sizes'][j+1]['size'])
                        break;
                }
                html += '</div>'
                    + '<div class="basket_element_priceone"><span class="price price_per_unit"><span>' + data['items'][i].price + '</span> грн.</span>'
                    + '</div>'
                    + '<div class="basket_element_pricenum"><div style="width: 100px">'
                    + '<a href="#" class="minus_button"><img src="/images/minus.png" style="padding-right:7px;"></a>'
                    + '<input type="number" value="' + data['items'][i].count + '" min="1" class="item_num">'
                    + '<a href="#" class="plus_button"><img src="/images/plus.png" style="padding-left:7px;"></a></div></div>'
                    + '<div class="basket_element_priceall"><span class="price sum_price"><span>' + data['items'][i].total_price + '</span> грн.</span>'
                    + '</div>'
                    + '<div class="basket_element_delete"><a class="delete_but"></a></div></div>';
            }

            $('.summary_price .sum').text(data.total_price);
            $('.basket_block_content').html(html);
            $(".popup").animate({opacity: "show", display: "block"}, 300);
            $(".popup_window").animate({marginTop: "5%", width: "1000px"}, 120);

        },

        error: function (err) {
            document.write(err.responseText);
        }
    });
};

var popup = function () {

    function closePopup() {
        $(".popup_window").animate({marginTop: "0.6in", width: "500px"}, 120);
        $(".popup").animate({opacity: "hide", display: "none"}, 300);
    }
    $(".cont_shop_but, .popup_close_button").click(function (e) {
        e.preventDefault();
        closePopup();
    });

    $('.popup').click(function() {
        closePopup();
    });

    $('.popup_window').click(function(e) {
        e.stopPropagation();
    });

    $(document).on('click', '.buy', function (e) {
        e.preventDefault();
        var $parent = $(this).parents('.product, .item_content');
        var group_id = $(this).data('group_id');
        var item_id = $parent.find('.active').data('item_id');
        var count_items = $parent.find('input').val();

        $.ajax({
            url : '/ajax/get_item_group',
            method: 'POST',
            dataType: 'json',
            data: {
                'group_id': group_id,
                'item_id' : item_id
            },
            success: function(item) {
                console.log('item_id ' + item['id']);
                add_to_basket(item['id'], count_items || 1, getCartItems);
            },
            error: function(error) {
                console.error(error);
                document.write(error.responseText);
            }
        });

    });

    $('#help').click(function(e){
        e.preventDefault();
        videoConfirm(function(){});
    });

};

popup();
