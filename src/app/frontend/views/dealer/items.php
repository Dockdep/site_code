<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<div class="sidebar_content_wrapper" itemscope itemtype="http://schema.org/Product">
    <div class="top_items inner clearfix">
        <div id="content_wrapper subcategory" class="float">
            <?php $this->partial('partial/items', ['items' => $items]) ?>
        </div>
    </div>
</div>
</section>