<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<div class="main_block">
<a href="#" class="green_but last_order"><span class="arrow_down"><?= $t->_('previous_order') ?></span></a>
<div id="preorder" class="block_content block930 last_order_block hidden">
    <h3 class="table_title"><?= $t->_('previous_order') ?></h3>
    <div class="star starbig"><?= $t->_('if_remove') ?></div>
    <div style="border-bottom:1px solid #eaeaea;">
        <div class="table_cell1"></div>
        <div class="table_cell1 w205"><?= $t->_('name') ?></div>
        <div class="table_cell2 w66"><?= $t->_('packing') ?></div>
        <div class="table_cell2 w90"><?= $t->_('cost_per_unit') ?></div>
        <div class="table_cell2 w85"><?= $t->_('stock_availability') ?></div>
        <div class="table_cell2 w90"><?= $t->_('number_of') ?></div>
        <div class="table_cell2 w30"></div>
        <div class="table_cell2 w100"><?= $t->_('cost') ?></div>
        <div class="table_cell2 w25"></div>
    </div>
    <?php foreach($preorder_items as $p): ?>
    <div data-id="<?= $p['id'] ?>" data-status="preorder" data-firm="<?= (!empty($p['firm']) && $p['firm']) ? 'true' : 'false'?>" class="table_line">
        <div class="table_cell1 grey_middle pad6">
            <input type="checkbox" name="checkbox" class="single_checkbox">
        </div>
        <div class="table_cell3 w200 bold18 nopdrgt pdglt15">
            <img src="<?= $p['cover'] ?>" width="45px" height="40px" style="float:left;padding-right:20px;">
            <div style="color:#464646;"><?= $p['title'] ?></div>
        </div>
        <div class="table_cell4 w75">
            <a style="left: 20px" href="#" class="group_sizes active"  data-item_id="<?= $p['id'] ?>">
                <span class="group_sizes_header"></span>
                <span class="group_sizes_content"><?= $p['size'] ?></span>
            </a>
        </div>
        <div class="table_cell4 w90">
            <div class="price price_per_unit"><span><?= isset($p['prices'][$special_user['status'] - 1])
                        ? $p['prices'][$special_user['status'] - 1]
                        : $p['price2'] ?></span> грн.</div>
        </div>
        <div class="table_cell4 w90">
            <img src="/images/dost<?= !empty($p['stock_availability']) ? $p['stock_availability'] : '0'; ?>.png">
        </div>
        <div class="table_cell4 w90 count1">
            <div>
                <a href="#" class="minus_button"><img src="/images/minus.png" style="padding-right:7px;"></a>
                <input type="number" min="1" value="<?= $p['count'] ?>"  class="item_num">
                <a href="#" class="plus_button"><img src="/images/plus.png" style="padding-left:7px;"></a>
            </div>
        </div>
        <div class="table_cell4 w35">
            <?php if(!empty($p['firm']) && $p['firm']): ?>
                <img src="/images/minilogo.png">
            <?php endif; ?>
        </div>
        <div class="table_cell5 w100"><div class="price sum_price"><span><?= $p['total_price'] ?></span> грн.</div></div>
        <div class="table_cell4 w30">
            <a href="#" class="delete_but"></a>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="table_line">
        <div class="table_cell1 grey_middle pad6">
            <input type="checkbox" id="checkbox_all">
        </div>
        <div class="table_cell1 w147" style="vertical-align:middle;">
            <label for="checkbox_all"><?= $t->_('select_all') ?></label>
        </div>
        <div class="big_table_cell2"><?= $t->_('total') ?>:</div>
        <div class="table_cell6 w100"><div id="total_price" class="price"><span><?= $total_preorder_price ?></span> грн.</div></div>
        <div class="table_cell4 w30">
        </div>
    </div>
    <div class="block930 top20"><a href="#" id="add_to_order" class="green_but" style="width: 200px"><?= $t->_('add_to_order') ?></a></div>
