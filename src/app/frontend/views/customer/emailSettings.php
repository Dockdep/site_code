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
                    <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/cabinet/email-settings')?>" title="<?= $t->_("email_settings") ?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("email_settings") ?></span></a></li>
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
                        <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet_email_settings' ])) ?>" title="<?= $t->_("email_settings") ?>" class="active"><?= $t->_("email_settings") ?></a>

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
                <?= $this->partial('partial/emailSettings', ['email_settings' => $email_settings]); ?>
            </div>
        </div>
    </div>
</div>