<section style="overflow: visible" class="content">
<div class="main_block">
    <div class="cat_left">
        <p class="title"><?= $t->_("products_found_for_the_filter")?> <?= $total ?></p>
        <?php

        if( !empty( $filters ) )
        {
        $data_filters = '<ul id="subcategory_menu">';

            foreach( $filters as $key => $val )
            {
            $data_filters .=
            '<li style="background: #ffffff">'.
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
                <div style="background: #ffffff" class="price_slider_container">
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
    </div>
    <div class="cat_center">
        <?php
        $sortName[3] = $t->_("from_cheap_to_expensive");
        $sortName[4] = $t->_("from_expensive_to_cheap");
        $sortName[5] = $t->_("sort_alphabetically");
        ?>

        <?php if(isset($catalog['sub']['title'])) : ?>
        <h2 style="display: inline-block" class="catalog_header"><?= $catalog['sub']['title'] ?></h2>
        <?php endif; ?>

        <div class="block_content" style="width:100%;">
            <div class="catalog_captions">
                <div class="cat_caption left"><?= $t->_('name') ?></div>
                <div class="cat_caption b100"><?= $t->_('stock_availability') ?></div>
                <div class="cat_caption b140"></div>
                <div class="cat_caption b100"><?= $t->_('packing') ?></div>
                <div class="cat_caption b100"><?= $t->_('number_of') ?></div>
            </div>
            <div class="catalog_products">
                <?= $this->partial('partial/products', ['groups' => $groups]); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <?php

    if( $total > \config::get( 'limits/dealer_catalog') )
    {
        echo('<div class="inner"><div class="paginate">');
        echo $paginate;
        echo('</div></div>');
    }

    ?>
</div>
</section>
<script>
    $(function() {
        $('.group_sizes').on('click', function (e) {
            e.preventDefault();
            var size = $(this).find('.group_sizes_content').html();
            var $currentSize = $(this).parents('.table_cell4').find('.active');

            $currentSize.find('.group_sizes_content').html(size);
            var $product = $(this).parents('.product');
            var item_id = $(this).data('item_id');
            var catalog_id = $(this).data('catalog_id');
            var group_alias = $(this).data('group_alias');

            $currentSize.data('item_id', item_id);
            $currentSize.data('catalog_id', catalog_id);
            $currentSize.data('group_alias', group_alias);

            $.ajax({
                url: '/change_with_size',
                data        :
                {
                    'item_id'       : item_id,
                    'catalog_id'    : catalog_id,
                    'group_alias'   : group_alias
                },
                type : "POST",
                dataType: 'json',
                success: function(data) {
                    var $rec_prices = $product.find('.rec_prices');
                    var $stock_image = $product.find('#stock_availability');
                    var $firm_product = $product.find('.firm_product');
                    var $price = $product.find('.price span');

                    $price.text(data['price']);
                    $stock_image.attr('src', '/images/dost0.png');

                    if($rec_prices.children().size() > 2) {
                        console.log($rec_prices.children().size());
                        $rec_prices.children().slice(0, 2).remove();
                    }
                    $firm_product.empty();

                    if(data['recommended_prices']) {
                        var recommended_prices = '<div class="rec_prices_block left first">' + data['recommended_prices']['name'] + '</div>'
                            + '<div style="display: inline-block; width: 276px">';
                        data['recommended_prices']['dealer'].forEach(function(element) {
                            recommended_prices += '<div class="rec_prices_block lr_padding">'
                            + '<div class="small_price"><span>'+ element.dealer_price +'</span> грн.</div>'
                            + '<p class="subtitle">' + element.dealer_name + '</p></div>';
                        });
                        recommended_prices += '</div>';

                        $rec_prices.prepend(recommended_prices);

                        if(data['recommended_prices']['firm']) {
                            var firm = '<div class="table_cell4 w35">'
                            + '<a href="#"><img src="/images/minilogo.png"></a>'
                            + '</div>'
                            + '<div class="table_cell4 font13 left">'
                            + data['recommended_prices']['firm_product']
                            + '</div>';
                            $firm_product.html(firm);
                        }

                        if(data['recommended_prices']['stock_availability']) {
                            $stock_image.attr('src', '/images/dost' + data['recommended_prices']['stock_availability'] + '.png');
                        }
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });
        });


/*
        $('#dealer_search_item').on('input', function (e) {
            e.preventDefault();
            var href = location.href.split('/');
            var subtype = href[6];
            var type = href[5];
            var search = $(this).val();
            if(search.length > 3) {
                $.ajax({
                    url : '/dealer/search',
                    data :
                    {
                        'search'   : search ,
                        'subtype'  : subtype,
                        'type'     : type
                    },
                    type : "GET",
                    dataType : 'html',
                    success : function(data) {
                        $('.catalog_products').html(data);
                    }
                });
            }
        });
*/
    });
</script>
