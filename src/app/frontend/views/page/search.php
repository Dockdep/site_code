<div id="content" class="clearfix">
<div class="search">
<div class="breadcrumbs">
    <div class="inner">
        <div class="order_menu_shadow"></div>
        <ul class="clearfix">
            <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a href="/" title="<?= $t->_("main_page") ?>"  itemprop="url" ><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a href="#" title="Результати пошуку" class="breadcrumbs_last"  itemprop="url" ><span itemprop="title">Результати пошуку</span></a></li>
        </ul>
    </div>
</div>
<div class="sidebar_content_wrapper">
    <div class="inner clearfix">
        <!--<div id="sidebar" class="float">
            <?php

            if( !empty( $type_subtype ) )
            {
                $data_types =
                    '<div class="subcategory_sidebar_title">
                        <p>Знайдено в категоріях:</p>
                    </div>
                    <ul>';

                foreach( $type_subtype as $s )
                {
                    $data_types .=
                        '<li>'.
                            '<a href="'.$this->url->get([ 'for' => 'type', 'type' => $s['type_alias'] ]).'" title="'.$s['type_title'].'">'.$s['type_title'].'</a>';
                    foreach( $s['subtype'] as $val )
                    {
                        $data_types .=
                            '<ul>'.
                                '<li><a href="'.$this->url->get([ 'for' => 'subtype', 'type' => $s['type_alias'], 'subtype' => $val['subtype_alias'] ]).'" title="'.$val['subtype_title'].'">'.$val['subtype_title'].'</a></li>'.
                            '</ul>';
                    }

                    $data_types .= '</li>';
                }
            }
            else
            {
                $data_types =
                    '<div class="subcategory_sidebar_title">
                        <p>За данним запитом нічого не знайдено</p>
                    </div>';
            }

            echo($data_types);

            ?>
            </ul>

        </div>-->
        <div id="content_wrapper" class="float">

        <?php if( !empty( $groups ) ): ?>
            <div class="items clearfix">
            <?php foreach( $groups as $k => $i ):
                $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 3]);
            endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php

if( $total > \config::get( 'limits/items') )
{
    echo('<div class="inner"><div class="paginate">');
    echo $paginate;
    echo('</div></div>');
}

?>


<div class="content_blog">
    <div class="inner">

        <div class="links clearfix">

            <div class="float fb">
                <div id="fb-root"></div>

                <div class="fb-like" data-href="#" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            </div>
            <div class="float ok">
                <div id="ok_shareWidget"></div>
            </div>
            <div class="float vk">
                <script type="text/javascript"><!--
                    document.write(VK.Share.button(false,{type: "round", text: "Нравится"}));
                    -->
                </script>
            </div>

            <div class="float share">
                <p class="share_title float"><?= $t->_("share")?>:</p>

                <div class="pluso float" data-background="#ebebeb" data-options="small,square,line,horizontal,nocounter,theme=04" data-services="facebook,google,livejournal,moimir,odnoklassniki,vkontakte,twitter"></div>
            </div>
        </div>
    </div>

</div><!-- content_blog -->
</div><!-- catalog -->
</div>
 