<div id="content" class="clearfix">
    <div class="cabinet">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a  itemprop="url" href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url" href="<?= $this->seoUrl->setUrl('/cabinet')?>" title="<?= $t->_("personal_account") ?>"><span itemprop="title"><?= $t->_("personal_account") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url" href="javascript:void(0);" title="Реєстрація" class="breadcrumbs_last"><span itemprop="title">Реєстрація</span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner"><?= $this->flash->output(); ?></div>

        <div class="sidebar_content_wrapper">
            <div class="inner clearfix">
                <div id="sidebar" class="float">
                    <div class="subcategory_sidebar_title">
                        <h3><?= $t->_("personal_account") ?></h3>
                        <p>Реєстрація</p>
                    </div>
                </div>
                <div id="content_wrapper" class="float">
                    <div class="subcategory_content_wrapper_title">
                        <h3>Реєстрація</h3>
                    </div>
                    <form id="registration_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="" name="finish_registration">
                        <ul class="form clearfix">
                            <li class="clearfix">
                                <div class="label float"><label for="registration_name"><?= $t->_("n_s")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="registration_name" id="registration_name" class="name" value=""></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="registration_email">Ваш email</label></div>
                                <div class="input float">
                                    <input type="text" name="registration_email" id="registration_email" class="name" value="">
                                    <div class="description">
                                        <input type="checkbox" id="get_info" name="order_get_info" checked />
                                        <label for="get_info"><span></span><?= $t->_("receive")?></label>
                                    </div>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="registration_passwd">Пароль<span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="password" name="registration_passwd" id="registration_passwd" class="name" value=""></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="registration_confirm_passwd"><?= $t->_("confirm_password")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="password" name="registration_confirm_passwd" id="registration_confirm_passwd" class="name" value=""></div>
                            </li>
                        </ul>
                        <div class="submit">
                            <input type="submit" value="<?= $t->_("save") ?>" class="btn green">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>