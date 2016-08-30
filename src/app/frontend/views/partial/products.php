<?php if(!empty($groups)) : ?>
<?php foreach($groups as $k => $group_item): ?>
    <?php $default_item = $group_item['items'][0] ?>
    <div data-group_id="<?= $group_item['group_id'] ?>" class="product">
        <div class="table_line">
            <div class="table_cell3 w210 bold18">
                <a style="text-decoration: none" href="<?= $this->seoUrl->setUrl($group_item['alias']) ?>" title="<?= $group_item['title'] ?>">
                    <img width="45px" height="40px" src="<?= $group_item['cover'] ?>" style="float:left;padding-right:20px;">
                    <div style="color:#464646;"><?= $group_item['title'] ?></div>
                </a>
            </div>
            <div class="table_cell4 w90">
                <img title="<?= $t->_($stock_availability[$default_item['stock_availability']]) ?>" id="stock_availability" src="/images/dost<?= !empty($default_item['stock_availability']) ? $default_item['stock_availability'] : '0'; ?>.png">
            </div>
            <div class="firm_product">
                <?php if(!empty($default_item['firm']) && $default_item['firm']): ?>
                    <div class="table_cell4 w35">
                        <a href="#"><img src="/images/minilogo.png"></a>
                    </div>
                    <div class="table_cell4 font13 left">
                        <?= $t->_('firm_product') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div style="text-align: start;" class="table_cell4 w75">
                <a style="left: 20px" href="#" class="selected group_sizes active"  data-item_id="<?= $default_item['id'] ?>" data-catalog_id="<?= $default_item['catalog'] ?>" data-group_alias="<?= $group_item['alias'] ?>">
                    <span class="group_sizes_header"></span>
                    <span class="group_sizes_content"><?= $default_item['size'] ?></span>
                </a>
                <div style="display: inline-block; position: relative; bottom: 10px; left: 20px ;" class="dropdown">
                    <a data-target="#" id="drop" class="pad5 dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i style="font-size: 19px;opacity: 0.5;" class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="drop">
                        <?php foreach($group_item['items'] as $j): ?>
                            <li>
                                <a href="#" class="group_sizes"  data-item_id="<?= $j['id'] ?>" data-catalog_id="<?= $j['catalog'] ?>" data-group_alias="<?= $group_item['alias'] ?>">
                                    <span class="group_sizes_header"></span>
                                    <span class="group_sizes_content"><?= $j['size'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="table_cell4 w90">
                <div>
                    <a href="#" class="minus_button"><img src="/images/minus.png" style="padding-right:3px;"></a>
                    <input type="number" min="1" value="1" class="item_num">
                    <a href="#" class="plus_button"><img src="/images/plus.png" style="padding-left:3px;"></a>
                </div>
            </div>
            <div style="margin-left: 10px" class="one_item_compare">
                <input type="checkbox" id="items_compare_item_<?= $group_item['id'] ?>" value="<?= $group_item['type_id'].'-'.$group_item['catalog'].'-'.$group_item['id'] ?>" <?= ( !empty($group_item['checked']) ? 'checked' : '' ) ?> />
                <label for="items_compare_item_<?= $group_item['id'] ?>"><span></span><?= $t->_("compared_to") ?></label>
            </div>
        </div>
        <div class="rec_prices">
            <div class="rec_prices_block left first">
                <?= $t->_('recommended_prices') ?>
            </div>
            <div style="display: inline-block; width: 276px">
                <?php for($i = 0; $i < $special_user['status']; $i++): ?>
                    <div class="rec_prices_block lr_padding">
                        <div class="small_price"><span><?= $default_item['prices'][$i] ?></span> грн.</div>
                        <p class="subtitle"><?= $special_users[$i]['title'] ?></p>
                    </div>
                <?php endfor; ?>
            </div>
            <div style="width: 120px" class="rec_prices_block all_price">
                <?= $t->_('your_price') ?>
                <span class="price"><span><?= empty($default_item['prices'][$special_user['status']]) ? $default_item['price2'] : $default_item['prices'][$special_user['status']] ?></span> грн.</span>
            </div>
            <div class="rec_prices_block">
                <a href="#" data-group_id="<?= $default_item['group_id'] ?>" class="green_but add_to_cart"><?= $t->_('add_to_cart') ?></a>
            </div>
        </div>
        <?php if(isset($group_item['in_cart'])): ?>
            <div class="in_cart">
                <h5 style="margin-right:73px"><?= $t['in_cart'] ?></h5>
            <?php foreach($group_item['items'] as $j): ?>
                <?php if(isset($j['count_cart'])): ?>
                    <div class="item_count_cart">
                        <a style="margin-right: 82px" href="#" class="group_sizes active"  data-item_id="<?= $j['id'] ?>" data-catalog_id="<?= $j['catalog'] ?>" data-group_alias="<?= $group_item['alias'] ?>">
                            <span class="group_sizes_header"></span>
                            <span class="group_sizes_content"><?= $j['size'] ?></span>
                        </a>
                        <div style="margin-right: 30px; font-size: 18px"><?= $j['count_cart'] ?></div>
                        <a href="#" class="delete_btn"></a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php else: ?>
    <div style="text-align: center" class="subcategory_sidebar_title">
        <p>За данним запитом нічого не знайдено</p>
    </div>
<?php endif; ?>
<script>
    var Cart = function (cart) {
        this.items = cart || [];

        var self = this;

        const tpl = '<div class="in_cart">' +
            '<h5 style="margin-right:73px"><?= $t['in_cart'] ?></h5>' +
            '</div>';

        this.addItem = function (item) {
            self.items.push(item);
        };

        this.deleteItem = function (item_id) {
            for(var i = 0; i < self.items.length; i++)
                if(self.items[i].id == item_id)
                    self.items.splice(i, 1);
        };

        this.render = function (parent, item) {
            if(!isGroupExists(item))
                parent.append(tpl);
            var $in_cart = parent.find('.in_cart');
            self.addItem(item);
            $in_cart.append(renderItem(item));
        };

        this.rerender = function (parent) {
            var $product = parent.parent();
            var group = { group_id : $product.data('group_id') };
            parent.find('.item_count_cart').remove();
            if(isGroupExists(group)) {
                self.items.forEach(function(item) {
                    if(item.group_id == group.group_id)
                        parent.append(renderItem(item));
                });
            } else {
                parent.remove();
            }
        };

        function renderItem (item) {
            var html = '';
            html += '<div class="item_count_cart">' +
                    '<a style="margin-right:82px" href="#" class="group_sizes active" ' +
                    'data-item_id="' + item.id + '" data-catalog_id="' + item.catalog + '" ' +
                    'data-group_alias="' + item.catalog_alias + '">' +
                    '<span class="group_sizes_header"></span>' +
                    '<span class="group_sizes_content">' + item.size + '</span>' +
                    '</a>' +
                    '<div style="margin-right: 30px; font-size: 18px">' + item.count + '</div>' +
                    '<a href="#" class="delete_btn"></a>' +
                    '</div>';
            return html;
        }

        this.isItemExists = function (newItem) {
            var isExists = false;
            for(var i = 0; i < self.items.length; i++) {
                if(self.items[i].id == newItem.id) {
                    isExists = true;
                    break;
                }
            }
            return isExists;
        };

        function isGroupExists (newItem) {
            var isExists = false;
            for(var i = 0; i < self.items.length; i++) {
                if(self.items[i].group_id == newItem.group_id) {
                    isExists = true;
                    break;
                }
            }
            return isExists;
        }

    };

    var currentCart = new Cart(<?= $cart ?>);

    $('.add_to_cart').on('click', function (e) {
        e.preventDefault();

        var $parent = $(this).parents('.product');
        var $active = $parent.find('.selected.active');
        var newItem = {
            group_id : $(this).data('group_id'),
            id : $active.data('item_id'),
            catalog_alias : $active.data('catalog_id'),
            group_alias : $active.data('group_alias'),
            count : $parent.find('input').val(),
            size : $active.find('.group_sizes_content').text()
        };

        if(!currentCart.isItemExists(newItem)) {
            currentCart.render($parent, newItem);
        }

        $.ajax({
            url : '/ajax/get_item_group',
            method: 'POST',
            dataType: 'json',
            data: {
                'group_id': newItem.group_id,
                'item_id' : newItem.id
            },
            success: function(item) {
                add_to_basket(item['id'], newItem.count || 1, null);
            },
            error: function(error) {
                console.error(error);
                document.write(error.responseText);
            }
        });

    });

    $('body').on('click', '.delete_btn', function(e) {
        e.preventDefault();

        var $parent = $(this).parents('.in_cart');
        var $in_cart = $(this).parent();
        var $group_size = $in_cart.find('.active');
        var item_id = $group_size.data('item_id');
        var count_item = $in_cart.find('div');

        var $count_cart = $('.count_cart');
        var count = parseInt($count_cart.text());
        $count_cart.text(count - parseInt(count_item.text()));

        currentCart.deleteItem(item_id);
        currentCart.rerender($parent);
        delOrderItem(item_id);
    });
</script>