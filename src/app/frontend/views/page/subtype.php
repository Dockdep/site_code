<div id="content" class="clearfix">
<div class="subcategory">
<?php $banner = $this->getDi()->get('models')->getBanner()->getBannerLike();
    $url = $this->router->getRewriteUri();
?>
<?php if(!empty($banner)){?>
    <div style = "background: url('<?= $this->storage->getBanerUrl($banner['image']) ?>') no-repeat center center; position: relative" class="catalog_slider">

        <div class="inner">
            <div class="catalog_description logo<?= $catalog['id'] ?>">
                <div class="catalog_description_image float">
                    <?= '<a href="'.$this->seoUrl->setUrl($type_alias).'" title="'.$catalog['title'].'"><img src="/images/types_logo/'.$catalog['id'].'.jpg" alt="'.$catalog['title'].'" width="99" height="99" /></a>' ?>
                </div>
                <div class="catalog_description_content float">
                    <h2 class="catalog_description_title">
                        <?= '<a href="'.$this->seoUrl->setUrl($type_alias).'" title="'.$catalog['title'].'">'.$catalog['title'].'</a>' ?>
                    </h2>
                    <p>
                        <?= $t->_("internet_store_seeds")?>
                    </p>
                </div>
            </div>
        </div>
    </div>	
<?php }else{?>
    <div class="catalog_slider">

        <div class="inner">
            <div class="catalog_description logo<?= $catalog['id'] ?>">
                <div class="catalog_description_image float">
                    <?= '<a href="'.$this->seoUrl->setUrl($type_alias).'" title="'.$catalog['title'].'"><img src="/images/types_logo/'.$catalog['id'].'.jpg" alt="'.$catalog['title'].'" width="99" height="99" /></a>' ?>
                </div>
                <div class="catalog_description_content float">
                    <h2 class="catalog_description_title">
                        <?= '<a href="'.$this->seoUrl->setUrl($type_alias).'" title="'.$catalog['title'].'">'.$catalog['title'].'</a>' ?>
                    </h2>
                    <p>
                        <?= $t->_("internet_store_seeds")?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php }?>


<div class="breadcrumbs">
    <div class="inner">
        <?= $breadcrumbs ?>
    </div>
</div>

<div class="<?= strstr($url, '/dobriva_ta_zasobi_zakhistu_1c0/zasobi_zakhistu_1c1') || strstr($url, '/udobrenija_i_sredstva_zashchity_1c_20/sredstva_zashchity_1c_21')  ? 'zasobi_zakhistu_logo' : '213' ?> sidebar_content_wrapper" itemscope itemtype="http://schema.org/Product">

<div class="inner clearfix">
<div id="sidebar" class="float">
    <div class="subcategory_sidebar_title">
        <h1 itemprop="name" class="seo-h1"><?= isset( $seo['h1'] ) && !empty( $seo['h1'] ) ?  $seo['h1'] : $catalog['sub']['title']; ?></h1>
        <p><?= $t->_("products_found_for_the_filter")?> <?= $total ?></p>
    </div>
    <?php

    if( !empty( $filters ) )
    {
        $data_filters = '<ul id="subcategory_menu">';

        foreach( $filters as $key => $val )
        {
            $data_filters .=
                '<li>'.
                '<div class="main clearfix">'.
                '<p class="float">'.$key.'</p>'.
                '<p class="float dropdown"></p>'.
                '</div>'.
                '<ul>';

            foreach( $val as $v )
            {
                $data_filters .=
                    '<li>'.
                    ((count($val)>1)?'<a href="'.$this->seoUrl->setUrl($v['alias']).'" title="" onClick="document.location=\''.$this->seoUrl->setUrl($v['alias']).'\';">':'').
                    '<input type="checkbox" '.((count($val)==1)?'disabled="disabled" checked':'').' id="'.$v['filter_value_id'].'" value="'.$v['filter_value_id'].'" '.(!empty( $v['checked'] ) ? 'checked="checked"' : '').' />'.
                    '<label for="'.$v['id'].'"><span></span>'.$v['filter_value_value'].'</label>'.
                    ((count($val)>1)?'</a>':'').
                    '</li>';
            }


            $data_filters .=
                '</ul>'.
                '</li>';
        }

        $data_filters .=
            '<li class="subcategory_menu_last_child">
                    <div class="main subcategory_menu_price clearfix">
                        <p class="float">'.$t->_("price").'</p>
                    </div>
                    <div class="price_slider_container">
                        <div class="border_for_slider">
                            <div id="slider"></div>
                        </div>
                        <div>
                            <label for="price_from" class="float">'.$t->_("from").'</label>
                            <input type="text" class="float" name="price_from" value="'.( isset($price_array) && !empty($price_array) ? $price_array['0'] : $max_min_price['min_price'] ).'" id="price_from" />
                            <label for="price_from" class="float">до</label>
                            <input type="text" class="float" name="price_to" value="'.( isset($price_array) && !empty($price_array) ? $price_array['1'] : $max_min_price['max_price'] ).'" id="price_to" />
                            <a href="'.$this->seoUrl->setUrl($current_url).'" class="price_ok"><img src="/images/price_ok.png" width="7" height="7" alt="Ok" /></a>
                            <input type="hidden" value="'.$current_url_without_price.'" class="current_url">
                            <input type="hidden" value="'.$max_min_price['min_price'].'" class="min_price">
                            <input type="hidden" value="'.($max_min_price['max_price']+1).'" class="max_price">
                            <input type="hidden" value="'.( !empty($sort) ? join('-', $sort) : '' ).'" class="sort_params">
                        </div>
                    </div>
                </li>'.
            '</ul>';

        echo( $data_filters );
    }

    ?>
    <?php foreach($catalog_sales as $k => $sale): ?>
        <?= $this->partial('partial/one_sale', ['k' => $k, 'sale' => $sale]) ?>
    <?php endforeach; ?>
