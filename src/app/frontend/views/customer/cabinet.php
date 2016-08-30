<div id="content" class="clearfix">
    <div class="cabinet">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a  itemprop="url" href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/cabinet')?>" title="<?= $t->_('personal_account')?>"><span itemprop="title"><?= $t->_('personal_account')?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/cabinet')?>" title="<?= $t->_("profile") ?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("profile") ?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner"><?= $this->flash->output(); ?></div>
        <div class="sidebar_content_wrapper">
            <div class="inner clearfix">
                <div id="sidebar" class="float">
                    <div class="subcategory_sidebar_title">
                        <h3><?= $t->_("personal_account") ?></h3>
                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" title="<?= $t->_("profile") ?>" class="active"><?= $t->_("profile") ?></a>
                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet_email_settings' ])) ?>" title="<?= $t->_("email_settings") ?>"><?= $t->_("email_settings") ?></a>
                            <?php


                            if( !empty( $orders ) )
                            {

                                $data_orders =
                                    '<a href="#" title="Мої замовлення" class="my_orders">Мої замовлення</a>'.
                                    '<ul class="toggle">';

                                foreach( $orders as $o )
                                {
                                    $data_orders .= '<li><a href="'.$this->seoUrl->setUrl($this->url->get([ 'for' => 'list_orders', 'order_id' => $o['id'] ])).'" title="">№'.$o['id'].' ('.date( 'd.m.Y', strtotime($o['created_date']) ).')</a></li>';
                                }

                                $data_orders .=
                                    '</ul>';

                                echo( $data_orders );

                            }

                            ?>


                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'customer_logout' ])) ?>" title="<?= $t->_("exit")?>"><?= $t->_("exit")?></a>
                    </div>
                </div>
                <div id="content_wrapper" class="float">
                    <div class="subcategory_content_wrapper_title">
                        <h3><?= $t->_("editing") ?></h3>
                    </div>
                    <form id="edit_user_info_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="" name="edit_user_info">
                        <ul class="form clearfix">
                            <li class="clearfix">
                                <div class="label float"><label for="order_name"><?= $t->_("n_s")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="order_name" id="order_name" class="name" value="<?= isset($customer['name']) && !empty($customer['name']) ? $customer['name'] : '' ?>"></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="order_email">E-mail<span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="order_email" id="order_email" class="name" value="<?= isset($customer['email']) && !empty($customer['email']) ? $customer['email'] : '' ?>"></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="order_psw"><?= $t->_("new_password") ?></label></div>
                                <div class="input float"><input type="password" name="order_passwd_new" id="order_psw" class="psw" value="" /><input type="hidden" name="order_passwd" value="<?= isset($customer['passwd']) && !empty($customer['passwd']) ? $customer['passwd'] : '' ?>"></div>
                            </li>							
                            <li class="clearfix">
                                <div class="label float"><label for="order_phone"><?= $t->_("m_phone")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="order_phone" class="order_phone" class="name" value="<?= isset($customer['phone']) && !empty($customer['phone']) ? $customer['phone'] : '' ?>"></div>
                            </li>

                            <li class="clearfix">
                                <div class="label float"><label for="edit-date-birth"><?= $t->_("date_of_birth")?></label></div>
                                <div class="input float">
                                    <select name="date_birth_day" class="form-text birth">
                                        <?php
                                        echo('<option value=""></option>');
                                        for( $i=1; $i<=31; $i++ )
                                        {
                                            echo(
                                                '<option value="'.( $i < 10 ? '0' : '' ).$i.'" '.
                                                (
                                                ( isset( $customer['birth_date'] ) )
                                                    ?
                                                    (
                                                    ( $i == date( 'j', strtotime( $customer['birth_date'] ) ) )
                                                        ?
                                                        'selected="selected"'
                                                        :
                                                        ''
                                                    )
                                                    :
                                                    ''
                                                ).'>'.$i.'</option>'
                                            );
                                        }
                                        ?>
                                    </select>

                                    <select name="date_birth_month"  class="form-text birth">
                                        <?php
                                        echo('<option value=""></option>');
                                        for( $i=1; $i<=12; $i++ )
                                        {
                                            echo(
                                                '<option value="'.( $i < 10 ? '0' : '' ).$i.'" '.
                                                (
                                                ( isset( $customer['birth_date'] ) )
                                                    ?
                                                    (
                                                    ( $i == date( 'm', strtotime( $customer['birth_date'] ) ) )
                                                        ?
                                                        'selected="selected"'
                                                        :
                                                        ''
                                                    )
                                                    :
                                                    ''
                                                ).'>'.$month_names[$i-1].'</option>'
                                            );
                                        }
                                        ?>
                                    </select>

                                    <select name="date_birth_year" class="form-text birth">
                                        <?php
                                        echo('<option value=""></option>');
                                        for( $i=date('Y')-90; $i<=date('Y')-18; $i++ )
                                        {
                                            echo(
                                                '<option value="'.$i.'" '.
                                                (
                                                ( isset( $customer['birth_date'] ) )
                                                    ?
                                                    ( $i == date( 'Y', strtotime( $customer['birth_date'] ) ) )
                                                        ?
                                                        'selected="selected"'
                                                        :
                                                        ''
                                                    :
                                                    ''
                                                ).'>'.$i.'</option>'
                                            );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="order_city"><?= $t->_("city")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="order_city" id="order_city" class="name" value="<?= isset($customer['city']) && !empty($customer['city']) ? $customer['city'] : '' ?>"></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="order_address"><?= $t->_("your_address") ?></label></div>
                                <div class="input float"><input type="text" name="order_address" id="order_address" value="<?= isset($customer['address']) && !empty($customer['address']) ? $customer['address'] : '' ?>"></div>
                            </li>

                            <?php

                            /*
                            <li class="clearfix with_radio_buttons">
                                <div class="label float"><label for="order_delivery">Варіант доставки<span class="required">&#8727;</span></label></div>
                                <div class="input float">
                                    <div class="input_radio"><input type="radio" name="order_delivery" value="1" id="r1" <?= !empty($customer['pay']) && $customer['pay'] == 1 ? 'checked' : '' ?> /><label for="r1"><span></span>Доставка по Києву та области</label></div>
                                    <div class="input_radio"><input type="radio" name="order_delivery" value="2" id="r2" <?= !empty($customer['pay']) && $customer['pay'] == 2 ? 'checked' : '' ?> /><label for="r2"><span></span>Доставка по Україні</label></div>
                                    <div class="input_radio"><input type="radio" name="order_delivery" value="3" id="r3" <?= !empty($customer['pay']) && $customer['pay'] == 3 ? 'checked' : '' ?> /><label for="r3"><span></span>Я заберу сам в пункті видачі/самовивіз</label></div>
                                    <div class="description">
                                        Доставимо Ваше замовлення на цю адресу! <br />
                                        Вартість доставки 30 або 50 грн залежно від габаритів замовлення
                                    </div>
                                </div>
                            </li>
                            <li class="clearfix  with_radio_buttons">
                                <div class="label float"><label for="order_pay">Способи оплати<span class="required">&#8727;</span></label></div>
                                <div class="input float">
                                    <div class="input_radio"><input type="radio" name="order_pay" value="1" id="r4" <?= !empty($customer['pay']) && $customer['pay'] == 1 ? 'checked' : '' ?> /><label for="r4"><span></span>Сплатити готівкою</label></div>
                                    <div class="input_radio"><input type="radio" name="order_pay" value="2" id="r5" <?= !empty($customer['pay']) && $customer['pay'] == 2 ? 'checked' : '' ?> /><label for="r5"><span></span>Сплатити на картку Приват Банку (оплата натходить на рахунок від 30 хвилин до доби!)</label></div>
                                    <div class="input_radio"><input type="radio" name="order_pay" value="3" id="r6" <?= !empty($customer['pay']) && $customer['pay'] == 3 ? 'checked' : '' ?> /><label for="r6"><span></span>Сплатити за безготівковим розрахунком (оплата натходить на рахунок від 1 до 3 робочих днів! Рахунок на оплату відправимо після обробки замовлення на Ваш e-mail)</label></div>
                                    <div class="input_radio"><input type="radio" name="order_pay" value="4" id="r7" <?= !empty($customer['pay']) && $customer['pay'] == 4 ? 'checked' : '' ?> /><label for="r7"><span></span>Сплатити "Правекс-телеграф" (оплата грошовим переказом надходить від 30 хвилин до 4 годин)</label></div>
                                </div>
                            </li>
                            <li class="clearfix with_textarea">
                                <div class="label float"><label for="order_name">Текст коментаря</label></div>
                                <div class="input float">
                                    <textarea name="order_comments"><?= isset($customer['comments']) && !empty($customer['comments']) ? $customer['comments'] : '' ?></textarea>
                                    <div class="description">
                                        Додаткова інформация: район, ліфт, поверх, домофон...
                                    </div>
                                </div>
                            </li>

                            */
                            ?>

                        </ul>
                        <div class="submit clearfix">
                            <input type="submit" value="<?= $t->_("save")?>" class="btn green float float_right">
                            <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" class="float float_right"><?= $t->_("cancel") ?></a>
                        </div>
                        <div class="submit clearfix">
                            <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'change_customer_passwd' ])) ?>" class="float float_right change_passwd"><?= $t->_('change_password')?></a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $( document ).ready(function() {
        if($('.successMessage')&&($('.successMessage').html() =="Ви успішно закінчили реєстрацію" ||$('.successMessage').html() =="Вы успешно закончили регистрацию" )){
            eventMailer.event_type =  'add_subscribe';
            eventMailer.event      =  'registration_complete';
            eventMailer.email = '<?=$customer['email']?>'?'<?=$customer['email']?>': $('#order_email').val();
            eventMailer.name = '<?=$customer['name']?>';
            eventMailer.password = '<?=$customer['user_pass']?>';

            eventMailer.email_cancel = "http://semena.in.ua/cabinet/email-cancel/<?=md5( $customer['email'].'just_sum_text' )?>";
            eventMailer.email_settings = "http://semena.in.ua/cabinet/email-settings-key/<?=md5( $customer['email'].'just_sum_text' )?>";
            eventMailer.cabinet_key = "http://semena.in.ua/cabinet/key/<?= md5( $customer['email'].'just_sum_text' )?>";
            eventMailer.callOtherDomain();

        }


    });


</script>