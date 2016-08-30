<div id="content" class="clearfix">
    <div class="static_page">
        <div class="breadcrumbs">
            <div class="inner">
                <div class="item_menu_shadow"></div>
                <ul class="clearfix">
                    <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
                    <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
                   <li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="<?= $this->seoUrl->setUrl('/call-back')?>" title="<?= $t->_("Feedback")?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("Feedback")?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="inner"><?= $this->flash->output(); ?></div>

        <div class="call-back callback_form">
            <div class="inner">
                <h2><?= $t->_("Feedback")?></h2>
                <form id="callback_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'callback' ])) ?>" name="callback">
                    <ul class="form clearfix">
                        <li class="clearfix">
                            <div class="label float"><label for="email"><?= $t->_("introduce_yourself") ?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="name" id="name" class="name" value="<?= isset($callback_session['name']) && !empty($callback_session['name']) ? $callback_session['name'] : (!empty( $customer ) ? $customer['0']['name'] : '') ?>"></div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="email"><?= $t->_("feedback_post") ?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="email" id="email" class="name" value="<?= isset($callback_session['email']) && !empty($callback_session['email']) ? $callback_session['email'] : '' ?>"></div>
                        </li>
                        <li class="clearfix with_textarea">
                            <div class="label float"><label for="comments"><?= $t->_("comment_text") ?><span class="required">&#8727;</span></label></div>
                            <div class="input float">
                                <textarea name="comments" id="comments"><?= isset($callback_session['name']) && !empty($callback_session['comments']) ? $callback_session['comments'] : '' ?></textarea>
                            </div>
                        </li>
                    </ul>
                    <div class="submit float float_right">
                        <input type="submit" value="<?= $t->_("send_message") ?>" class="btn green">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>