</div>
<div id="content_wrapper" class="float">


    <?php

    if( !empty( $groups ) )
    {
        $data_items =
            '<div class="content_wrapper_header">'.
            '<div class="content_wrapper_header_filters clearfix">';

        if( !empty( $filters_applied ) )
        {
            foreach( $filters_applied as $f )
            {
                $data_items .= '<div class="float"><a href="'.$this->seoUrl->setUrl($f['alias']).'" title="">'.$f['filter_value_value'].'</a></div>';
            }

            $data_items .= '<div class="float empty_filters"><a href="'.$this->seoUrl->setUrl($this->url->get([ 'for' => 'subtype', 'type' => $type_alias, 'subtype' => $subtype_alias ])).'"  title="Скинути всі фільтри">Скинути всі фільтри</a></div>';
        }
        $sortName[3] = $t->_("from_cheap_to_expensive");
        $sortName[4] = $t->_("from_expensive_to_cheap");
        $sortName[5] = $t->_("sort_alphabetically");
        $data_items .=
            '</div>
            <div class="content_wrapper_header_menu change_sort clearfix">
                <div class="tabs float">
                    <ul>
                        <li class="tabs_all_items float '.( in_array( 1, $sort ) ? 'previous' : '' ).' '.( in_array( 0, $sort ) || empty( $sort ) ? 'active_tab' : 'not_active' ).' first_tab" onClick="document.location=\''.$current_url.'\'">'.
            '<a href="'.$this->seoUrl->setUrl($current_url).'" title="">'.$t->_("all").'</a>'.
            '</li>

                        <li class="tabs_new_items float '.( in_array( 2, $sort ) ? 'previous' : '' ).' '.( in_array( 1, $sort ) ? 'active_tab' : 'not_active' ).'" onClick="document.location=\''.$this->url->get(['for' => 'subtype_sorted', 'type' => $type_alias, 'subtype' => $subtype_alias, 'sort' => '1-'.$sort_default_2]).'\'">'.
            '<a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['1'])).'" title="">'.$t->_("what_new").'</a>'.
            '</li>

                        <li class="tabs_top_items float  '.( in_array( 2, $sort ) ? 'active_tab' : 'not_active' ).' last_tab" onClick="document.location=\''.$this->url->get(['for' => 'subtype_sorted', 'type' => $type_alias, 'subtype' => $subtype_alias, 'sort' => '2-'.$sort_default_2]).'\'">'.
            '<a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['2'])).'" title="">'.$t->_("top_sales").'</a>'.
            '</li>
                    </ul>
                </div>
                <div class="thumbs active float padding_60">
                    <a href="#" title=""></a>
                </div>
                <div class="lists float">
                    <a href="#" title="" class="float"></a>
                </div>
                <div class="sort_price float padding_60">
                    <span>'.$t->_("sort").':</span>
                </div>
                <div class="sort_price float last">
                    <a href="#" title="">'.( in_array( 3, $sort ) ? $sortName[3] : (in_array( 4, $sort )? $sortName[4] :$sortName[5]) ).'</a>
                    <div class="sort_price_dropdown display_none">
                        <ul>
                            <li><a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['3'])).'" title="">'.$sortName[3].'</a></li>
                            <li><a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['4'])).'" title="">'.$sortName[4].'</a></li>
                            <li><a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['5'])).'" title="">'.$sortName[5].'</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        '; ?>

    <?= $data_items ?>
    <div class="items clearfix">
    <?php
        $maxPrice = 0;
        $minPrice = 0;
    ?>
    <?php foreach ($groups as $k => $i): ?>
        <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 3]) ?>
        <?php
        if ($i['price'] > $maxPrice) {
            $maxPrice = $i['price'];
        } elseif ($i['price'] < $maxPrice) {
            $minPrice = $i['price'];
        }
        ?>
    <?php endforeach; ?>
    </div>
    <?php } ?>
    <?php

    if( $total > \config::get( 'limits/items') )
    {
        echo'<div class="inner1"><div class="paginate" align="center">';
        echo $paginate;
        if(empty($_GET['all']))echo'<div align="center"><a href="'.$this->seoUrl->setUrl($this->url->get($page_url_for_sort['3'])).'?all=1" style="display:block;margin-bottom:20px;">'.$t->_("show_all").'</a></div>';
        echo '</div></div>';

    }

    ?>

</div>
</div>
    <div style="display:none;" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
        <span itemprop="priceCurrency">UAH</span>
        <span itemprop="lowPrice"><?=$max_min_price['min_price']?></span>
        <span itemprop="highPrice"><?=$max_min_price['max_price']?></span>
    </div>
    <div style="display: none" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <span itemprop="ratingValue">5</span>
        <span itemprop="reviewCount">51</span>
    </div>
</div>


<?php if(!isset($page) || $page == 1):?>
    <div class="content_accost">
        <div class="shadow_to_down"></div>
        <div class="inner">
            <div class="content_accost_title"></div>
            <div class="content_accost_content">
                <p>
                    <?= isset(  $seo['seo_text']  ) && !empty(  $seo['seo_text']  ) ?   $seo['seo_text']  : ''?>
                </p>
            </div>
        </div>
    </div>
<?php endif ?>

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
