<div id="content_wrapper" style="width: 700px; margin: 0 0 0 100px;" class="float">
    <div class="subcategory_content_wrapper_title">
        <h3><?= $t->_("email_settings") ?></h3>
    </div>
    <form action="post" id="form-checked-email">
        <div class="email-settings_title">
            <div class="blocks-p">
                <input type="checkbox"  <?= isset($email_settings['delivery_status']) && !empty($email_settings['delivery_status']) ? 'checked' : '' ?> value="1" class="ios" name="delivery_status" >
                <a href="#"><?= $t->_("subscription_status") ?></a>
            </div>
        </div>
        <div class="email-settings_title">
            <h3><?= $t->_("choose_section") ?></h3>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_one']) && !empty($email_settings['section_one']) ? 'checked'  : '' ?> value="1" class="ios" name="section_one">
                <a href="#"><?= $t->_("Vegetable_seeds") ?></a>
            </div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_two']) && !empty($email_settings['section_two']) ? 'checked'  : '' ?> value="1" class="ios" name="section_two">
                <a href="#"><?= $t->_("lawn_grass") ?></a>
            </div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_three']) && !empty($email_settings['section_three']) ? 'checked'  : '' ?>  value="1" class="ios" name="section_three" >
                <a href="#"><?= $t->_("flower_seeds") ?></a>
            </div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_four']) && !empty($email_settings['section_four']) ? 'checked'  : '' ?> value="1" class="ios" name="section_four" >
                <a href="#"><?= $t->_("biologics") ?></a>
            </div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_five']) && !empty($email_settings['section_five']) ?'checked'  : '' ?> value="1" class="ios" name="section_five" >
                <a href="#"><?= $t->_("fertilizers") ?></a>
            </div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['section_six']) && !empty($email_settings['section_six']) ? 'checked'  : '' ?> value="1" class="ios" name="section_six" >
                <a href="#"><?= $t->_("goods_garden") ?></a>
            </div>
        </div>
        <div class="email-settings_title">
            <h3><?= $t->_("select_topics_list") ?></h3>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['events']) && !empty($email_settings['events']) ? 'checked'  : '' ?> value="1" class="ios" name="events" >
                <a href="#"><?= $t->_("akcii") ?></a>
            </div>
            <div class="blocks-p"></div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['novelty']) && !empty($email_settings['novelty']) ?'checked' : '' ?> value="1" class="ios" name="novelty" >
                <a href="#"><?= $t->_("novelty") ?></a>
            </div>
            <div class="blocks-p"></div>
            <div class="blocks-p">
                <input type="checkbox" <?= isset($email_settings['materials']) && !empty($email_settings['materials']) ? 'checked'  : '' ?> value="1" class="ios" name="materials" >
                <a href="#"><?= $t->_("useful_materials") ?></a>
            </div>
        </div>
        <div class="email-settings_title">
            <h3><?= $t->_("adjust_distribution") ?></h3>
            <div class="blocks-p">
                <input type="radio" <?= isset($email_settings['frequency']) && !empty($email_settings['frequency']) && $email_settings['frequency'] == 'one_week'? 'checked'  : '' ?>  name="frequency" class="group-email" value="one_week"  id="theme-1" /><label for="theme-1"><span></span><?= $t->_("one_per_week") ?></label>
            </div>
            <div class="blocks-p"></div>
            <div class="blocks-p">
                <input type="radio" <?= isset($email_settings['frequency']) && !empty($email_settings['frequency'])  && $email_settings['frequency'] == 'two_month' ? 'checked'  : '' ?> name="frequency" class="group-email" id="theme-2" value="two_month" /><label for="theme-2"><span></span><?= $t->_("two_per_month") ?></label>
            </div>
            <div class="blocks-p"></div>
            <div class="blocks-p">
                <input type="radio" <?= isset($email_settings['frequency']) && !empty($email_settings['frequency']) && $email_settings['frequency'] == 'one_month' ? 'checked' : '' ?> name="frequency" class="group-email" id="theme-3" value="one_month" /><label for="theme-3"><span></span><?= $t->_("one_per_month") ?></label>
            </div>
        </div>
        <div class="email-settings_title">
            <h3><?= $t->_("subscription_benefits") ?></h3>
            <div class="settings-circle-wrap">
                <div class="settings-circle">
                    <div class="settings-circle-img">
                        <img src="/images/ico-set-1.png" alt=""/>
                    </div>
                    <div class="settings-circle-text">
                        <p>
                            <?= $t->_("actual_information") ?>
                        </p>
                    </div>
                </div>
                <div class="settings-circle circle_two">
                    <div class="settings-circle-img">
                        <img src="/images/ico-set-2.png" alt=""/>
                    </div>
                    <div class="settings-circle-text">
                        <p>
                            <?= $t->_("discounts") ?>
                        </p>
                    </div>
                </div>
                <div class="settings-circle">
                    <div class="settings-circle-img">
                        <img src="/images/ico-set-3.png" alt=""/>
                    </div>
                    <div class="settings-circle-text">
                        <p>
                            <?= $t->_("bonuses") ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="settings-soc-wrap">
                <div class="settings-soc">
                    <p><?= $t->_("subscribe") ?></p>
                    <a href="https://www.facebook.com/Professionalseeds"><img src="/images/fb-set.png"/></a>
                </div>
                <div class="settings-soc">
                    <p></br><?= $t->_("overview_videos") ?></p>
                    <a href="https://www.youtube.com/channel/UCMnG-NxtoprcTxKcPouwWdQ"><img src="/images/youtube-set.png" /></a>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/js/iosCheckbox.js"></script>
<script>

    $(document).ready(function(){
        $(".ios").iosCheckbox();
        $('.blocks-p a').click(function(e) {
            e.preventDefault();
            var label = $(this).siblings('.ios-ui-select');
            var closerInput = $(this).siblings('input[type="checkbox"]');
            if( label.hasClass('checked')){
                label.removeClass('checked');
                closerInput.prop('checked', false);
            } else {
                label.addClass('checked');
                closerInput.prop('checked', true);
            }

        });

        $('#form-checked-email').click(function(){
            var send = $('#form-checked-email').serialize();

            $.post( "/cabinet/email-settings", send, function( data ) {

            });
        });
    });
</script>