
<div id="content" class="clearfix">
<div class="order">
<div class="breadcrumbs">
    <div class="inner">
        <div class="order_menu_shadow"></div>
        <ul class="clearfix">
            <li class="float"><a href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><?= $t->_("main_page") ?></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <li class="float"><a href="<?= $this->seoUrl->setUrl('/basket')?>;" title="<?= $t->_("cart")?>" class="breadcrumbs_last"><?= $t->_("cart")?></a></li>
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
    }?>

</div>



<div class="order_wrapper">
    <div class="inner">
        <form method="post" action="" name="order_add" id="order_add_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>" class="clearfix">
            <div class="order_form">
                <div class="order_title"><h1><?= $t->_("cart")?></h1></div>
                <ul>
                    <li class="clearfix main_li order_form_header">
                        <ul>
                            <li class="float order_first_column"><?= $t->_("name")?></li>
                            <li class="float order_second_column"><?= $t->_("cost_per_unit")?></li>
                            <li class="float order_third_column"><?=$t->_("number_of")?></li>
                            <li class="float order_fourth_column"><?= $t->_("cost")?></li>
                        </ul>
                    </li>

                    <?php

                    $data_items = '';

                    if( !empty( $items ) )
                    {
                        foreach( $items as $i )
                        {
                            $data_items .=
                                '<li class="clearfix main_li order_form_content">'.
                                    '<ul>'.
                                        '<li class="float order_first_column">'.
                                            '<div class="order_img_container">'.
												'<a href="' . $this->seoUrl->setUrl($i['alias']) . '" target="_blank">'.
													'<img src="'.$i['cover'].'" alt="'.$i['title'].'" width="61" height="100" class="float order_img">'.
												'</a>'.
											'</div>'.
                                            '<h2><a href="' . $this->seoUrl->setUrl($i['alias']) . '" target="_blank">' . $i['title'] . '</a></h2>'.
                                            '<p>'.$t->_("packing").' '.$i['size'].'.</p>'.
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
                        <?= $t->_("total")?>: <span class="price"><?= $total_price ?></span> <span>грн</span>
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
                            <div class="label float"><label for="order_delivery">Варіант доставки<span class="required">&#8727;</span></label></div>
                            <div class="input float">
                                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="1" id="r1" <?= !empty($customer['delivery']) && $customer['delivery'] == 1 ? 'checked' : 'checked' ?> /><label for="r1"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/1' ) ?></label></div>
                                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="2" id="r2" <?= !empty($customer['delivery']) && $customer['delivery'] == 2 ? 'checked' : '' ?> /><label for="r2"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/2' ) ?></label></div>
                                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery bind" value="3" id="r3" <?= !empty($customer['delivery']) && $customer['delivery'] == 3 ? 'checked' : '' ?> /><label for="r3"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/3' ) ?></label></div>
                                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery bind" value="4" id="r4" <?= !empty($customer['delivery']) && $customer['delivery'] == 3 ? 'checked' : '' ?> /><label for="r4"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/4' ) ?></label></div>
                                <div class="input_radio"><input type="radio" name="order_delivery" class="order_delivery unbind" value="5" id="r5" <?= !empty($customer['delivery']) && $customer['delivery'] == 4 ? 'checked' : '' ?> /><label for="r5"><span></span><?= \config::get( 'global#delivery/'.$lang_id.'/5' ) ?></label></div>
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
									<input type="radio" name="order_pay" value="1" id="r6" <?= !empty($customer['pay']) && $customer['pay'] == 1 ? 'checked' : 'checked' ?> />
									<label for="r6">
										<span></span>Оплата готівкою при отриманні товару (в разі доставки службою перевозки додатково утримується комісія за наложений платіж 4%);
									</label>
								</div>
								<div class="input_radio">
									<input type="radio" name="order_pay" value="2" id="r7" <?= !empty($customer['pay']) && $customer['pay'] == 2 ? 'checked' : '' ?> />
									<label for="r7">
										<span></span>Оплата карткою VISA, MASTERCARD/EVROCARD;
									</label>
								</div>
								<div class="input_radio">
									<input type="radio" name="order_pay" value="3" id="r8" <?= !empty($customer['pay']) && $customer['pay'] == 3 ? 'checked' : '' ?> />
									<label for="r8">
										<span></span>Оплата за безготівковим розрахунком (рахунок на оплату відправимо відразу після обробки замовлення на Ваш e-mail);
									</label>
								</div>
								<div class="input_radio">
									<input type="radio" name="order_pay" value="4" id="r9" <?= !empty($customer['pay']) && $customer['pay'] == 4 ? 'checked' : '' ?> />
									<label for="r9">
										<span></span>Оплата через термінал I-box;
									</label>
								</div>
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
                        <input type="submit" value="<?= $t->_("checkout")?>" class="btn green">
                    </div>
                </div>

            </div>




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
                        <p class="login_with_social_title"><?= $t->_("login_via_social_network") ?></p>
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