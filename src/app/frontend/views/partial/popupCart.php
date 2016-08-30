<div class="popup" style="display: none;">
    <div class="popup_window">
        <div class="popup_close_button"></div>
        <div class="popup_window_content">
            <h4><?= $t->_('cart') ?></h4>
            <div class="basket_block">
                <div class="basket_block_header">
                    <div><?= $t->_('name') ?></div>
                    <div style="width:290px;"></div>
                    <div style="padding-left: 0; padding-right: 50px"><?= $t->_('packing') ?></div>
                    <div class="w90"><?= $t->_('cost_per_unit') ?></div>
                    <div><?= $t->_('number_of') ?></div>
                    <div class="w120" style="padding-right: 40px"><?= $t->_('cost') ?></div>
                </div>
                <div class="basket_block_content overflow">
                </div>
            </div>
            <div class="summary_price">
                <span class="text"><?= $t->_('total') ?>: <span id="total_price" class="price">
                        <span class="sum"></span> грн.</span>
                </span>
            </div>
            <div class="popup_footer">
                <a href="#" style="float: left" id="help"><?= $t->_('need_help') ?></a>
                <span class="min_price_message"><?=$t->_("min_price") ?></span>
                <a href="#" class="cont_shop_but"><?= $t->_('continue_shopping') ?></a>
                <a href="<?= $this->seoUrl->setUrl('/basket') ?>" class="green_but2"><?= $t->_('checkout') ?></a>
            </div>
        </div>
    </div>
</div>
