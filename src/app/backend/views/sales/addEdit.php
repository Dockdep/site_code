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
                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1"  checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>
                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_1">Название</label></div>
                                    <div class="input"><input required type="text" name="name_1" id="page_title_1" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="description_1">Описание</label></div>
                                    <div class="input">
                                        <textarea name="description_1" id="description_1">
                                            <?=  (isset( $page['0']['description'] ) && !empty( $page['0']['description'] ) ? $page['0']['description'] : '') ?>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_1">URL</label></div>
                                    <div class="input"><input id="page_alias_1" type="text"  name="alias_1" value="<?= (isset( $page['0']['alias'] ) && !empty( $page['0']['alias'] ) ? $page['0']['alias'] : '') ?>"></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="full_name_1">Полное название акции</label></div>
                                    <div class="input"><input id="full_name_1" type="text"  name="full_name_1" value="<?= (isset( $page['0']['full_name'] ) && !empty( $page['0']['full_name'] ) ? $page['0']['full_name'] : '') ?>"></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="classic_cover_1">Обычная картинка</label></div>
                                    <div class="input"><input type="file" name="classic_cover_1" id="classic_cover_1" value=''></div>
                                </div>
                                <?php if(isset( $page['0']['classic_cover'] ) && !empty( $page['0']['classic_cover'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['0']['classic_cover'], 'sales/classic_cover', 'original'); ?>">
                                <?php endif ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="seasonal_cover_1">Картинка для сезонной акции</label></div>
                                    <div class="input"><input type="file" name="seasonal_cover_1" id="seasonal_cover_1" value=''></div>
                                </div>
                                <?php if(isset( $page['0']['seasonal_cover'] ) && !empty( $page['0']['seasonal_cover'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['0']['seasonal_cover'], 'sales/seasonal_cover', 'original'); ?>">
                                <?php endif ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="banner_1">Картинка-баннер для слайдера</label></div>
                                    <div class="input"><input type="file" name="banner_1" id="banner_1" value=''></div>
                                </div>
                                <?php if(isset( $page['0']['banner'] ) && !empty( $page['0']['banner'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['0']['banner'], 'sales/banner', 'original'); ?>">
                                <?php endif ?>
                            </div>
                            <div class="version_2 clearfix display_none">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_2">Название</label></div>
                                    <div class="input"><input required type="text" name="name_2" id="page_title_2" value='<?=  (isset( $page['1']['name'] ) && !empty( $page['1']['name'] ) ? $page['1']['name'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="description_2">Описание</label></div>
                                    <div class="input">
                                    <textarea name="description_2" id="description_2">
                                        <?=  (isset( $page['1']['description'] ) && !empty( $page['1']['description'] ) ? $page['1']['description'] : '') ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_2">URL</label></div>
                                    <div class="input"><input id="page_alias_2" type="text"  name="alias_2" value="<?= (isset( $page['1']['alias'] ) && !empty( $page['1']['alias'] ) ? $page['1']['alias'] : '') ?>"></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="full_name_2">Полное название акции</label></div>
                                    <div class="input"><input id="full_name_2" type="text"  name="full_name_2" value="<?= (isset( $page['1']['full_name'] ) && !empty( $page['1']['full_name'] ) ? $page['1']['full_name'] : '') ?>"></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="classic_cover_2">Обычная картинка</label></div>
                                    <div class="input"><input type="file" name="classic_cover_2" id="classic_cover_2" value=''></div>
                                </div>
                                <?php if(isset( $page['1']['classic_cover'] ) && !empty( $page['1']['classic_cover'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['1']['classic_cover'], 'sales/classic_cover', 'original'); ?>">
                                <?php endif ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="seasonal_cover_2">Картинка для сезонной акции</label></div>
                                    <div class="input"><input type="file" name="seasonal_cover_2" id="seasonal_cover_2" value=''></div>
                                </div>
                                <?php if(isset( $page['1']['seasonal_cover'] ) && !empty( $page['1']['seasonal_cover'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['1']['seasonal_cover'], 'sales/seasonal_cover', 'original'); ?>">
                                <?php endif ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="banner_2">Картинка-баннер для слайдера</label></div>
                                    <div class="input"><input type="file" name="banner_2" id="banner_2" value=''></div>
                                </div>
                                <?php if(isset( $page['1']['banner'] ) && !empty( $page['1']['banner'] )):?>
                                    <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['1']['banner'], 'sales/banner', 'original'); ?>">
                                <?php endif ?>
                            </div>
                            <div class="clearfix input_wrapper">
                                <input type="checkbox" name="show_banner" id="show_banner" value="1" <?=  (isset( $page['0']['show_banner'] ) && !empty( $page['0']['show_banner'] ) ? 'checked' : '') ?>>
                                <label for="show_banner"><span></span>Отобразить баннер</label>
                            </div>
                            <div class="clearfix input_wrapper">
                                <input type="checkbox" name="show_counter" id="show_counter" value="1" <?=  (isset( $page['0']['show_counter'] ) && !empty( $page['0']['show_counter'] ) ? 'checked' : '') ?>>
                                <label for="show_counter"><span></span>Отобразить счетчик в баннере</label>
                            </div>

                            <div class="clearfix input_wrapper">
                                <input type="checkbox" name="is_seasonal" id="is_seasonal" value="1" <?=  (isset( $page['0']['is_seasonal'] ) && !empty( $page['0']['is_seasonal'] ) ? 'checked' : '') ?>>
                                <label for="is_seasonal"><span></span>Сезонная акция</label>
                            </div>


                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="start_date">Дата начала действия акции (включительно)</label></div>
                                <div class="input">
                                    <input required type="text" name="start_date" id="start_date"
                                           value="<?= (isset( $page['0']['start_date'] ) && !empty( $page['0']['start_date'] ) ? date('d-m-Y', strtotime($page['0']['start_date'])) : '')  ?>">

                                </div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="end_date">Дата окончания действия акции (включительно)</label></div>
                                <div class="input">
                                    <input required type="text" name="end_date" id="end_date"
                                           value="<?= (isset( $page['0']['end_date'] ) && !empty( $page['0']['end_date'] ) ? date('d-m-Y', strtotime($page['0']['end_date'])) : '')  ?>">
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
                                                <div class="group">
                                                    <label>
                                                        <input disabled checked style="display:inline-block" id="items" name="items[]" class="items" type="checkbox"
                                                               value="<?= $group['id'] ?>"> <?= $group['title'] ?>
                                                    </label>
                                                    <button type="button" class="delete_item">Удалить</button>
                                                </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>


                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'sales_index' ]) ?>" class="news_cancel float">Отмена</a>
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
            var grouped = groupByGroupId(data);
            renderItems(grouped, $input);
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
                + element.group_id + '">' + element.title
                + ' </label></div>';
        });
        items += '<div><button type="button" id="add_goods">Добавить товары</button></div>';
        parent.append(items);
    }

    function groupByGroupId(data) {
        var seen = {};
        return data.filter(function (elem) {
            var k = elem.group_id;
            return seen.hasOwnProperty(k) ? false : (seen[k] = true) ;
        });
    }


</script>