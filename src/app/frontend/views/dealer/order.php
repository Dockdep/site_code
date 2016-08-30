<h2 class="content-header">
    <?= $t->_('ordering') ?>
</h2>
<section style="overflow: visible" class="content">
<div id="content">
<form method="post" action="" name="dealer_order_add">
<div style="height: 730px;" class="contacts_form">
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
            <?php if(isset($firm_total)) : ?>
            <li style="text-align: center" class="clearfix">
                <div style="display: inline-block"><?= $t->_('firm_goods') ?>
                    <span id="firm_total" name="firm_total" class="price">
                        <span><?= $firm_total ?></span> грн.
                    </span>
                </div>
            </li>
            <?php endif; ?>
        </ul>

        <div class="submit">
            <input style="padding:10px;margin-bottom:70px;margin-right: 66px;" type="submit" value="<?= $t->_("checkout")?>" class="btn green">
        </div>
    </div>
</div>
</form>
</div>
</section>