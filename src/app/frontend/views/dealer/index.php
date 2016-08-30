<section style="overflow: visible; display: block; margin: 0" class="content">
    <div id="content_nav" class="clearfix">
        <div class="inner">
            <div class="content_nav_first_floor clearfix">
                <?php

                $data =
                    '<div class="content_nav_logo float">'.
                    '<a href="'.$this->seoUrl->setUrl($catalog_first['alias']).'" title="'.$catalog_first['title'].'"><img src="/images/types_logo/1.jpg" alt="'.$catalog_first['title'].'" width="99" height="99" /></a>'.
                    '<a href="'.$this->seoUrl->setUrl($catalog_first['alias']).'" title="'.$catalog_first['title'].'"><h2 class="types_logo_1">'.$t->_("vegetable_seeds").'</h2></a>'.
                    '</div>'.
                    '<div class="content_nav_items float" style="column-width:initial;-moz-column-width:initial;-webkit-column-width:initial;">';

                foreach( $catalog_first['sub'] as $c )
                {
                    $data .= '<a href="'.$this->seoUrl->setUrl($c['alias']).'" title="'.$c['title'].'">'.$c['title'].'</a>';
                }

                $data.= '</div>';

                echo( $data );

                ?>

            </div>
            <div class="content_nav_second_floor clearfix">

                <?php

                $data_catalog = '';

                foreach( $catalog as $k => $c )
                {
                    if(in_array($k, config::get( 'equipment' ))) continue;

                    $data_catalog .=
                        '<div class="float">'.
                        '<div class="content_nav_logo">'.
                        '<a href="'.$this->seoUrl->setUrl($c['alias']).'" title="'.$c['title'].'"><img src="/images/types_logo/'.$k.'.jpg" alt="'.$c['title'].'" width="99" height="99"></a>'.
                        '<a href="'.$this->seoUrl->setUrl($c['alias']).'" title="'.$c['title'].'"><h2 class="types_logo_'.$k.'">'.$c['title'].'</h2></a>'.
                        '</div>'.
                        '<div class="content_nav_items">';

                    if( !empty( $c['sub'] ) )
                    {
                        foreach( $c['sub'] as $v )
                        {
                            $data_catalog .= '<a href="'.$this->seoUrl->setUrl($v['alias']).'" title="'.$v['title'].'">'.$v['title'].'</a>';
                        }
                    }

                    $data_catalog .=
                        '</div>'.
                        '</div>';
                }
                echo( $data_catalog );

                ?>
            </div>

        </div>
        <div class="shadow_to_top"></div>
    </div><!-- content_nav -->
    <!--<div class="content_items clearfix">
        <div class="inner">

        <?php if( !empty( $stock_items ) ): ?>
            <div class="stock_items clearfix" data-class="stock_items">
                <div class="title clearfix">
                    <div class="float"><span class="items_title"><?= $t->_("akcii") ?></span></div>
                    <div class="float">
                        <a class="float content_arrow_left" href="#" title=""></a>
                        <span class="float content_items_page page_number">1</span>
                        <span class="float content_items_page">/</span>
                        <span class="float content_items_page max_page"><?= $pages_stock_items ?></span>
                        <a class="float content_arrow_right" href="#" title=""></a>
                    </div>
                </div>
                <div class="items clearfix">
                    <?php foreach( $stock_items as $k => $i ): ?>
                        <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 5]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if( !empty( $top_items ) ): ?>
            <div class="top_items clearfix" data-class="top_items">
                <div class="title clearfix">
                    <div class="float"><span class="items_title"><?= $t->_("top_sales") ?></span></div>
                    <div class="float">
                        <a class="float content_arrow_left" href="#" title=""></a>
                        <span class="float content_items_page page_number">1</span>
                        <span class="float content_items_page">/</span>
                        <span class="float content_items_page max_page"><?= $pages_top_items ?></span>
                        <a class="float content_arrow_right" href="#" title=""></a>
                    </div>
                </div>
                <div class="items clearfix">

                    <?php foreach( $top_items as $k => $i ): ?>
                        <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 5]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if( !empty( $recommended_items ) ): ?>
            <div class="recomended_items clearfix" data-class="recomended_items">
                <div class="title clearfix">
                    <div class="float"><span class="items_title"><?= $t->_("recommended") ?></span></div>
                    <div class="float">
                        <a class="float content_arrow_left" href="#" title=""></a>
                        <span class="float content_items_page page_number">1</span>
                        <span class="float content_items_page">/</span>
                        <span class="float content_items_page max_page"><?= $pages_recommended_items ?></span>
                        <a class="float content_arrow_right" href="#" title=""></a>
                    </div>
                </div>
                <div class="items clearfix">

                    <?php foreach( $recommended_items as $k => $i ): ?>
                        <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 5]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if( !empty( $new_items ) ): ?>
            <div class="new_items clearfix" data-class="new_items">
                <div class="title clearfix">
                    <div class="float"><span class="items_title"><?= $t->_("new_items") ?></span></div>
                    <div class="float">
                        <a class="float content_arrow_left" href="#" title=""></a>
                        <span class="float content_items_page page_number">1</span>
                        <span class="float content_items_page">/</span>
                        <span class="float content_items_page max_page"><?= $pages_new_items ?></span>
                        <a class="float content_arrow_right" href="#" title=""></a>
                    </div>
                </div>
                <div class="items clearfix">
                    <?php foreach( $new_items as $k => $i ): ?>
                        <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 5]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        </div>
    </div> -->
</section>