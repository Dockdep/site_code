<div id="content" class="clearfix">
    <div class="cabinet_login">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="float"><a itemprop="url" href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="float"><a itemprop="url" href="javascript:void(0);" title="<?= $t->_("enter")?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("enter")?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner"><?= $this->flash->output(); ?></div>

        <div class="sidebar_content_wrapper">
            <div class="inner clearfix">
                <div id="sidebar" class="float">
                    <div class="subcategory_sidebar_title">
                        <h3><?= $t->_("personal_account") ?></h3>
                    </div>
                </div>
                <div id="content_wrapper" class="float">
                    <div class="subcategory_content_wrapper_title">
                        <h3><?= $t->_("enter")?></h3>
                    </div>
                    <div class="clearfix">
                        <div class="float login_with login_with_email">
                            <form id="customer_login_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="" name="customer_login">
                                <ul class="form clearfix">
                                    <li class="clearfix">
                                        <div class="label float"><label for="email">Email<span class="required">&#8727;</span></label></div>
                                        <div class="input float"><input type="text" name="email" id="email" class="name" value=""></div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="label float"><label for="passwd">Пароль<span class="required">&#8727;</span></label></div>
                                        <div class="input float"><input type="password" name="passwd" id="passwd" class="name" value=""></div>
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
    </div>


</div>