<h2 class="content-header">
    <?= $catalog['catalog']['sub']['title'].' '.$item['title'] ?>
</h2>
<section style="overflow: visible" class="content">
<div class="item">
<div class="item_wrapper"  itemscope itemtype="http://schema.org/Product">
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
                            '<img itemprop="image" titile="'.$item['title'].'" src="'.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'" alt="Купити '.$item['title'].' в Києві та Львові" class="image_128">'.
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
            <div style="float:left">
                <div class="clearfix">
                    <div class="float properties">Код:</div>
                    <div class="float properties properties_article"><?= $item['product_id'] ?></div>
                </div>
                <div class="clearfix">
                    <div class="float properties"><?= $t->_("availability") ?>:</div>
                    <div class="float presence_status">
                        <?=  $item['status'] == 1 ? '<div data-stock="1" id="stock" class="properties properties_presence ">'.$t->_("in_stock").'</div>' : ($item['status'] == 2 ? '<div data-stock="0" id="stock" class="properties properties_absent">'.$t->_("znyt").'</div>' : '<div data-stock="0" id="stock" class="properties properties_absent">'.$t->_("missing").'</div>'); ?>
                    </div>

                </div>

                <div class="clearfix">
                    <div class="float properties"><?= $t->_("number_of") ?>:</div>
                    <div style="padding-top: 5px" class="float count minus">
                    </div>
                    <div class="float count count_input">
                        <input name="count_items" class="count_items" type="text" value="1" />
                    </div>
                    <div class="float count plus">
                    </div>
                </div>
            </div>
            <div style="float:right;">
                <?php if(!empty($item['firm']) && $item['firm']): ?>
                <div id="firm">
                    <img src="/images/minilogo.png">
                    <span><?= $t->_('firm_product') ?></span>
                    <a style="display:inline-block;width: 14px;height: 14px" href="#" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Some content" class="products_more"></a>
                </div>
                <?php endif; ?>
                <div style="position: relative; right: 10px">
                    <img title="<?= $t->_($stock_availability[$item['stock_availability']]) ?>" id="stock_availability" style="padding-top: 10px" src="/images/dost<?= !empty($item['stock_availability']) ? $item['stock_availability'] : '0'; ?>.png">
                    <span style="text-transform: lowercase;position: relative;bottom: 10px"><?= $t->_('stock_availability') ?></span>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="clearfix packing">
                <div class="float properties"><?= $t->_("packing") ?>:</div>
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
                                '<a href="'.$this->seoUrl->setUrl($s['link']).'" class="group_sizes'.($s['size'] == $item['size'] ? ' active' : '').'" style="padding-top:'.($k*3).'px; width:'.(31+($k*3)).'px" data-item_id="'.$s['id'].'" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                                '<span class="group_sizes_header"></span>'.
                                '<span class="group_sizes_content">'.$s['size'].'</span>'.
                                '</a>';
                        }
                    }

                    echo( $data_sizes );

                    ?>
                </div>
            </div>
            <?php if(!empty($item['prices'][0]) && ($special_user['status'] != 1)): ?>
            <div class="recommended_prices">
                <div style="display: inline-block;vertical-align: top"><?= $t->_('recommended_prices') ?>:</div>
                <div class="recommended_prices_block">
                    <?php for($i = 0; $i < $special_user['status'] - 1; $i++): ?>
                    <div style="display: inline-block; margin-left: 10px">
                        <div class="dealer_price"><span><?= $item['prices'][$i] ?></span> грн.</div>
                        <div class="dealer_name"><?= $special_users[$i]['title'] ?></div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
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
                    <div class="one_item_price float" itemscope itemtype="http://schema.org/Offer" ><?= $t->_("price")?>
                        <span itemprop="price"><?= number_format($item['prices'][$special_user['status'] - 1],2,'.',' ') ?></span> грн<span style="display:none;" itemprop="priceCurrency">UAH</span>
                    </div>
                    <div class="one_item_buttons float">
                        <?php if($item['status'] != 2){?>
                            <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'item', 'type' => $type_alias, 'subtype' => $subtype_alias, 'group_alias' => $group_alias, 'item_id' => $item_id ])); ?>" title="Додати <?= $item['title'] ?> у корзину" class="btn green buy"><?= $t->_("buy")?></a>
                        <?php }?>
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
                            <li class="float last_tab not_active" data-change_item_description="tabs_comments"><a href="#" title=""><?= $t->_("reviews")?> (<span href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" class="hcount"></span>)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="item_menu_content">
                    <div class="tabs_description item_menu_content_wrapper"><?= $item['content_description'] ?></div>
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
                        <div id="hypercomments_widget"></div>
                        <script type="text/javascript">
                            _hcwp = window._hcwp || [];
                            _hcwp.push({widget:"Stream", widget_id:19420});
                            _hcwp.push({widget:"Bloggerstream", widget_id:19420, selector:".hcount", label:"{%COUNT%}"});
                            (function() {
                                if("HC_LOAD_INIT" in window)return;
                                HC_LOAD_INIT = true;
                                var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
                                var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
                                hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/19420/"+lang+"/widget.js";
                                var s = document.getElementsByTagName("script")[0];
                                s.parentNode.insertBefore(hcc, s.nextSibling);
                            })();
                        </script>
                        <a href="http://hypercomments.com" class="hc-link" title="comments widget">comments powered by HyperComments</a>
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
                        <li class="float active_tab first_tab">
                            <?= '<a href="#" title="'.$t->_("recommended_items").'" data-change_similar_items="popular" data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("recommended_items").'</a>' ?>
                        </li>
                        <li class="float not_active">
                            <?= '<a href="#" title="'.$t->_("similar_items").'" data-change_similar_items="same"        data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("similar_items").'</a>' ?>
                        </li>
                        <li class="float not_active">
                            <?= '<a href="#" title="'.$t->_("related_items").'" data-change_similar_items="buy_with"  data-catalog_id="'.$catalog_id.'" data-group_id="'.$item['group_id'].'">'.$t->_("related_items").'</a>' ?>
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
</div>
</section>