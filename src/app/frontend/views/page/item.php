<div id="content" class="clearfix">
<div class="item">
<div class="breadcrumbs">
    <div class="inner">
        <div class="item_menu_shadow"></div>
        <?= $breadcrumbs ?>
    </div>
</div>
    <?php $url = $this->router->getRewriteUri(); ?>

    <div class="<?= strstr($url, '/dobriva_ta_zasobi_zakhistu_1c0/zasobi_zakhistu_1c1') || strstr($url, '/udobrenija_i_sredstva_zashchity_1c_20/sredstva_zashchity_1c_21')  ? 'zasobi_zakhistu_logo' : null ?> item_wrapper"  itemscope itemtype="http://schema.org/Product">
    <div class="inner clearfix">
        <div class="float item_images">
            <ul class="thumbnails">
                <?php

                $data_images = '';

                if( !empty( $item['images'] ) )
                {
                    $data_images .=
                        '<li class="float width_400 '.(count($item['images'])%3==0 ? 'last' : '').'">'.
                            '<a href="'.$this->storage->getPhotoUrl( $item['images'][0], 'group', '800x' ).'" title="'.$item['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['cover'], 'avatar', '128x' ).'\'"  class="thumbnail">'.
                                '<img src="'.$this->storage->getPhotoUrl( $item['images'][0], 'group', '400x400' ).'" alt="'.$item['title'].'" class="image_400">'.
                            '</a>'.
                        '</li>';						

                    foreach( $item['images'] as $k => $i )
                    {
                        $data_images .=
                            '<li class="float width_128 '.(($k+1)%3==0 ? 'last' : '').'">'.
                                '<a href="'.$this->storage->getPhotoUrl( $i, 'group', '800x' ).'" title="'.$item['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'\'"  class="thumbnail">'.
                                    '<img itemprop="image" title="'.$item['title'].'" src="'.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'" alt="Купити '.$item['title'].' в Києві та Львові" class="image_128">'.
                                '</a>'.
                            '</li>';
                    }


                }
                elseif( !empty( $item['cover'] ) && empty( $item['images'] ) )
                {
                    $data_images .=
                        '<li class="float width_400">'.
                            '<a href="'.$this->storage->getPhotoUrl( $item['cover'], 'avatar', '800x' ).'" title="'.$item['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['cover'], 'avatar', '128x' ).'\'"  class="thumbnail">'.
                                '<img src="'.$this->storage->getPhotoUrl( $item['cover'], 'avatar', '400x' ).'" alt="'.$item['title'].'" class="image_400">'.
                            '</a>'.
                        '</li>';
                }
                else
                {
                    $data_images .=
                        '<li class="float width_400">
                            <img src="/images/item_main_photo.jpg" alt="" width="400" height="400">
                        </li>

                        <li class="float width_128"><img src="/images/item_photo.jpg" alt="" width="128" height="128"></li>
                        <li class="float width_128 last"><img src="/images/item_photo.jpg" alt="" width="128" height="128"></li>';
                }
                echo( $data_images );

                ?>

            </ul>
            <?php if(!empty($item['front_video'])):?>
                <br>
                <div class="front_video_block">
                    <?php if(!empty($item['front_video'])){
                        $video = explode(',',$item['front_video']);
                        foreach($video as $v): ?>
                            <iframe class="video_iframe" width="400" height="220" src="<?= $v ?>" frameborder="0" allowfullscreen></iframe>
                        <?php endforeach;
                    }?>
                </div>
            <?php endif;?>
        </div>

        <div class="float item_content">
            <div class="item_title"><h1 class="item_name_h1" itemprop="name"><?= $item['title'] ?></h1></div>
            <div class="item_decription"><?= $item['description'] ?></div>
            <div style="float:right;width:270px;font-weight:bold;line-height:20px;">
				<img src="/images/truck.jpg" width="64" height="64" border="0" align="left" style="margin-right:10px;" />
				<?= $t->_("truck")?>
			</div>
			<div style="float:left">
			<div class="clearfix">
                <div class="float properties">Код:</div>
                <div class="float properties properties_article"><?= $item['product_id'] ?></div>
            </div>
            <div class="clearfix">
                <div class="float properties"><?= $t->_("availability")?>:</div>
                <div class="float presence_status">
                    <?=  $item['status'] == 1 ? '<div data-stock="1" id="stock" class="properties properties_presence ">'.$t->_("in_stock").'</div>' : ($item['status'] == 2 ? '<div data-stock="0" id="stock" class="properties properties_absent">'.$t->_("znyt").'</div>' : '<div data-stock="0" id="stock" class="properties properties_absent">'.$t->_("missing").'</div>'); ?>
                </div>
            </div>

            <div class="clearfix">
                <div class="float properties"><?= $t->_("number_of") ?>:</div>
                <div class="float count minus">
                </div>
                <div class="float count count_input">
                    <input name="count_items" class="count_items" type="text" value="1" />
                </div>
                <div class="float count plus">
                </div>
            </div>
            </div><div style="clear:both;"></div>
            <div class="clearfix packing">
                <div class="float properties"><?= $t->_("packing")?>:</div>
                <div class="float packing_images clearfix">
                    <?php

                    $data_sizes = '';

                    if( !empty( $sizes_colors__ ) )
                    {
                        $i = 0;
                        foreach( $sizes_colors['sizes'] as $k => $s )
                        {
                            if( isset( $sizes_colors__[$item['color_id']][$s] ) )
                            {
                                $data_sizes .=
                                    '<a href="'.$sizes_colors__[$item['color_id']][$s]['link'].'" class="group_sizes'.($s == $item['size'] ? ' active' : '').' exist" style="padding-top:'.($i*3).'px; width:'.(31+($i*3)).'px" data-item_id="'.$sizes_colors__[$item['color_id']][$s]['id'].'" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                                        '<span class="group_sizes_header"></span>'.
                                        '<span class="group_sizes_content">'.$s.'</span>'.
                                    '</a>';
                            }
                            else
                            {
                                $data_sizes .=
                                    '<a href="#" onClick="return false;" class="group_sizes'.($s == $item['size'] ? ' active' : '').' not_exist" style="padding-top:'.($i*3).'px; width:'.(31+($i*3)).'px" data-item_id="" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                                        '<span class="group_sizes_header"></span>'.
                                        '<span class="group_sizes_content">'.$s.'</span>'.
                                    '</a>';
                            }

                            $i++;
                        }
                    }
                    else
                    {
                        foreach( $sizes as $k => $s )
                        {
                            $data_sizes .=
                                '<a href="'.$this->seoUrl->setUrl($s['link']).'" class="group_sizes'.($k == $active_size ? ' active' : '').'" style="padding-top:'.($k*3).'px; width:'.(31+($k*3)).'px" data-item_id="'.$s['id'].'" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                                    '<span class="group_sizes_header"></span>'.
                                    '<span class="group_sizes_content">'.$s['size'].'</span>'.
                                '</a>';
                        }
                    }

                    echo( $data_sizes );

                    ?>

                </div>
            </div>

            <?php

            if( !empty( $sizes_colors__ ) )
            {
                $data_colors =
                    '<div class="clearfix colors">'.
                        '<div class="float properties">'.$t->_("choose_color").': </div>'.
                        '<div class="float properties" style="color:'.$item['absolute_color'].'">'.$item['color_title'].'</div>'.
                    '</div>'.

                    '<div class="sliderkit carousel-demo1 colors_images clearfix">'.
                        '<div class="sliderkit-nav">';

                            $data_colors .= '<div class="sliderkit-nav-clip" '.( count( $sizes_colors__ ) > 6 ? 'style="margin: 0 30px"' : '' ).'><ul>';

                            foreach( $sizes_colors__ as $k => $s )
                            {
                                sort($s);
                                $data_colors .=
                                    '<li class="change_with_color" data-item_id="'.$s['0']['id'].'" data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'" data-group_alias="'.$group_alias.'" data-color_id="'.$s['0']['color_id'].'">'.
                                        '<a href="'.$this->seoUrl->setUrl($s['0']['link']).'" title="'.$s['0']['color_title'].'" '.( $s['0']['color_id'] == $item['color_id'] ? 'class="active" style="border-color:'.$item['absolute_color'].'"' : '' ).' ><img src="'.$s['0']['image'].'" alt="'.$s['0']['color_title'].'" width="60" height="60" /></a>'.
                                    '</li>';
                            }

                            $data_colors .= '</ul></div>';

                            if( count( $sizes_colors__ ) > 6 )
                            {
                                $data_colors .=
                                    '<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a href="#" title="Previous line"><span>Previous</span></a></div>'.
                                    '<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a href="#" title="Next line"><span>Next</span></a></div>';
                            }

                            $data_colors .=
                        '</div>'.
                    '</div>';

                echo $data_colors;
            }

            ?>

            <div class="change_with_size">
                <div class="clearfix buy_compare">
                    <div class="one_item_price float" itemprop="offers" itemscope itemtype="http://schema.org/Offer" ><?= $t->_("price")?>
                        <ul>
                            <li>
                                <span itemprop="price"><?= number_format($item['price2'],2,'.',' ') ?></span> грн<span style="display:none;" itemprop="priceCurrency">UAH</span>
                                <div style="display: none" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                    <span itemprop="ratingValue">5</span>
                                    <span itemprop="reviewCount">31</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="one_item_buttons float">
					   <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'item', 'type' => $type_alias, 'subtype' => $subtype_alias, 'group_alias' => $group_alias, 'item_id' => $item_id ])); ?>" title="Додати <?= $item['title'] ?> у корзину" class="<?= $item['status'] == 1 ? 'btn green buy' : 'not_available grey'?>"><?= $t->_("buy")?></a>
					</div>
                    <div class="one_item_compare float">
                        <?= '<input type="checkbox" id="compare_item_'.$item['id'].'" class="compare_item" value="'.$item['type'].'-'.$catalog_id.'-'.$item['id'].'" '.(!empty($item['checked']) ? 'checked="checked"' : '').' />' ?>
                        <label for="compare_item_<?= $item['id'] ?>"><span></span><?= $t->_("compared_to")?></label>
                        <input type="hidden" class="item_id_for_basket" value="<?= $item['id'] ?>">
                        <input type="hidden" class="current_item_size" value="<?= $item['size'] ?>">
                    </div>
                </div>
                <div class="clearfix features">
                    <?php

                    $data_features = '';

                    foreach( $filters as $f )
                    {
                        $data_features .= '<a href="#" class="float">'.$f['value_value'].'</a>';
                    }

                    echo( $data_features );

                    ?>
                </div>
            </div>
            <div class="clearfix item_menu">
                <div class="item_menu_header_menu clearfix">
                    <div class="tabs clearfix">
                        <ul class="change_item_description">
                            <li class="float active_tab first_tab" data-change_item_description="tabs_description"><a href="#" title=""><?= $t->_("description")?></a></li>
                            <li class="float not_active" data-change_item_description="tabs_properties"><a href="#" title=""><?= $t->_("features")?></a></li>
                            <?php if(!empty($item['content_video'])):?><li class="float not_active" data-change_item_description="tabs_video"><a href="#" title=""><?= $t->_("video")?></a></li><?php endif;?>
                            <li class="float last_tab not_active" data-change_item_description="tabs_comments"><a href="#" title=""><?= $t->_("reviews")?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="item_menu_content">
                    <div class="tabs_description item_menu_content_wrapper" itemprop="description"><?= $item['content_description'] ?></div>
                    <div class="display_none tabs_properties item_menu_content_wrapper">
                        <?php

                        $data_properties = '';

                        if( isset( $item['brand'] ) && !empty( $item['brand'] ) )
                        {
                            $data_properties .=
                                '<div class="clearfix properties_producer">'.
                                    '<p class="float key_value">'.$t->_("producer").':</p>'.
                                    '<a class="float" href="#" title="'.$item['brand'].'">'.$item['brand'].'</a>'.
                                '</div>';
                        }

                        if( isset( $properties ) && !empty( $properties ) )
                        {
                            $data_properties .= '<div class="item_properties">';

                            foreach( $properties as $p )
                            {
                                $data_properties .=
                                    '<div class="clearfix">'.
                                        '<p class="float key_value">'.$p['key_value'].':</p>'.
                                        '<a class="float" href="#">'.$p['value_value'].'</a>'.
                                    '</div>';
                            }

                            $data_properties .= '</div>';
                        }

                        echo( $data_properties );

                        ?>
                    </div>
                    <div class="display_none tabs_video item_menu_content_wrapper">
                        <?php if(!empty($item['content_video'])){
                            $video = explode(',',$item['content_video']);
                            foreach($video as $v): ?>
                                <iframe class="video_iframe" width="520" height="340" src="<?= $v ?>" frameborder="0" allowfullscreen></iframe>
                            <?php endforeach;
                        }?>
                    </div>
					<div class="display_none tabs_comments item_menu_content_wrapper">
                        <div id="mc-review"></div>
                        <script type="text/javascript">
                            cackle_widget = window.cackle_widget || [];
                            cackle_widget.push({widget: 'Review', id: 38277});
                            (function() {
                                var mc = document.createElement('script');
                                mc.type = 'text/javascript';
                                mc.async = true;
                                mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
                            })();
                        </script>
                        <a id="mc-link" href="http://cackle.ru">Социальные отзывы <b style="color:#4FA3DA">Cackl</b><b style="color:#F65077">e</b></a>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="other_items">
    <div class="item_menu_header_menu clearfix">
        <div class="inner">
            <div class="tabs clearfix">
                <ul class="change_similar_items">
                    <li class="float  active_tab first_tab">
                        <?= '<a href="#" title="'.$t->_("related_items").'" data-change_similar_items="buy_with"  data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("related_items").'</a>' ?>
                    </li>
                    <li class="float not_active">
                        <?= '<a href="#" title="'.$t->_("similar_items").'" data-change_similar_items="same"        data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("similar_items").'</a>' ?>
                    </li>
                    <li class="float not_active">
                        <?= '<a href="#" title="'.$t->_("popular_items").'" data-change_similar_items="popular" data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("popular_items").'</a>' ?>
                     </li>
                    <li class="float last_tab not_active">
                        <?= '<a href="#" title="'.$t->_("watched").'" data-change_similar_items="viewed"       data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("watched").'</a>' ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="items inner clearfix">
        <?php if( !empty( $popular_groups ) ):
            foreach( $popular_groups as $k => $p ):
             $this->partial('partial/item_group', ['k' => $k, 'i' => $p, 'limit' => 5]);
            endforeach;
        endif; ?>
    </div>
