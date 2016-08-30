<?php //p($items,1) ?>
<div id="content" class="clearfix">

<div style="width: 100%; min-width: 960px; height: 193px; margin: 0px auto;background:url(/images/order_<?php $lang = explode( '/', $this->getDi()->get('request')->get('_url')); echo (array_pop($lang) == 'ru')?'ru':'uk';?>.gif) center no-repeat;margin-bottom:-30px;position:relative;z-index:9; ">
</div>

<div class="order">
<div class="breadcrumbs">
    <div class="inner">
        <div class="order_menu_shadow"></div>
        <ul class="clearfix">
            <li class="float"><a href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><?= $t->_("main_page") ?></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <li class="float"><a href="<?= $this->seoUrl->setUrl('/basket')?>" title="<?= $t->_("cart")?>" class="breadcrumbs_last"><?= $t->_("cart")?></a></li>
        </ul>
    </div>
</div>

<div class="inner">
    <?php

    $message = $this->flash->getMessages();


    if( !empty( $message ) )
    {
        if( isset($message['error']) && !empty($message['error'])  )
        {
            echo('<div class="errorMessage">'.$message['error']['0'].'</div>');
        }
        else
        {
            echo('<div class="successMessage">'.$message['success']['0'].'</div>');
        }
    }

    ?>
</div>



<div class="order_wrapper">
<div class="inner">
<form method="post" action=""  name="order_add" id="order_add_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>" class="clearfix order_add_form">
<div class="order_form">
    <div class="order_title"><h1><?= $t->_("cart") ?></h1></div>
    <ul class="form">
        <li class="clearfix main_li order_form_header">
            <ul>
                <li class="float order_first_column"><?= $t->_("name") ?></li>
                <li class="float order_second_column"><?= $t->_("cost_per_unit") ?></li>
                <li class="float order_third_column"><?= $t->_("number_of") ?></li>
                <li class="float order_fourth_column"><?= $t->_("cost") ?></li>
            </ul>
        </li>

        <?php

        $data_items = '';

        if( !empty( $items ) )
        {
            foreach( $items as $i )
            {
                $data_items .=
                    '<li class="clearfix main_li order_form_content" data-catalog = "'.$i['catalog'].'">'.
                    '<ul>'.
                    '<li class="float order_first_column">'.
                    '<div class="order_img_container">'.
                    '<a href="' . $this->seoUrl->setUrl($i['alias']) . '" target="_blank">'.
                    '<img src="'.$i['cover'].'" alt="'.$i['title'].'" width="61" height="100" class="float order_img">'.
                    '</a>'.
                    '</div>'.
                    '<h2><a href="' . $this->seoUrl->setUrl($i['alias']) . '" target="_blank">' . $i['title'] . '</a></h2>'.
                    '<input type="hidden" name="size['.$i['id'].']" value="'.$i['size'].'" /><p>'.$t->_("packing").' '.$i['size'].'.</p>'.
                    ($i['color'] ? '<input type="hidden" name="color['.$i['id'].']" value="'.$i['color'].'" /><div class="float properties">'.$t->_("color").': </div>'.'<div class="float1 properties" style="color:'.$i['absolute_color'].'">'.$i['color'].'</div>' : '').
                    ($i['status'] == 1 ? '<input type="hidden" name="is['.$i['id'].']" value="'.$t->_("in_stock").'" /><p data-stock="1" id="stock" style="color: green; font-weight: bold;" class="properties properties_presence ">'.$t->_("in_stock").'</p>' : '<input type="hidden" name="is['.$i['id'].']" value="'.$t->_("missing").'" /><p data-stock="0" id="stock"  style="color: red; font-weight: bold;" class="properties properties_absent">'.$t->_("missing").'</p>').

                    '</li>'.
                    '<li class="float order_second_column"><span class="price">'.$i['price2'].'</span><span> грн</span></li>'.
                    '<li class="float order_third_column">'.
                    '<div class="float count minus">'.
                    '</div>'.
                    '<div class="float count count_input">'.
                    '<input name="count_items['.$i['id'].']" data-item_id="'.$i['id'].'" class="count_items" type="text" value="'.$i['count'].'" />'.
                    '</div>'.
                    '<div class="float count plus">'.
                    '</li>'.
                    '<li class="float order_fourth_column">'.
                    '<span class="price">'.$i['total_price'].'</span><span> грн</span>'.
                    '</li>'.
                    '<li class="float order_fifth_column">'.
                    '<a href="'.$this->seoUrl->setUrl('/basket').'" data-item_id="'.$i['id'].'"><img src="/images/basket_del.png" alt="" width="18" height="18" /></a>'.
                    '</li>'.
                    '</ul>'.
                    '</li>';
            }
        }

        echo( $data_items );

        ?>


        <li class="order_last clearfix">
            <span class="min_price_message"><?=$t->_("min_price") ?></span>
            <?= $t->_("total")?>: <span class="price" id="total_price_basket"><?= $total_price ?></span> <span>грн</span>
        </li>
        <li class="clearfix">
            <div class="label float"><label for="promo_code">Промокод</label></div>
            <div class="input float promo_code">
                <input type="text" name="promo_code" id="promo_code" value="<?= !empty($promo_code['code']) ? $promo_code['code'] : '' ?>">
                <input type="button" value="Применить" class="btn green" style="float: none">
                <div style="width: auto;display: none;padding: 5px 4px;" class="alert" role="alert">
                    <strong></strong>
                </div>
            </div>
        </li>
    </ul>
