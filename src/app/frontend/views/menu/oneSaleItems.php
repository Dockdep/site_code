<div <?= !empty($current_sale['banner'])
    ? 'style="background: url('.  $this->storage->getPhotoURL($current_sale['banner'], 'sales/banner', 'original') .') no-repeat center center; height:320px"'
    : '' ?> class="catalog_slider">

</div>
<div class="sidebar_content_wrapper" itemscope itemtype="http://schema.org/Product">
    <div class="top_items inner clearfix">
        <div id="content_wrapper subcategory" class="float">
            <?php $this->partial('partial/items', ['items' => $items]) ?>
        </div>
    </div>
</div>
<?= $this->partial('partial/share'); ?>
