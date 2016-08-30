<div id="addEdit">
    <div class="inner"><?= $this->flash->output(); ?></div>
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">
                    <?= $this->partial('partial/sidebar') ?>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="content_wrapper_list clearfix">
                    <div class="table_name header_gradient"></div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="promo_codes_add_edit">

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="code">промокод</label></div>
                                <button id="generate" type="button">Сгенерировать</button>
                                <div class="input"><input required type="text" name="code" id="code" value='<?=  (isset( $page['0']['code'] ) && !empty( $page['0']['code'] ) ? $page['0']['code'] : '') ?>'></div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="name">Название</label></div>
                                <div class="input"><input required type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="discount">Скидка</label></div>
                                <div class="input"><input required type="text" name="discount" id="discount" value='<?=  (isset( $page['0']['discount'] ) && !empty( $page['0']['discount'] ) ? $page['0']['discount'] : '') ?>'></div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="start_date">Дата начала действия промокода (включительно)</label></div>
                                <div class="input">
                                    <input required type="text" name="start_date" id="start_date"
                                           value="<?= (isset( $page['0']['start_date'] ) && !empty( $page['0']['start_date'] ) ? date('d-m-Y', strtotime($page['0']['start_date'])) : '')  ?>">

                                </div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="end_date">Дата окончания действия промокода (включительно)</label></div>
                                <div class="input">
                                    <input required type="text" name="end_date" id="end_date"
                                           value="<?= (isset( $page['0']['end_date'] ) && !empty( $page['0']['end_date'] ) ? date('d-m-Y', strtotime($page['0']['end_date'])) : '')  ?>">
                                </div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="description">Описание</label></div>
                                <div class="input">
                                    <textarea name="description" id="description">
                                        <?=  (isset( $page['0']['description'] ) && !empty( $page['0']['description'] ) ? $page['0']['description'] : '') ?>
                                    </textarea>
                                </div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="catalog">Категории товаров</label></div>
                                <div class="input">
                                    <select class="catalog" id="catalog">
                                        <option selected label=" "></option>
                                        <?php foreach($catalog_temp as $group): ?>
                                            <option value="<?= $group['id'] ?>"><?= $group['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="button" id="apply_filter">Применить</button>
                                <div class="input">
                                    <div>Цена</div>
                                    <label for="from_price">От</label>
                                    <input type="text" id="from_price">
                                    <label for="to_price">До</label>
                                    <input type="text" id="to_price">
                                </div>
                                <div class="filter">

                                </div>
                            </div>


                            <div class="clearfix input_wrapper products">

                            </div>

                            <div class="clearfix input_wrapper chose_items">
                                <?php if(isset($groups) && !empty($groups)): ?>
                                    <?php foreach($groups as $group): ?>
                                                <div>
                                                    <label>
                                                        <input disabled checked style="display:inline-block" id="items" name="items[]" class="items" type="checkbox"
                                                               value="<?= $group['id'] ?>"> <?= $group['title'] ?> <?= $group['size'] ?> <?= $group['price2'] ?> грн.
                                                    </label>
                                                    <button type="button" class="delete_item">Удалить</button>
                                                </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!--<div class="clearfix input_wrapper">

                                <div class="label"><label for="items">Товары</label></div>
                                <button id="add_item" type="button">Добавить</button>
                                <?php /*if(empty($page['0']['group_ids'])): */?>
                                    <?php /*$page['0']['group_ids'][] = ' '; */?>
                                <?php /*endif; */?>
                                <?php /*foreach($page['0']['group_ids'] as $k => $group_id): */?>
                                <div class="input">
                                    <select name="items[]" class="items" id="items">
                                        <option selected label=" "> </option>
                                        <?php /*foreach($groups as $group): */?>
                                        <option <?/*= !empty($group_id) && $group_id == $group['item_id'] ? 'selected ' : '' */?>
                                            value="<?/*= $group['item_id'] */?>"><?/*= $group['title'] */?> <?/*= $group['size'] ?: '' */?> <?/*= $group['color_title'] ?: '' */?></option>
                                        <?php /*endforeach; */?>
                                    </select>
                                    <?php /*if($k > 0): */?>
                                        <button class="delete_item" type="button">Удалить</button>
                                    <?php /*endif; */?>
                                </div>
                                <?php /*endforeach; */?>
                            </div>-->

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="image">Картинка</label></div>
                                <div class="input"><input type="file" name="image" id="image" value=''></div>
                            </div>
                            <?php if(isset( $page['0']['image'] ) && !empty( $page['0']['image'] )):?>
                                <img src="<?= $page['0']['image'] ?>">
                            <?php endif ?>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'promo_codes_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var datepicker = {
        dateFormat: "dd-mm-yy"
    };
    var $body = $('body');
    var filter = new Filter();
    var catalog = new Catalog(<?= json_encode($catalog_temp) ?>);
    console.log(catalog.getCatalog());

    $('#start_date').datepicker(datepicker);
    $('#end_date').datepicker(datepicker);

    $("form").submit(function() {
        $("input").removeAttr("disabled");
    });

    $('#add_category, #add_item').click(function() {
        var parent = $(this).parent();
        var select = parent.find('.input');
        var clone = select.clone()[0];
        parent.append(clone);
    });

    $('#generate').click(function() {
        var length = 7;
        var code = generateCode(length);
        $('#code').val(code);
    });

    $body.on('click', '.delete_item', function() {
        var parent = $(this).parent();
        parent.remove();
    });


    $body.on('change', '.catalog', function () {
        var $filter = $('.filter');
        var catalog_id = $(this).val();
        var sub = catalog.getSub(catalog_id, catalog.getCatalog());

        if(!sub) {
            $.ajax({
                url: '/get_filters_by_catalog',
                method: 'GET',
                data: {
                    catalog_id : catalog_id
                },
                dataType: 'json'
            }).done(function (data) {
                filter.setFilters(data);
                filter.render($filter);
            });
        } else {
            var next = $(this).next('select');

            while(next.length) {
                next.remove();
                next = $(this).next('select');
            }

            $(this).after(catalog.renderSub(sub));
        }
    });

    $('#apply_filter').click(function (e) {
        e.preventDefault();
        var $catalog = $('.catalog');
        var l = $catalog.length;
        var $input = $('.products');
        var prices = [];

        prices.push(Number($('#from_price').val()) || 0);
        prices.push(Number($('#to_price').val()) || Number.MAX_SAFE_INTEGER || 1000000);
        $.ajax({
            url: '/get_items_by_filter',
            method: 'POST',
            data: {
                filters : filter.getFilters(),
                catalog_id : $catalog[l-1].value,
                prices : prices
            },
            dataType: 'json'
        }).done(function (data) {
            renderItems(data, $input);
        });
    });

    $body.on('click', '#add_goods', function () {
        var parent_items = $('.filter_item:checked').parent().parent().clone();
        parent_items.append('<button type="button" class="delete_item">Удалить</button>');
        var inputs = parent_items.find('input');
        inputs.prop('disabled', true);
        inputs.prop('name', 'items[]');
        inputs.prop('class', 'items');
        inputs.prop('id', 'items');
        $('.chose_items').append(parent_items);
    });

    $body.on('click', '.delete_item', function () {
        var parent = $(this).parent();
        parent.remove();
    });

    $body.on('change', '#choose_all', function () {
        var checked = $(this).prop('checked');
        $('.filter_item').prop( "checked", checked );
    });


    function renderItems(data, parent) {
        parent.empty();

        var items = '<div><label><input style="display: inline-block" id="choose_all" type="checkbox">Выбрать все</label></div>';

        data.forEach(function(element){
            items += '<div><label><input style="display:inline-block" class="filter_item" type="checkbox" value="'
                + element.item_id + '">' + element.title + ' ' + element.size + ' ' + element.price2 + ' грн.'
                + '</label></div>';
        });
        items += '<div><button type="button" id="add_goods">Добавить товары</button></div>';
        parent.append(items);
    }

    /* var data = JSON.parse('<?php //echo json_encode($catalog_temp); ?>');*/

    /*$('#name').autocomplete({
        minLength: 2,
        source: function( request, response ) {
            var term = request.term;
            var result = [];
            for(var i = 0; i < data.length; i++) {

                if(data[i].title.toLowerCase().indexOf(term.toLowerCase()) != -1)
                    result.push(data[i].title);
            }
            response(result);
        }
    });*/

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


</script>