</div>

<div class="contacts_form">
<div class="contacts_form_title"><h1><?= $t->_("ordering") ?></h1></div>
<div class="item_menu_header_menu clearfix">
    <div class="inner">
        <div class="tabs clearfix do_order">
            <ul>
                <?php

                if( !empty( $customer ) )
                {
                    $data_tabs = '<li class="float active_tab first_tab new_customer"><a href="#" title="">'.$t->_("already_registered").'</a></li>';
                }
                else
                {
                    $data_tabs =
                        '<li class="float '.(!empty( $message ) ? 'not_active' : 'active_tab').'  first_tab new_customer"><a href="javascript:void(0)" title="">'.$t->_("new_customer").'</a></li>'.
                        '<li class="float '.(!empty( $message ) ? 'active_tab' : 'not_active').' last_tab registrated_customer"><a href="javascript:void(0)" title="">'.$t->_("already_registered").'</a></li>';
                }

                echo( $data_tabs );

                ?>

            </ul>
        </div>
    </div>
</div>

<div class="new_customer<?= !empty( $message ) ? ' display_none' : '' ?>">

    <ul class="form clearfix">
        <li class="clearfix">
            <div class="label float"><label for="order_name"><?= $t->_("n_s")?><span class="required">&#8727;</span></label></div>
            <div class="input float"><input type="text" name="order_name" id="order_name" class="name" value="<?= isset($customer['name']) && !empty($customer['name']) ? $customer['name'] : '' ?>"></div>
        </li>
        <li class="clearfix">
            <div class="label float"><label for="order_phone"><?= $t->_("m_phone")?><span class="required">&#8727;</span></label></div>
            <div class="input float"><input type="text" name="order_phone" class="order_phone" class="name" value="<?= isset($customer['phone']) && !empty($customer['phone']) ? $customer['phone'] : '' ?>"></div>
        </li>
        <li class="clearfix">
            <div class="label float"><label for="order_email">Ваш email</label></div>
            <div class="input float">
                <input type="text" name="order_email" id="order_email" class="name" value="<?= (isset($customer['email']) && !empty($customer['email'])  && strlen(strpos($customer['email'], 'facebook'))==0 && strlen(strpos($customer['email'], 'vkontakte'))==0 ) ? $customer['email'] : '' ?>">
                <div class="description">
                    <input type="checkbox" id="get_info" name="order_get_info" <?= !empty($customer['subscribed']) && $customer['subscribed'] == 1 ? 'checked' : 'checked' ?> />
                    <label for="get_info"><span></span><?= $t->_("receive")?></label>
                </div>
            </div>
        </li>

        <li class="clearfix with_radio_buttons">
            <div class="label">Доставка</div>
            <div class="label float"><label><?= $t->_("delivery") ?><span class="required">&#8727;</span></label></div>
            <div class="input float">
                <div class="input_radio"><label for="r1"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/1' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/111' ) ?></div>

                </div>

                <div class="child" style="padding-left:20px;padding-top:10px;">
                    
					<input type="radio" name="order_delivery" class="order_delivery funbind" value="10001" id="r10001" <?= !empty($customer['delivery']) && $customer['delivery'] == '10001' ? 'checked' : 'checked' ?> /><label for="r10001"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/10001' ) ?></label>
                    <br /><br />
					
                    <input type="radio" name="order_delivery" class="order_delivery funbind" value="10003" id="r10003" <?= !empty($customer['delivery']) && $customer['delivery'] == '10003' ? 'checked' : '' ?> /><label for="r10003"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/10003' ) ?></label>
                    <br /><br />
                    <input type="radio" name="order_delivery" class="order_delivery funbind" value="10004" id="r10004" <?= !empty($customer['delivery']) && $customer['delivery'] == '10004' ? 'checked' : '' ?> /><label for="r10004"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/10004' ) ?></label>
                <!--    
					<br /><br />
                    <input type="radio" name="order_delivery" class="order_delivery funbind" value="10005" id="r10005" <?= !empty($customer['delivery']) && $customer['delivery'] == '10005' ? 'checked' : '' ?> /><label for="r10005"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/10005' ) ?></label>
				-->
				</div>
                <br>


                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="7" id="r71" <?= !empty($customer['delivery']) && $customer['delivery'] == 7 ? 'checked' : '' ?> /><label for="r71"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/7' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/77' ) ?></div>
                </div><br>


            </div>
            <div class="label float no_marge"><label for="order_delivery"><?= $t->_("delivery_in_ukraine")?><span class="required"></span></label></div>
            <div class="input float no_marge">
                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery bind" value="3" id="r3" <?= !empty($customer['delivery']) && $customer['delivery'] ==8 ? 'checked' : '' ?> /><label for="r3"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/3' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/33' ) ?></div>
                </div><br>
                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="9" id="r4" <?= !empty($customer['delivery']) && $customer['delivery'] == 9 ? 'checked' : '' ?> /><label for="r4"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/9' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/99' ) ?></div>
                </div><br>
                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="10" id="r5" <?= !empty($customer['delivery']) && $customer['delivery'] == 10 ? 'checked' : '' ?> /><label for="r5"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/10' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/1010' ) ?></div>
                </div><br>
                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="11" id="r6" <?= !empty($customer['delivery']) && $customer['delivery'] == 11 ? 'checked' : '' ?> /><label for="r6"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/11' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/1111' ) ?></div>
                </div><br>
                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="12" id="r7" <?= !empty($customer['delivery']) && $customer['delivery'] == 12 ? 'checked' : '' ?> /><label for="r7"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/12' ) ?></label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#delivery/'.$lang_id.'/1212' ) ?></div>
                </div><br>

                <!--
                <div class="description">
                    Доставимо Ваше замовлення на цю адресу! <br />
                    Вартість доставки 30 або 50 грн залежно від габаритів замовлення
                </div>
                -->
            </div>
        </li>
        <li class="clearfix owner_city display_none">
            <div class="label float"><label for="order_city"><?= $t->_("city")?><span class="required">&#8727;</span></label></div>
            <div class="input float ui-widget">
                <input type="text" name="order_city" class="form-text" id="order_city" value="<?= isset($customer['city']) && !empty($customer['city']) ? $customer['city'] : '' ?>">
            </div>
            <div class="display_none" id="loading_city"></div>
        </li>

        <li class="clearfix order_city_novaposhta display_none">
            <div class="label float"><label for="order_city_novaposhta"><?= $t->_("city")?><span class="required">&#8727;</span></label></div>
            <div class="input float ui-widget">
                <input type="text" name="order_city_novaposhta" class="form-text" id="order_city_novaposhta" value="">
                <input type="hidden" name="order_city_ref" class="form-text" id="order_city_ref" value="">
                <div class="ajax_cities"></div>
                <div class="description display_none">
                    <?= $t->_("no_city")?>
                </div>
            </div>
            <div class="display_none" id="loading_city"></div>
        </li>
        <li class="clearfix owner_address display_none">
            <div class="label float"><label for="order_address" id="label_order_address"><?= $t->_("your_address") ?><span class="required">&#8727;</span></label></div>
            <div class="input float">
                <input type="text" name="order_address" id="order_address" class="name" value="<?= isset($customer['address']) && !empty($customer['address']) ? $customer['address'] : '' ?>">
                <div class="description address_mark display_none1">
                    <?= $t->_("address_mark")?>
                </div>	
			</div>	
        </li>

        <li class="clearfix owner_address_s display_none">
            <div class="label float"><label for="order_address_s" id="label_order_address_s"><?= $t->_("warehouse_address") ?><span class="required">&#8727;</span></label></div>
            <div class="input float">
                <input type="text" name="store_address" id="order_address_s" style="float:left;margin-right:20px;" class="name" value="<?= isset($customer['address']) && !empty($customer['address']) ? $customer['address'] : '' ?>"> <a href="http://www.autolux.ua/representatives/" target="_blank">Оберіть склад</a>
            </div>
        </li>

        <li class="clearfix store_address display_none">
            <div class="label float"><label for="store_address" ><?= $t->_("warehouse_address") ?><span class="required">&#8727;</span></label></div>
            <div class="input float">
                <select name="store_address" id="store_address">
                    <option value="0"></option>
                </select>
                <input type="hidden" name="order_store_address_ref" class="form-text" id="order_store_address_ref" value="">
            </div>
            <div class="display_none" id="loading_office"></div>
        </li>

        <li class="clearfix  with_radio_buttons">
            <div class="label float"><label for="order_pay"><?= $t->_("methods_of_payments")?><span class="required">&#8727;</span></label></div>
            <div class="input float">
                <div class="input_radio">
                    <input type="radio" name="order_pay" value="1" id="r16" <?= !empty($customer['pay']) && $customer['pay'] == 1 ? 'checked' : 'checked' ?> />
                    <label for="r16">
                        <span></span><?= \config::get( 'global#pay/'.$lang_id.'/1' ) ?>
                    </label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#pay/'.$lang_id.'/11' ) ?></div>
                </div><br>
                <div class="input_radio">
                    <input type="radio" name="order_pay" value="2" id="r17" <?= !empty($customer['pay']) && $customer['pay'] == 2 ? 'checked' : '' ?> />
                    <label for="r17">
                        <span></span><?= \config::get( 'global#pay/'.$lang_id.'/2' ) ?>
                    </label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#pay/'.$lang_id.'/22' ) ?></div>
                </div><br>
                <div class="input_radio">
                    <input type="radio" name="order_pay" value="3" id="r18" <?= !empty($customer['pay']) && $customer['pay'] == 3 ? 'checked' : '' ?> />
                    <label for="r18">
                        <span></span><?= \config::get( 'global#pay/'.$lang_id.'/3' ) ?>
                    </label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#pay/'.$lang_id.'/33' ) ?></div>
                </div><br>
                <div class="input_radio">
                    <input type="radio" name="order_pay" value="4" id="r19" <?= !empty($customer['pay']) && $customer['pay'] == 4 ? 'checked' : '' ?> />
                    <label for="r19">
                        <span></span><?= \config::get( 'global#pay/'.$lang_id.'/4' ) ?>
                    </label>
                    <div class="question_mark"></div>
                    <div class="additional_info"><?= \config::get( 'global#pay/'.$lang_id.'/44' ) ?></div>
                </div><br>
            </div>
        </li>
        <li class="clearfix with_textarea">
            <div class="label float"><label for="order_name"><?= $t->_("comment_text") ?></label></div>
            <div class="input float">
                <textarea name="order_comments"><?= isset($customer['comments']) && !empty($customer['comments']) ? $customer['comments'] : '' ?></textarea>
                <div class="description">
                    <?= $t->_("additional_information")?>
                </div>
            </div>
        </li>
    </ul>
    <div class="submit">
        <input style="padding:10px;margin-bottom:70px;" id="send_order" type="submit" value="<?= $t->_("checkout")?>" class="btn green">
    </div>
