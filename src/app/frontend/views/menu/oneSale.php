<div <?= !empty($current_sale['banner'])
    ? 'style="background: url('.  $this->storage->getPhotoURL($current_sale['banner'], 'sales/banner', 'original') .') no-repeat center center; height:320px"'
    : '' ?> class="catalog_slider">

</div>
<div class="section-box-conten">
    <div class="section-box ">
        <div class="box-wr">
            <div class="box-all">
            </div>
        </div>
    </div>

    <div class="section-box">
        <div class="box-wr">
            <div class="box-all">
                <div class="countdown_clock">
                    <p class="countdown">
                        <?= $current_sale['active'] ? $t->_('left_end_time') : $t->_('left_start_time') ?>
                    </p>
                    <p class="countdown_action"><?= $current_sale['full_name'] ?></p>
                    <div id="your-clock"></div>
                </div>
                <!-- КОНТЕНТ -->
                <?= $current_sale['description'] ?>

                <?= $this->partial('partial/sale_groups', ['groups' => $groups, 'link' => $current_sale['link'] . '/items']) ?>

                <div class="more_actions">
                    <p class="more_actions_p"><?= $t->_('more_sales') ?></p>
                    <?= $this->partial('partial/recentSales', ['classic_sales', $classic_sales]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section-box grey">
        <div class="box-wr">
            <div class="box-all">
                <ul>
                    <li>
                        <a href="<?= $this->seoUrl->setUrl('/') ?>"><?= $t->_('main_page') ?></a>
                    </li>
                    <img src="/landing_sales/images/arrows.png">
                    <li>
                        <a href="<?= $this->seoUrl->setUrl('/news-actions') ?>"><?= $t->_('akcii') ?></a>
                    </li>
                    <img src="/landing_sales/images/arrows.png">
                    <li>
                        <a style="text-decoration: none" href="<?= $this->seoUrl->setUrl($current_sale['link']) ?>"><?= $current_sale['full_name'] ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
<?= $this->partial('partial/share'); ?>
<script>
    $(document).ready(function() {
        var counter = new Counter(<?= $time_left ?>,'#your-clock', true );
    });
</script>
