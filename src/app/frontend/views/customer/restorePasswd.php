<div id="content" class="clearfix">
    <div class="cabinet">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="order_menu_shadow"></div>
                <ul class="clearfix">
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/cabinet')?>" title="<?= $t->_("personal_account") ?>"><span itemprop="title"><?= $t->_("personal_account") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                    <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""  class="foat"><a  itemprop="url" href="javascript:void(0);" title="<?= $t->_("recover_password") ?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("recover_password") ?></span></a></li>
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
                        <h3><?= $t->_("recover_password") ?></h3>
                    </div>
                    <form id="restore_passwd_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="">
                        <ul class="form clearfix">
                            <li class="clearfix">
                                <div class="label float"><label for="email">Email<span class="required">&#8727;</span></label></div>
                                <div class="input float"><input type="text" name="email" id="email" class="name" value=""></div>
                            </li>
                        </ul>
                        <div class="submit">
                            <input type="submit" value="<?= $t->_("recover_password") ?>" class="btn green">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>