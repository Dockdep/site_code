<div id="content" class="clearfix">
    <div class="compare_items">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="float"><a  itemprop="url" href="<?= $this->seoUrl->setUrl('/') ?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="float"><a  itemprop="url" href="#" title="<?= $t->_("compare_items") ?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("compare_items") ?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner clearfix">
            <h2><?= $t->_("compare_items") ?></h2>

            <div class="compare_items_table">
                <table class="" cellpadding="0" cellspacing="0">
                    <tr>
                        <th></th>

                        <?php

                        if( !empty( $items ) )
                        {
                            $data_items = '';




                            foreach( $items as $i )
                            {


                                $data_items .=
                                    '<th valign="top">'.
                                        '<div class="compare_one_item">'.
                                            '<div class="compare_item_delete"><a href="'.$this->seoUrl->setUrl(substr($i['alias_del'],1)).'" title="'.$i['title'].'" data-item_id="'.$i['type'].'-'.$i['subtype'].'-'.$i['id'].'"></a></div>'.
                                            '<div class="compare_item_image"><a href="'.$this->seoUrl->setUrl($i['alias']).'" title="'.$i['title'].'"><img src="'.$i['cover'].'" alt="'.$i['title'].'" height="100" /></a></div>'.
                                            '<div class="compare_item_title"><a href="'.$this->seoUrl->setUrl($i['alias']).'" title="'.$i['title'].'">'.$i['title'].'</a></div>'.
                                            '<div class="align_bottom">'.
                                                '<div class="compare_item_price">'.$t->_("price_from").' <span>'.$i['price2'].'</span> грн</div>'.
                                                '<div class="one_item_buttons">
                                                <a href="'.$this->seoUrl->setUrl($i['alias']) .'" title="" class="btn grey">'.$t->_("details").'</a>
                                                <a data-group_id="'.$i['group_id'].'" href="#" title="" class="btn green buy">'.$t->_("buy").'</a>
                                                </div>'.
                                            '</div>'.
                                        '</div>'.
                                    '</th>';

                            }

                            echo($data_items);
                        }

                        ?>
                    </tr>
                    <?php

                    if( !empty( $properties_for_items ) )
                    {
                        $data   = '';
                        $j      = 0;
                        $i      = 0;

                        foreach( $properties_for_items as $key => $val )
                        {
                            $j++;
                            $data .= '<tr class="'.( ($j%2==0) ? 'odd' : 'even' ).'" >';
                            $data .= '<td class="compare_item_property_name">'.$key.'</td>';

                            for($i = 0; $i < $count; $i++)
                            {
                                $data .= '<td>'.(!empty($val[$i]) ? $val[$i] : '-').'</td>';
                            }

                            $data .= '</tr>';
                        }

                        echo '<tr class="odd">'.
                        '<td class="compare_item_property_name">'.$t->_("producer").'</td>'.
                         $prod_text.
                        '</tr>';

                        echo($data);
                    }

                    ?>



                </table>
            </div>
        </div>
        <br/>
        <br/>
        <br/>

    </div>
</div>