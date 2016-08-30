<script type="text/javascript" src="/js/script-email-settings.js"></script>
<script>
    $(document).ready(function(){
        $('#cancel-all').click(function(e){
            e.preventDefault();
            $('#form-checked-email_02_1').fadeOut();
            $('#form-checked-email-02-2').fadeIn();
        });
    });
</script>
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
                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" title="<?= $t->_("profile") ?>" ><?= $t->_("profile") ?></a>
                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet_email_settings' ])) ?>" title="<?= $t->_("email_settings") ?>"><?= $t->_("email_settings") ?></a>

                        <?php

                        //p($orders);

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
                        <h3><?= $t->_("email_settings") ?> <span style="color: #157efb;"><?= $customer['email']?></span></h3>
                    </div>
                    <form  method="post" id="form-checked-email_02_1">
                        <div class="email-settings_title">
                            <input type="hidden" value="1" name="step-1">
                            <div class="email-settings_02_1-title2"><p>Изменить частоту получения рассылки</p></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" <?= isset($emailSettings['frequency']) && !empty($emailSettings['frequency']) && $emailSettings['frequency'] == 'one_week'? 'checked'  : '' ?>  name="frequency" class="group-email" value="one_week"  id="theme-2-1" /><label for="theme-2-1"><span></span>Раз в неделю</label>
                            </div>
                            <div class="blocks-p"></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" <?= isset($emailSettings['frequency']) && !empty($emailSettings['frequency'])  && $emailSettings['frequency'] == 'two_month' ? 'checked'  : '' ?> name="frequency" class="group-email" id="theme-2-2" value="two_month" /><label for="theme-2-2"><span></span>Раз в две недели</label>
                            </div>
                            <div class="blocks-p"></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" <?= isset($emailSettings['frequency']) && !empty($emailSettings['frequency']) && $emailSettings['frequency'] == 'one_month' ? 'checked' : '' ?> name="frequency" class="group-email" id="theme-2-3" value="one_month" /><label for="theme-2-3"><span></span>Раз в месяц</label>
                            </div>
                            <div class="blocks-p"></div>

                            <div class="email-settings_02_1-buttons-wr">
                                <input type="submit" class="email-buttons-1"  id="email-buttons-sub2" value="ИЗМЕНИТЬ" />
                                <div class="email-buttons-2-wr">
                                    <a href="#" id="cancel-all" class="email-buttons-2">ОТПИСАТЬСЯ ОТ ВСЕГО</a>
                                </div>
                                <div class="email-buttons-2-wr">
                                    <a href="<?= $this->seoUrl->setUrl('/cabinet')?>" class="email-buttons-2">ОСТАВИТЬ ВСЕ КАК ЕСТЬ</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" id="form-checked-email-02-2">
                        <input type="hidden" value="1" name="step-2">

                        <div class="email-settings_title">
                            <div class="email-set-text">
                                <p>
                                    Очень жаль, что вы решили отписаться от рассылки. Возможно, мы мало старались…
                                    Но постойте! Дружить можно не только по электронной почте, загляните к нам в социальные сети, в
                                    Fасebook мы регулярно проводим конкурсы и розыгрыши призов. Как вам такой вариант? Вступайте
                                    в наши группы и следите за видеообозрениями.
                                </p>
                            </div>
                            <div class="email-set-soc">
                                <a href="#"><img style="float: left;" src="/images/fb-set.png" alt=""/></a>
                                <a href="#"><img style="float: right;" src="/images/youtube-set.png" alt=""/></a>
                            </div>
                            <div class="email-set-wont-wr">
                                <div class="email-set-wont">
                                    <p>Я передумал</p>
                                    <a href="<?= $this->seoUrl->setUrl('/cabinet/email-settings')?>" class="email-buttons-1" id="email-buttons-1_1">ИЗМЕНИТЬ</a>
                                </div>
                            </div>
                            <div class="email-settings_02_1-title2"><p>Почему вы покидаете нас?</p></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" value="Я получаю слишком много писем" name="cancel_reason" class="group-email" checked="checked" id="theme-3-1" /><label for="theme-3-1"><span></span>Я получаю слишком много писем</label>
                            </div>
                            <div class="blocks-p"></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" value="Я не подписывался на вашу рассылку" name="cancel_reason" class="group-email" id="theme-3-2" /><label for="theme-3-2"><span></span>Я не подписывался на вашу рассылку</label>
                            </div>
                            <div class="blocks-p"></div>
                            <div class="blocks-p blocks-p-email-02-1">
                                <input type="radio" value="Вы присылаете спам" name="cancel_reason" class="group-email" id="theme-3-3" /><label for="theme-3-3"><span></span>Вы присылаете спам</label>
                            </div>
                            <div class="blocks-p"></div>
                            <div class="blocks-p blocks-p-email-02-1" style="width: 370px">
                                <input type="radio"  name="cancel_reason" class="group-email" id="theme-3-4" /><label for="theme-3-4"><span></span>У меня особое мнение по поводу вашей рассылки</label>
                            </div>
                            <div class="email-set-area">
                                <textarea name="cancel_reason" id="email-set-area" cols="30" rows="10"></textarea>
                            </div>
                            <div class="em-sub">
                                <input type="submit" name="" class="email-buttons-1" id="email-buttons-sub" value="ПОДТВЕРДИТЬ" />
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>


</div>
</div>