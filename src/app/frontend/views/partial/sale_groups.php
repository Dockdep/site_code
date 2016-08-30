<div class="items">
<div id="carousel-sale-groups" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <?php $indicators = count($groups) / 5 ?>


    <!-- Wrapper for slides -->
    <div style="height: 380px" class="carousel-inner" role="listbox">
        <?php foreach($groups as $k => $group): ?>
            <?php if($k % 5 == 0): ?>
                <div class="item<?= ($k == 0) ? ' active' : '' ?>">
            <?php endif; ?>
                <?= $this->partial('partial/item_group', ['k' => $k, 'i' => $group, 'limit' => 1000000]) ?>
            <?php if((($k + 1) % 5 == 0) || empty($groups[$k + 1])): ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <?php if($indicators > 1): ?>
        <a class="left carousel-control" href="#carousel-sale-groups" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-sale-groups" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    <?php endif; ?>
    <a style="text-align: center" href="<?= $this->seoUrl->setUrl($link)?>">
        <?= $t->_('show_all') ?>
    </a>
</div>
</div>