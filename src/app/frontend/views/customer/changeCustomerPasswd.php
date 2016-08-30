<div id="content" class="clearfix">
    <div class="cabinet">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url" href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url" href="<?= $this->seoUrl->setUrl('/cabinet')?>" title="<?= $t->_("personal_account") ?>"><span itemprop="title"><?= $t->_("personal_account") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url" href="javascript:void(0);" title="<?= $t->_('change_password')?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_('change_password')?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner"><?= $this->flash->output(); ?></div>

        <div class="sidebar_content_wrapper">
            <div class="inner clearfix">
                <div id="sidebar" class="float">
                    <div class="subcategory_sidebar_title">
                        <h3><?= $t->_("personal_account") ?></h3>
                        <p><?= $t->_('change_password')?></p>
                    </div>
                </div>
                <div id="content_wrapper" class="float">
                    <div class="subcategory_content_wrapper_title">
                        <h3><?= $t->_('change_password')?></h3>
                    </div>
                    <form id="change_passwd_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="" name="change_passwd">
                        <ul class="form clearfix">
                            <li class="clearfix">
                                <div class="label float"><label for="previous_passwd"><?= $t->_("previous_password") ?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="password" name="previous_passwd" id="previous_passwd" class="name" value=""></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="password"><?= $t->_("new_password") ?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="password" name="passwd" id="passwd" class="name" value=""></div>
                            </li>
                            <li class="clearfix">
                                <div class="label float"><label for="confirm_passwd"><?= $t->_("confirm_password")?><span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="password" name="confirm_passwd" id="confirm_passwd" class="name" value=""></div>
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