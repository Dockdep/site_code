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
                <img id="stock_availability" src="/images/dost<?= !empty($default_item['stock_availability']) ? $default_item['stock_availability'] : '0'; ?>.png">
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
                <a style="left: 20px" href="#" class="group_sizes active"  data-item_id="<?= $default_item['id'] ?>" data-catalog_id="<?= $default_item['catalog'] ?>" data-group_alias="<?= $group_item['alias'] ?>">
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
        </div>
        <div class="rec_prices">
            <?php if(!empty($default_item['prices'][0]) && ($special_user['status'] != 1)): ?>
                <div class="rec_prices_block left first">
                    <?= $t->_('recommended_prices') ?>
                </div>
                <div style="display: inline-block; width: 224px">
                    <?php for($i = 0; $i < $special_user['status'] - 1; $i++): ?>
                        <div class="rec_prices_block lr_padding">
                            <div class="small_price"><span><?= $default_item['prices'][$i] ?></span> грн.</div>
                            <p class="subtitle"><?= $special_users[$i]['title'] ?></p>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            <div class="rec_prices_block all_price">
                <?= $t->_('your_price') ?>
                <span class="price"><span><?= empty($default_item['prices'][$special_user['status'] - 1]) ? $default_item['price2'] : $default_item['prices'][$special_user['status'] - 1] ?></span> грн.</span>
            </div>
            <div class="rec_prices_block">
                <a href="#" data-group_id="<?= $default_item['group_id'] ?>" class="green_but add_to_cart buy"><?= $t->_('add_to_cart') ?></a>
            </div>
        </div>
    </div>
<?php endforeach; ?>