</div>

</div>
</form>



<div class="registrated_customer clearfix<?= empty( $message ) ? ' display_none' : '' ?>">
    <div class="clearfix">
        <div class="float login_with login_with_email">
            <form id="customer_login_from_order_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>" method="post">
                <ul class="form clearfix">
                    <li class="clearfix">
                        <div class="label float"><label for="login_email">Email<span class="required">&#8727;</span></label></div>
                        <div class="input float"><input type="text" name="login_email" id="login_email" class="name" value="<?= isset($customer_email) && !empty($customer_email) ? $customer_email : '' ?>"></div>
                    </li>
                    <li class="clearfix">
                        <div class="label float"><label for="login_passwd">Пароль<span class="required">&#8727;</span></label></div>
                        <div class="input float"><input type="password" name="login_passwd" id="login_passwd" class="name" value=""></div>
                    </li>
                </ul>
                <div class="submit clearfix">
                    <input type="submit" value="<?= $t->_("sign_in")?>" class="btn green float float_right">
                    <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'restore_passwd' ])) ?>" class="float float_right"><?= $t->_("forgot_your_password") ?></a>
                </div>
                <div class="submit clearfix">
                    <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'registration' ])) ?>" class="float float_right do_registration"><?= $t->_("create_an_account") ?></a>
                </div>
            </form>
        </div>

        <div class="float login_with login_with_social last">
            <div class="clearfix">
                <p class="login_with_social_title"><?= $t->_("login_via_social_network")?></p>
                <div class="login_with_social_wrapper">
                    <a href="<?= $this->social->createUrl('vkontakte') ?>" class="float"><img src="/images/vk_32x32.png"></a>
                    <a href="<?= $this->social->createUrl('facebook') ?>" class="float"><img src="/images/f_32x32.png"></a>
                    <a href="<?= $this->social->createUrl('google') ?>" class="float last"><img src="/images/g_32x32.png"></a>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
