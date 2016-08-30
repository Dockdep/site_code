<a href="<?= $this->seoUrl->setUrl($sale['link']) ?>" title="<?= $sale['name'] ?>"<?= ($k + 1) % 4 == 0 ?' class="sales_box_link"' : '' ?>>
    <div class="sales_box<?= !$sale['active'] ? ' future_sales' : '' ?>">
        <div class="sales_box_pic">
            <img src="<?= $this->storage->getPhotoURL($sale['classic_cover'], 'sales/classic_cover', 'original'); ?>">
        </div>
        <div class="sales_box_date">
            <?= $sale['start_day'] ?> <span><?= $t->_('second_month_list')[$sale['start_month'] - 1] ?></span> - <?= $sale['end_day'] ?> <span><?= $t->_('second_month_list')[$sale['end_month'] - 1] ?></span>
        </div>
        <div class="sales_box_footer">
            <p><?= $sale['name'] ?></p>
            <!--<span><?/*= $t->_('week_price') */?></span>-->
            <div class="end_sales">
                <?= $sale['active'] ? $t->_('else') : 'через' ?> <span><?= $sale['diff'] ?></span> <?= $t->_('days') ?>
            </div>
        </div>

    </div>
</a>