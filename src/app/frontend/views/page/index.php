<div id="content" class="clearfix">

<div id="layerslider-container-fw">
    <div id="layerslider" style="width: 100%; min-width: 960px; height: 320px; margin: 0px auto; ">
        <?php foreach($active_sales as $k => $sale): ?>
            <?php if($sale['show_banner'] && !empty($sale['banner'])): ?>
            <div class="ls-layer" style="slidedirection: right; transition2d: 110,111,112,113; ">
                <img src="<?= $this->storage->getPhotoURL($sale['banner'], 'sales/banner', 'original') ?>" class="ls-bg" alt="Slide background">
                <a href = "<?= !empty($sale['link']) ? $sale['link'] : '#' ?>" class="ls-link">
                    <?php if($sale['show_counter']): ?>
                        <div class="ls-clock-wrapper">
                            <p style="margin-top: 10px" class="countdown">
                                <?= $t->_('left_end_time') ?>
                            </p>
                            <div id="<?= $k ?>-clock"></div>
                        </div>
                    <?php endif; ?>
                </a>
            </div>

            <?php endif; ?>
        <?php endforeach; ?>
        <?php foreach($slider as $image):?>

            <div class="ls-layer" style="slidedirection: right; transition2d: 110,111,112,113; ">
                <img src="<?=$this->storage->getBanerUrl($image['image'])?>" class="ls-bg" alt="Slide background">
                <a href = "<?= !empty($image['link']) ? $image['link'] : '#' ?>" class="ls-link"></a>
            </div>

        <?php endforeach ?>

    </div>
</div>

<a name="catalog"></a>

<div id="content_nav" class="clearfix">
    <div class="inner">
        <div class="content_nav_first_floor clearfix">
            <?php

            $data =
                '<div class="content_nav_logo float">'.
                '<a href="'.$this->seoUrl->setUrl($catalog_first['alias']).'" title="'.$catalog_first['title'].'"><img src="/images/types_logo/1.jpg" alt="'.$catalog_first['title'].'" width="99" height="99" /></a>'.
                '<a href="'.$this->seoUrl->setUrl($catalog_first['alias']).'" title="'.$catalog_first['title'].'"><h2 class="types_logo_1">'.$t->_("vegetable_seeds").'</h2></a>'.
                '</div>'.
                '<div class="content_nav_items float">';

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
                /*
                 * Не выводить оборудование мб изменить потом
                 */
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

<div class="content_items clearfix">
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

<?php if( !empty( $prof_stock_items ) ): ?>
        <div class="stock_items clearfix" data-class="prof_stock_items">
            <div class="title clearfix">
                <div class="float"><span class="items_title"><?= $t->_("prof_stock") ?></span></div>
                <div class="float">
                    <a class="float content_arrow_left" href="#" title=""></a>
                    <span class="float content_items_page page_number">1</span>
                    <span class="float content_items_page">/</span>
                    <span class="float content_items_page max_page"><?= $pages_prof_stock_items ?></span>
                    <a class="float content_arrow_right" href="#" title=""></a>
                </div>
            </div>
            <div class="items clearfix">
                <?php foreach( $prof_stock_items as $k => $i ): ?>
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
</div><!-- content_items -->

<div class="content_blog">
    <div class="inner">
        <div class="posts clearfix" style="margin-bottom:20px;padding-bottom:0px;">
            <?php

            if( !empty( $news ) )
            {
                $data_news =
                    '<div class="text_posts float">
                    <div class="text_posts_title">
                        <a href="'.$this->seoUrl->setUrl($this->url->get([ 'for' => 'prof_tips' ])).'" title="'.$t->_("prof_tips").'">'.$t->_("prof_tips").'</a>
                    </div>';

                foreach( $news as $k => $n )
                {

                    $data_news .=
                        '<div class="one_post'.( $k == 0 ? ' first clearfix' : ( $k == 3 ? ' last float' : ' float' ) ).'">'.
                        '<div class="one_post_image float">'.
                        '<a href="'.$this->seoUrl->setUrl($n['link']).'" title=""><img src="'.( $k == 0 ? $n['image_big'] : $n['image_small'] ).'" alt=""  />'.
                        (!empty( $n['video']) ? '<img class="video_play" src="/images/video_play.png" />' : '').'</a>'.
                        '</div>'.
                        '<div class="one_post_content float">'.
                        '<p class="one_post_title">'.
                        '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="">'.$n['title'].'</a>'.
                        '</p>'.
                        ( $k == 0
                            ?
                            '<p>'.
                            $n['abstract_info'].
                            '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="" class="more"><img src="/images/more.gif" alt="" height="7" width="7" />'.
                            (!empty( $n['video']) ? '<img class="video_play" src="/images/video_play.png" />' : '').'</a>'.
                            '</p>'
                            :
                            '').
                        '</div>'.
                        '</div>';
                }

                $data_news .= '</div>';

                echo( $data_news );
            }

            if( !empty( $videos ) )
            {
                $data_video =
                    '<div class="video_posts float last">'.
                    '<div class="one_video">
                    <iframe class="video_iframe" width="460" height="300" src="'.$videos['0']['video'].'" frameborder="0" allowfullscreen></iframe>
                </div>';

                foreach( $videos as $k => $v )
                {   if(!empty($v['video'])){
                    $data_video .=
                        '<div class="one_video_title float" data-video_srs="'.$v['video'].'">'.
                        '<a href="'.$this->seoUrl->setUrl($v['link']).'" title="'.$v['title'].'">'.
                        '<img src="/images/play.png" alt="'.$v['title'].'" width="15" height="13" />'.
                        $v['title'].
                        '</a>'.
                        '</div>';
                }

                }

                $data_video .= '</div>';

                echo( $data_video );
            }

            ?>

        </div>
    </div>
</div>
<!--
<div class="inner">
<div class="text_posts_title" style="font-weight:bold;font-size:16px;margin-bottom:20px;">
<?=$t->_("vidguk");?>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
fjs.parentNode.insertBefore(
js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-comments" data-href="http://semena.in.ua/" data-width="960" data-numposts="5" data-colorscheme="light"></div>
</div>
-->

<div class="content_accost">
    <div class="shadow_to_down"></div>
    <div class="inner">
        <div class="content_accost_title"><h1><?= $t->_("internet_store") ?></h1></div>
        <div class="content_accost_content">
            <?= $t->_("main_page_text_2")?>
        </div>
    </div>
</div><!-- content_accost -->

<?= $this->partial('partial/share'); ?>

<div class="map clearfix">
    <div id="google-map" style="width: 100%; height: 380px;"></div>
</div>

</div>

<script>
    $(document).ready(function() {
        <?php foreach($active_sales as $k => $sale): ?>
        <?php if($sale['show_counter']): ?>
        var counter<?= $k ?> = new Counter(<?= $sale['seconds_left'] ?>,'#<?= $k ?>-clock' );
        <?php endif; ?>
        <?php endforeach; ?>
    });
</script>


