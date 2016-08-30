
<div class="section-box-content" data-type="background" data-speed="10">
    <div class="section-box lending_pic">
        <div class="box-wr">
            <div class="box-all">
                <p class="lending_pic_p">
                    <?= $t->_('wallet_sales') ?>
                </p>
                <div class="registration_box">
                    <div class="registration_box_header">
                        <?= $t->_('sales_subscription') ?>
                    </div>
                    <form id="jform1">
                        <input class="registration_box_name" placeholder="<?= $t->_('firstname') ?>" name="name">
                        <span class="reg_er name_i"><?= $t->_('illegal_field') ?> "<?= $t->_('firstname') ?>"</span>
                        <input class="registration_box_mail" placeholder="e-mail" name="mail">
                        <span class="reg_er mail_i"><?= $t->_('illegal_field') ?> "E-mail"</span>
                        <button style="text-transform: uppercase" class="send_button"><?= $t->_('subscribe_sales') ?></button>
                    </form>
                    <div class="registration_box_secret">
                        <img src="/landing_sales/images/secret.png">
                        <?= $t->_('privacy') ?>
                    </div>
                    <div class="registration_box_footer">
                        <a href="">
                            <?= $t->_('subscribe_reason') ?>
                            <img src="/landing_sales/images/q.png">
                        </a>
                        <div class="tooltip">
                            <img src="/landing_sales/images/tooltip_close.png" class="cross_close">
                            <span>Ваш email</span>  <?= $t->_('subscribe_tooltip') ?>
                            <img src="/landing_sales/images/arrow1.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-box-content" data-type="background" data-speed="10">
    <div class="section-box menu">
        <div class="box-wr">
            <div class="box-all<?= $lang_id == 2 ? ' ru' : '' ?>">
                <ul>
                    <a href="#sales_block" class="link"><li class="active_menu f_b"><?= $t->_('current_sales') ?></li></a><a href="#adv_block" class="link"><li class="s_b"><?= $t->_('joined_profitable') ?></li></a><a href="#sales_season" class="link"><li class="t_b"><?= $t->_('seasonal_sales') ?></li></a><a href="#reviews_block" class="link"><li style="padding: 16px 47px;" class="fr_b"><?= $t->_('reviews') ?></li></a><a href="#widget_block" class="link"><li class="fv_b"><?= $t->_('stay_up') ?></li></a>
                </ul>
            </div>
        </div>
    </div>
    <div class="section-box" id="sales_block">
        <div class="box-wr sales">
            <div class="box-all">
                <?= $this->partial('partial/recentSales', ['classic_sales', $classic_sales]) ?>
            </div>
        </div>
    </div>
    <div class="section-box pattern" id="adv_block">
        <div class="box-wr">
            <div class="box-all">
                <div class="why_me">
                    <?= $t->_('our_advantages') ?>
                </div>
                <div class="why_block">
                    <img src="/landing_sales/images/ic1.png">
                    <?= $t->_('savings') ?>
                </div>
                <div class="why_block">
                    <img src="/landing_sales/images/ic2.png">
                    <?= $t->_('year_sales') ?>
                </div>
                <div class="why_block">
                    <img src="/landing_sales/images/ic3.png">
                    <?= $t->_('regular_sales') ?>
                </div>
                <div class="why_block">
                    <img src="/landing_sales/images/ic4.png">
                    <?= $t->_('buying_goods') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section-box" id="sales_season">
        <div class="box-wr">
            <div class="box-all">
                <div id="carousel-example-generic1" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <?php $indicators = count($seasonal_sales) / 3 ?>
                    <?php if($indicators > 1): ?>
                    <ol class="carousel-indicators">
                        <?php for($i = 0; $i < $indicators; $i++): ?>
                        <li data-target="#carousel-example-generic1" data-slide-to="<?= $i ?>"<?= $i == 0 ?' class="active"' : ''?>></li>
                        <?php endfor; ?>
                    </ol>
                    <?php endif; ?>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach($seasonal_sales as $k => $sale): ?>
                        <?php if($k % 3 == 0): ?>
                        <div class="item<?= ($k == 0) ? ' active' : '' ?>">
                        <?php endif; ?>
                            <a href="<?= $this->seoUrl->setUrl($sale['link']) ?>" class="sales_season_link">
                                <div class="sales_season">
                                    <img src="<?= $this->storage->getPhotoURL($sale['seasonal_cover'], 'sales/seasonal_cover', 'original'); ?>">
                                    <div class="sales_season_footer">
                                        <span class="header"><?= $sale['name'] ?></span>
                                        <p>

                                        </p>
                                        <div class="end_sales_season months">
                                            <?php if ($sale['start_month'] == $sale['end_month']): ?>
                                                <?= $t->_('month_list')[$sale['start_month'] - 1]; ?>
                                            <?php else: ?>
                                                <?= $t->_('from_month') ?>
                                                <?= $t->_('second_month_list')[$sale['start_month'] - 1]; ?>
                                                по <?= $t->_('month_list')[$sale['end_month'] - 1]; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php if((($k + 1) % 3 == 0) || empty($seasonal_sales[$k + 1])): ?>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controls -->
                    <?php if($indicators > 1): ?>
                    <a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="sales_des">
                    <p class="sales_des">
                    <?= $t->_('annual_sales_features') ?>
                </div>
                <div class="note">
                    <span>*</span><?= $t->_('annual_sales') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section-box review" id="reviews_block">
        <div class="box-wr">
            <div class="box-all">
                <div class="user_tabs">
                    <ul>
                        <?php if(!empty($reviews)): ?>
                        <?php foreach($reviews as $i => $r): ?>
                        <li <?= $i == 0 ? 'class="active_user"' : '' ?>>
                            <a href="#<?= $i ?>"><img src="<?= $this->storage->getPhotoURL($r['avatar'], 'reviews', '92x'); ?>">
                                <?= $r['name'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <?php if(!empty($reviews)): ?>
                    <?php foreach($reviews as $i => $r): ?>
                    <div class="rewiew_text <?= $i == 0 ? 'show' : 'hide' ?>"  id="<?= $i ?>">
                        <?= $r['review'] ?>
                        <a href="<?= $r['link'] ?>" class="spoiler"><?= $r['link'] ?></a>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section-box pattern_small" id="sales_reg">
        <div class="box-wr">
            <div class="box-all">
                <div class="sales_registration">
                    <p><?= $t->_('sales_subscription') ?></p>
                    <form id="jform2">
                        <input placeholder="<?= $t->_('firstname') ?>" id="sales_input">
                        <span class="reg_er span_m"><?= $t->_('illegal_field') ?> "<?= $t->_('firstname') ?>"</span>
                        <input placeholder="e-mail" id="sales_input1">
                        <span class="reg_er span_e"><?= $t->_('illegal_field') ?> "E-mail"</span>
                        <button style="text-transform: uppercase" class="sales_button"><?= $t->_('subscribe_sales') ?></button>
                    </form>
                    <div class="sales_des">
                        <p class="sales_des">
                            <?= $t->_('email_discount') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-box widget" id="widget_block">
        <div class="box-wr">
            <div class="box-all">
                <div class="fb-page" data-href="https://www.facebook.com/Professionalseeds/?fref=ts" data-width="422" data-height="72" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/Professionalseeds/?fref=ts"><a href="https://www.facebook.com/Professionalseeds/?fref=ts">Професійне Насіння</a></blockquote></div></div>
                <script src="https://apis.google.com/js/platform.js"></script>
                <div class="youtube">
                    <div class="g-ytsubscribe" data-channelid="UCMnG-NxtoprcTxKcPouwWdQ" data-layout="full" data-count="default"></div>
                </div>
                <ul class="small_menu">
                    <li><a style="text-transform: uppercase" href="<?= $this->seoUrl->setUrl('/contacts') ?>"><?= $t->_('contacts') ?></a></li>
                    <li><a style="text-transform: uppercase" href="<?= $this->seoUrl->setUrl('/dostavka_i_oplata-2') ?>"><?= $t->_('delivery_payment') ?></a></li>
                    <li><a style="text-transform: uppercase" href="<?= $this->seoUrl->setUrl('/prof_tips') ?>"><?= $t->_('prof_tips') ?></a></li>
                    <li><a style="text-transform: uppercase" href="<?= $this->seoUrl->setUrl('/pro_companiu-1') ?>"><?= $t->_('about_company') ?></a></li>
                </ul>
                <img src="/landing_sales/images/arrow.png" class="arrow">
                <p class="arrow_text"><?= $t->_('often_sales') ?></p>
            </div>
        </div>
    </div>
    <div class="section-box grey">
        <div class="box-wr">
            <div class="box-all">
                <ul>
                    <li>
                        <a href="<?= $this->seoUrl->setUrl('/') ?>"><?= $t->_('main_page') ?></a>
                    </li>
                    <img src="/landing_sales/images/arrows.png">
                    <li>
                        <a href="<?= $this->seoUrl->setUrl('/news-actions') ?>"><?= $t->_('akcii') ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->partial('partial/share'); ?>