</div>
<div id="order" class="block_content block930">
    <h3 class="table_title"><?= $t->_('orders') ?></h3>
    <div style="border-bottom:1px solid #eaeaea;">
        <div class="table_cell1 w205"><?= $t->_('name') ?></div>
        <div class="table_cell2 w66"><?= $t->_('packing') ?></div>
        <div class="table_cell2 w90"><?= $t->_('cost_per_unit') ?></div>
        <div class="table_cell2 w85"><?= $t->_('stock_availability') ?></div>
        <div class="table_cell2 w90"><?= $t->_('number_of') ?></div>
        <div class="table_cell2 w30"></div>
        <div class="table_cell2 w100"><?= $t->_('cost') ?></div>
        <div class="table_cell2 w25"></div>
    </div>
    <?php foreach($items as $i): ?>
    <div data-id="<?= $i['id'] ?>" data-status="order" data-firm="<?= (!empty($i['firm']) && $i['firm']) ? 'true' : 'false'?>" class="table_line">
        <div class="table_cell3 w200 bold18">
            <a style="text-decoration: none" href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="<?= $i['title'] ?>">
                <img src="<?= $i['cover'] ?>" width="45px" height="40px" style="float:left;padding-right:20px;">
                <div style="color:#464646;"><?= $i['title'] ?></div>
            </a>
        </div>
        <div style="text-align: start" class="table_cell4 w75">
            <a style="left: 20px" href="#" class="group_sizes active"  data-item_id="<?= $i['id'] ?>">
                <span class="group_sizes_header"></span>
                <span class="group_sizes_content"><?= $i['size'] ?></span>
            </a>
        </div>
        <div class="table_cell4 w90">
            <div class="price price_per_unit">
                <span><?= isset($i['prices'][$special_user['status']])
                        ? $i['prices'][$special_user['status']]
                        : $i['price2'] ?></span> грн.
            </div>
        </div>
        <div class="table_cell4 w90">
            <img title="<?= $t->_($stock_availability[$i['stock_availability']]) ?>" src="/images/dost<?= !empty($i['stock_availability']) ? $i['stock_availability'] : '0'; ?>.png">
        </div>
        <div class="table_cell4 w90">
            <div>
                <a href="#" class="minus_button"><img src="/images/minus.png" style="padding-right:7px;"></a>
                <input type="number" min="1" value="<?= $i['count'] ?>"  class="item_num">
                <a href="#" class="plus_button"><img src="/images/plus.png" style="padding-left:7px;"></a>
            </div>
        </div>
        <div class="table_cell4 w35">
            <?php if(!empty($i['firm']) && $i['firm']): ?>
                <img src="/images/minilogo.png">
            <?php endif; ?>
        </div>
        <div class="table_cell5 w100"><div class="price sum_price"><span><?= $i['total_price'] ?></span> грн.</div></div>
        <div class="table_cell4 w30">
            <a href="#" class="delete_but"></a>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="table_line">
        <div class="big_table_cell"><?= $t->_('total') ?>:</div>
        <div class="table_cell6 w100"><div id="total_price" class="price"><span><?= $total_price ?></span> грн.</div></div>
        <div class="table_cell4 w30">
        </div>
    </div>
    <div class="block930 top20"><a href="#" class="green_but dealer_order"><?= $t->_('order') ?></a></div>
</div>
<!--<div class="block_content block930">

    <h3 class="table_title"><?/*= $t->_('firm_discount') */?></h3>

    <div class="firm_products">
        <div><?/*= $t->_('firm_goods') */?><span id="firm_total" name="firm_total" class="price"><span></span> грн.</span></div>
        <div><?/*= $t->_('remaining') */?><span id="firm_remain" class="price"><span></span> грн.</span></div>
        <div>
            <a href="#" title="<?/*= $t->_('details') */?>" data-toggle="popover" data-trigger="hover" data-content="Some content" class="products_more">
                <span><?/*= $t->_('details') */?></span>
            </a>
        </div>
    </div>

    <div class="star starbig"><?/*= $t->_('with_logo') */?></div>

    <div class="product_prices">
        <?php /*foreach($actions as $k => $v): */?>
        <a href="#" data-id="<?/*= $v['id'] */?>" class="product_price <?/*= $k == 0 ? 'activepr' : '' */?>"><span><?/*= $v['limit'] */?></span> грн.</a>
        <?php /*endforeach; */?>
    </div>
    <div class="clear"></div>

    <div class="actions">
        <?/*= $this->partial('partial/action_discount', ['action_discount' => $action_discount]) */?>
        <div class="clear"></div>
    </div>
    <div class="block930 top20"><a href="#" class="green_but dealer_order"><?/*= $t->_('order') */?></a></div>
</div>
-->
<div style="padding-left: 10px; width: 990px" class="block_content block930 clearfix">
        <h2><?= $t->_('recommended_items') ?></h2>
        <?php $this->partial('partial/items', ['items' => $recommended_items]) ?>
</div>
</div>
</section>
<script>
    $('.dealer_order').click(function(e) {
        e.preventDefault();
        var action = $('input[type=radio]:checked');
        if(action.length) {
            var action_id = action.data('id');
            var firm_total = $('#firm_total span').text();
            $.ajax({
                url: '/ajax/set_action_discount',
                method: 'POST',
                data        :
                {
                    'action_id' : action_id,
                    'firm_total' : firm_total
                },
                success: function() {
                    window.location.href = '<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'dealer_order' ])) ?>';
                },
                error: function(e) {
                    console.error(e);
                }
            });
        } else {
            window.location.href = '<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'dealer_order' ])) ?>';
        }
    });
</script>