</div>

<?php

if( !empty( $news ) )
{
    $data_news =
        '<div class="news_wrapper">'.
            '<div class="inner clearfix">';

    foreach( $news as $k => $n )
    {
        $data_news .=
            '<div class="one_news float'.( ($k+1)%2==0 ? ' last' : '' ).'">'.
                '<div class="one_news_img float">'.
                    ( !empty( $n['cover'] )
                    ?
                        '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'">'.
                            '<img src="'.$n['image'].'" alt="" width="180" height="120" />'.
                        '</a>'
                    :
                        '').
                '</div>'.
                '<div class="one_news_content float'.( empty( $n['cover'] ) ? ' full_width' : '').'">'.
                    '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'">'.
                        '<h2>'.$n['title'].'</h2>'.
                    '</a>'.
                    '<p>'.$this->common->shortenString( $n['abstract_info'], 230 ).'</p>'.
                    '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'" class="news_more">Докладніше</a>'.
                '</div>'.
            '</div>';
    }

    $data_news .= '</div></div>';

    echo( $data_news );
}

?>

<!--<div class="content_accost">
            <div class="shadow_to_down"></div>
            <div class="inner">
                <div class="content_accost_title"></div>
                <div class="content_accost_content">
                    <p>
                        Інтернет - магазин ТМ "Професійне насіння"
                    </p>
                </div>
            </div>
        </div> content_accost -->
    <div class="content_accost">
        <div class="shadow_to_down"></div>
        <div class="inner">
            <div class="content_accost_title"></div>
            <div class="content_accost_content">
                <p>
                    <?= isset( $seo['seo_text'] ) && !empty( $seo['seo_text'] ) ?  $seo['seo_text'] : ''?>
                </p>
            </div>
        </div>
    </div>
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
</div>
<script>

    <?php

        $customer_id    = $this->session->get('id');


    ?>
    $( document ).ready(function() {
        $('body').on('click','.one_item_buttons a', function(){

            <?php if( !empty( $customer_id ) ) : ?>
            <?php $customer  = $this->models->getCustomers()->getCustomer( $customer_id );
            ?>
            eventMailer.email      =  '<?= $customer[0]['email'] ?>' ;
            <?php endif; ?>

            eventMailer.event_type = 'spy_event';
            eventMailer.action     = 'order_add';

            eventMailer.item_url   = '<?= 'semena.in.ua'.$item['full_alias'] ?>';

            <?php if(!empty($item['images'][0])): ?>
            eventMailer.item_image = '<?= $this->storage->getPhotoUrl( $item['images'][0], 'group', '400x400' ) ?>';
            <?php endif; ?>

            var price = + $('.one_item_price span').html();
            var count = + $('.count_items').val();
            eventMailer.price      = price *  count;

            eventMailer.item_name  = '<?= $item['title'] ?>';
            eventMailer.item_id    = $('.item_id_for_basket').val();
            eventMailer.quantity   =  count;





//            eventMailer.email_cancel = "http://semena.in.ua/cabinet/email-cancel/<?//=md5( $customer['email'].'just_sum_text' )?>//";
//            eventMailer.email_settings = "http://semena.in.ua/cabinet/email-settings-key/<?//=md5( $customer['email'].'just_sum_text' )?>//";
//            eventMailer.cabinet_key = "http://semena.in.ua/cabinet/key/<?//= md5( $customer['email'].'just_sum_text' )?>//";

            eventMailer.callOtherDomain();

        });


    });


</script>