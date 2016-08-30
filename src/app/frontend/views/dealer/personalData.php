<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
    <div class="block_content block930">
        <h3 class="table_title">Ваш статус</h3>
        <div class="block_pad5">
            <div class="cab_stat_bl">
                <div class="opt_status <?= $special_users['css_class'] ?> active_status"><?= $special_users['title'] ?></div>
            </div>
            <div class="cab_stat_bl">
                <div class="price"><?= $t->_('from') ?> <span><?= $special_users['year_budget'] ?></span> грн./<?= $t->_('year') ?></div>
            </div>
            <?php if(isset($next_special_users[0])): ?>
            <div class="cab_stat_bl link_more">
                <a href="<?= $this->url->get([ 'for' => 'wholesale_prices' ]) ?>"><img src="/images/knowmore.png"><br><?= $t->_('learn_advantages') ?></a>
            </div>
            <div class="cab_stat_bl">
                <div class="opt_status <?= $next_special_users[0]['css_class'] ?>"><?= $next_special_users[0]['title'] ?></div>
            </div>
            <div class="cab_stat_bl">
                <div class="price"><?= $t->_('from') ?> <span><?= $next_special_users[0]['year_budget'] ?></span> грн./<?= $t->_('year') ?></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="down_line"></div>
        <h3 class="table_title"><?= $t->_('your_discount') ?></h3>
        <div class="skidka"><?= $special_users['discount'] ?>%</div>
        <div class="down_line"></div>
        <h3 class="table_title"><?= $t->_('recommend') ?></h3>
        <form id="edit_user_info_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" name="edit_user_info">
        <div class="left20">
            <div id="dropdown-value" class="tablediv">
                <?= $recommended['goods'] ?>
            </div>
            <input id="dropdown-id" name="users_group_id" type="hidden" value="<?= $recommended['id'] ?>">
            <div class="tablediv dropdown">
                <a data-target="#" id="drop" class="pad5 dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    <img src="/images/redakt.png">
                </a>
                <ul class="dropdown-menu" aria-labelledby="drop">
                    <?php foreach($users_groups as $users_group): ?>
                    <li>
                        <a class="dropdown-link" href="#"><?= $users_group['goods_description'] ?></a>
                        <input type="hidden" value="<?= $users_group['users_groups_id'] ?>">
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="down_line"></div>
        <h3 class="table_title"><?= $t->_('personal_data') ?></h3>
            <ul  style="margin: 0;padding-left: 15px;" class="form clearfix">
                <li class="clearfix align-center">
                    <div id="img_block">
                        <img style="vertical-align: middle"  src="<?= isset($customer['avatar'])
                            ? $this->storage->getPhotoUrlDev($customer['avatar'], 'dealers', '160x')
                            : \config::get('frontend#defaults/default_user_image') ?>" class="img-circle" alt="User Image">
                    </div>
                </li>
                <li class="clearfix align-center">
                    <div style="display: inline-block; width: auto" class="input">
                        <label id="btn_file" class="btn btn-default">
                            <span><?= $t->_('load_photo') ?></span>
                            <input class="fileupload" name="files[]"  type="file">
                        </label>
                    </div>
                </li>
                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="order_name"><?= $t->_("n_s")?><span class="required">&#8727;</span></label></div>
                    <div class="input float"><input type="text" name="order_name" id="order_name" class="name" style="width: 260px;" value="<?= isset($customer['name']) && !empty($customer['name']) ? $customer['name'] : '' ?>"></div>
                </li>
                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="order_email">E-mail<span class="required">&#8727;</span></label></div>
                    <div class="input float"><input type="text" name="order_email" id="order_email" class="name" style="width: 260px;" value="<?= isset($customer['email']) && !empty($customer['email']) ? $customer['email'] : '' ?>"></div>
                </li>
                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="order_psw"><?= $t->_("new_password") ?></label></div>
                    <div class="input float"><input type="password" name="order_passwd_new" id="order_psw" class="psw" style="width: 260px;" value="" /><input type="hidden" name="order_passwd" value="<?= isset($customer['passwd']) && !empty($customer['passwd']) ? $customer['passwd'] : '' ?>"></div>
                </li>
                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="order_phone"><?= $t->_("m_phone")?><span class="required">&#8727;</span></label></div>
                    <div class="input float"><input type="text" name="order_phone" class="order_phone" class="name" style="width: 260px;" value="<?= isset($customer['phone']) && !empty($customer['phone']) ? $customer['phone'] : '' ?>"></div>
                </li>

                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="edit-date-birth"><?= $t->_("date_of_birth")?></label></div>
                    <div class="input float">
                        <select name="date_birth_day" class="form-text birth" style="width: 57px;">
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

                        <select name="date_birth_month"  class="form-text birth" style="width: 150px;">
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
                    <div class="label float" style="width: 275px"><label for="order_city"><?= $t->_("city")?><span class="required">&#8727;</span></label></div>
                    <div class="input float"><input type="text" name="order_city" id="order_city" class="name" style="width: 260px;" value="<?= isset($customer['city']) && !empty($customer['city']) ? $customer['city'] : '' ?>"></div>
                </li>
                <li class="clearfix">
                    <div class="label float" style="width: 275px"><label for="order_address"><?= $t->_("your_address") ?><span class="required">&#8727;</span></label></div>
                    <div class="input float"><input type="text" name="order_address" id="order_address" class="name" style="width: 260px;" value="<?= isset($customer['address']) && !empty($customer['address']) ? $customer['address'] : '' ?>"></div>
                </li>
            </ul>
            <div class="down_line"></div>
            <div class="block930"><input  value="<?= $t->_('save') ?>" type="submit" class="green_but"></div>
        </form>

    </div>
</section>