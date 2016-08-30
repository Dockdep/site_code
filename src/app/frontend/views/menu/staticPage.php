<div id="content" class="clearfix">
<div class="static_page">
<div class="breadcrumbs">
    <div class="inner">
        <div class="item_menu_shadow"></div>
        <ul class="clearfix">
            <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a  itemprop="url" href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <?= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a  itemprop="url" href="'.$this->seoUrl->setUrl($page['alias']).'" title="'.$page['content_title'].'"><span itemprop="title">'.$page['content_title'].'</span></a></li>' ?>
        </ul>
    </div>
</div>
<div class="static_page_wrapper">
    <div class="inner clearfix">

        <?= $page['content_text'] ?>
    </div>

    <?= $this->partial('partial/share'); ?>
</div>



</div>
</div>