</div>



<?= $this->partial('partial/share'); ?>

</div>
</div>
<script>
    <?php $customer = $this->models->getCustomers()->getCustomer( $this->session->get('id') );?>
    $( document ).ready(function() {
//        $('body').on('click','.order_fifth_column', function(){
//            eventMailer.email      =  '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();
//            eventMailer.event_type = 'spy_event';
//            eventMailer.action     = 'order_delete';
//            eventMailer.item_url   = 'semena.in.ua'+$(this).closest('ul').find('h2 a').attr('href');
//            eventMailer.item_image = $(this).closest('ul').find('img').attr('src');
//            eventMailer.item_name  = $(this).closest('ul').find('h2 a').html();
//            eventMailer.price      = $(this).closest('ul').find('.order_fourth_column .price').html();
//            eventMailer.item_id    = $(this).closest('ul').find('.order_fifth_column a').data('item_id');
//            eventMailer.quantity   =  $(this).closest('ul').find('.count_items').val();
//            eventMailer.deleteCookie("userEmail");
//            eventMailer.deleteOneItem();
//        });
//        $('body').on('click','.minus', function(){
//            eventMailer.email      =  '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();
//            eventMailer.event_type = 'spy_event';
//            eventMailer.action     = 'order_add';
//            eventMailer.item_url   = 'semena.in.ua'+$(this).closest('ul').find('h2 a').attr('href');
//            eventMailer.item_image = $(this).closest('ul').find('img').attr('src');
//            eventMailer.item_name  = $(this).closest('ul').find('h2 a').html();
//            eventMailer.price      = $(this).closest('ul').find('.order_fourth_column .price').html();
//            eventMailer.item_id    = $(this).closest('ul').find('.order_fifth_column a').data('item_id');
//            eventMailer.quantity   = $(this).closest('ul').find('.count_items').val();
//            eventMailer.deleteCookie("userEmail");
//            eventMailer.sendWithTimeOut();
//        });
//        $('body').on('click','.plus', function(){
//            eventMailer.email      =  '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();
//            eventMailer.event_type = 'spy_event';
//            eventMailer.action     = 'order_add';
//            eventMailer.item_url   = 'semena.in.ua'+$(this).closest('ul').find('h2 a').attr('href');
//            eventMailer.item_image = $(this).closest('ul').find('img').attr('src');
//            eventMailer.item_name  = $(this).closest('ul').find('h2 a').html();
//            eventMailer.price      = $(this).closest('ul').find('.order_fourth_column .price').html();
//            eventMailer.item_id    = $(this).closest('ul').find('.order_fifth_column a').data('item_id');
//            eventMailer.quantity   = $(this).closest('ul').find('.count_items').val();
//            eventMailer.deleteCookie("userEmail");
//            eventMailer.sendWithTimeOut();
//        });
//        $('body').on('mouseover','.count_items', function(){
//
//            eventMailer.email      =  '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();
//            eventMailer.event_type = 'spy_event';
//            eventMailer.action     = 'order_change';
//            eventMailer.item_url   = 'semena.in.ua'+$(this).closest('ul').find('h2 a').attr('href');
//            eventMailer.item_image = $(this).closest('ul').find('img').attr('src');
//            eventMailer.item_name  = $(this).closest('ul').find('h2 a').html();
//            eventMailer.price      = $(this).closest('ul').find('.order_fourth_column .price').html();
//            eventMailer.item_id    = $(this).closest('ul').find('.order_fifth_column a').data('item_id');
//            eventMailer.quantity   = $(this).closest('ul').find('.count_items').val();
//            eventMailer.deleteCookie("userEmail");
//            eventMailer.startChanging();
//        });
//        $('body').on('keyup','.count_items', function(){
//            eventMailer.email      = '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();
//            eventMailer.event_type = 'spy_event';
//            eventMailer.action     = 'order_change';
//            eventMailer.item_url   = 'semena.in.ua'+$(this).closest('ul').find('h2 a').attr('href');
//            eventMailer.item_image = $(this).closest('ul').find('img').attr('src');
//            eventMailer.item_name  = $(this).closest('ul').find('h2 a').html();
//            eventMailer.price      = $(this).closest('ul').find('.order_fourth_column .price').html();
//            eventMailer.item_id    = $(this).closest('ul').find('.order_fifth_column a').data('item_id');
//            eventMailer.quantity   = $(this).closest('ul').find('.count_items').val();
//            eventMailer.deleteCookie("userEmail");
//            eventMailer.sendWithTimeOut();
//        });



//        $('body').on('submit','.order_add_form', function(e){
//
//         // e.preventDefault();
//            var val = $('span[id=total_price_basket]').html();
//
//            if(val > 100) {
//                var items = [];
//
//
//
//                $('body').find('.order_form_content').each(function () {
//                    var item = {
//                        item_url: 'semena.in.ua'+$(this).find('h2 a').attr('href'),
//                        item_image: $(this).find('img').attr('src'),
//                        item_name: $(this).find('h2 a').html(),
//                        price: $(this).find('.order_fourth_column .price').html(),
//                        item_id:  $(this).find('.order_fifth_column a').data('item_id'),
//                        quantity:  $(this).find('.count_items').val(),
//                        catalog:  $(this).data('catalog')
//                    };
//
//
//                    items.push(item)
//                });
//
//
//                eventMailer.email      = '<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' ?'<?//= isset( $customer[0]['email'] )?$customer[0]['email'] : ''?>//' : $('#login_email').val();;
//                eventMailer.event_type = 'spy_event';
//                eventMailer.event      = 'order_finish';
//                eventMailer.action     = 'order_finish';
//                eventMailer.name       =  '<?//= isset( $customer[0]['name'] )?$customer[0]['name'] : ''?>//';
//                eventMailer.order_num  =  '<?//= isset( $data['oid'] )?$data['oid'] : ''?>//';
//                eventMailer.sum        =  val;
//                eventMailer.phone      =  '<?//= isset( $customer[0]['phone'] )?$customer[0]['phone'] : 'Не указан'?>//';
//                eventMailer.address    =  '';
//                eventMailer.delivery   = 'Не указан';
//                eventMailer.pay        = 'Не указан';
//                eventMailer.items = JSON.stringify(items);
//
//
//
//
//
//                for (var i = 0; i < items.length; i++) {
//                    if (items[i].catalog == 334) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 'with_cucumbers';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//                    if (items[i].catalog == 471) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 's_lukovichnіe';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//                    if (items[i].catalog == 471) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 's_lukovichnіe';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//                    var spec_items = [305,336,326,306,333,308,504,502,332];
//                    if (eventMailer.find(spec_items, items[i].catalog)) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 'borsch';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//
//
//                    var city_1 = $('#order_address').val();
//                    var city_2 = $('#order_city_novaposhta').val();
//                    var city_3 = $('#order_city').val();
//
//
//                    if (city_1.indexOf('Киев') || city_2.indexOf('Киев') || city_3.indexOf('Киев') ) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 'kiev_mail';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//                    if (city_1.indexOf('Київ') || city_2.indexOf('Київ') || city_3.indexOf('Київ') ) {
//                        eventMailer.event_type = 'event_offline';
//                        eventMailer.event = 'kiev_mail';
//                        eventMailer.callOtherDomain();
//                        eventMailer.deleteCookie("userEmail");
//
//                    }
//
//                }
//
//
//                eventMailer.callOtherDomain();
//                eventMailer.deleteCookie("userEmail");
//
//                if ( eventMailer.sum >= 250 && eventMailer.sum < 499 ){
//                    eventMailer.event = 'free_delivery_500';
//                    eventMailer.callOtherDomain();
//                    eventMailer.deleteCookie("userEmail");
//                }
//
//            }
//
//        });


        $('.promo_code input[type=button]').click(applyPromoCode);

        function applyPromoCode() {
            const successMessage = '<?= $t->_('success_promo_code') ?>';
            const errorMessage = '<?= $t->_('error_promo_code') ?>';
            const $alert = $('.alert');
            $alert.css('display', 'inline-block');
            $.ajax({
                url: '/ajax/apply_promo_code',
                method: 'POST',
                dataType: 'json',
                data: {
                    promo_code: $('#promo_code').val()
                },
                success: function (cart) {
                    renderCart(cart);
                    $('#total_price_basket').text(cart['total_sum']);
                    $alert.addClass('alert-success').removeClass('alert-danger');
                    $alert.find('strong').text(successMessage);
                },
                error: function (error) {
                    $alert.addClass('alert-danger').removeClass('alert-success');
                    $alert.find('strong').text(errorMessage);
                }
            });
        }
        
        function renderCart(cart) {
            var html = '';
            var items = cart.items;
            for(var i = 0; i < items.length; i++) {
                html += '<li class="clearfix main_li order_form_content">' +
                '<ul>' +
                '<li class="float order_first_column">' +
                '<div class="order_img_container">'+
                '<a href="' + items[i]['alias'] + '" target="_blank">'+
                '<img src="'+ items[i]['cover'] + '" alt="' + items[i]['title'] + '" width="61" height="100" class="float order_img">' +
                '</a>'+
                '</div>'+
                '<h2><a href="' + items[i]['alias'] + '" target="_blank">' + items[i]['title'] + '</a></h2>' +
                '<input type="hidden" name="size[' + items[i]['id'] + ']" value="' + items[i]['size'] + '" /><p><?= $t->_("packing") ?> ' + items[i]['size'] + '</p>' +
                    (items[i]['color'] ? '<input type="hidden" name="color['+items[i]['id'] + ']" value="' + items[i]['color'] + '" /><div class="float properties"><?= $t->_("color") ?> : </div>'+'<div class="float1 properties" style="color:'+items[i]['absolute_color']+'">'+items[i]['color']+'</div>' : '')+
                (items[i]['status'] == 1 ? '<input type="hidden" name="is['+items[i]['id']+ ']" value="<?= $t->_("in_stock") ?>" /><p data-stock="1" id="stock" style="color: green; font-weight: bold;" class="properties properties_presence "><?= $t->_("in_stock") ?></p>' : '<input type="hidden" name="is['+items[i]['id']+']" value="<?= $t->_("missing") ?>" /><p data-stock="0" id="stock"  style="color: red; font-weight: bold;" class="properties properties_absent"><?= $t->_("missing") ?></p>')+

                '</li>' +
                '<li class="float order_second_column"><span class="price">' + items[i]['price2'] + '</span><span> грн</span></li>' +
                '<li class="float order_third_column">' +
                '<div class="float count minus">' +
                '</div>' +
                '<div class="float count count_input">' +
                '<input name="count_items[' + items[i]['id'] + ']" data-item_id="' + items[i]['id'] + '" class="count_items" type="text" value="' + items[i]['count'] + '" />' +
                '</div>' +
                '<div class="float count plus">'+
                '</li>' +
                '<li class="float order_fourth_column">'+
                '<span class="price">' + items[i]['total_price']+'</span><span> грн</span>' +
                '</li>'+
                '<li class="float order_fifth_column">' +
                '<a href="/basket" data-item_id="'+items[i]['id']+'"><img src="/images/basket_del.png" alt="" width="18" height="18" /></a>' +
                '</li>' +
                '</ul>';
            }
            $('.order_form_content').remove();
            $(html).insertAfter('.order_form_header');
        }

    });




</script>