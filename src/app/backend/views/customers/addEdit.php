<div id="addEdit">
    <div class="inner"><?= $this->flash->output(); ?></div>
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">
                    <?= $this->partial('partial/sidebar') ?>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="content_wrapper_list clearfix">
                    <div class="table_name header_gradient">Пользователи</div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="news_add_edit">

                            <div class="version_1 clearfix">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Имя</label></div>
                                    <div class="input"><input type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="users_group">Группа пользователей</label></div>
                                    <div class="input"><select name="users_group" id="group">
                                            <?php if(isset( $users_group ) && !empty( $users_group)) {
                                                foreach($users_group as $group){
                                                    if(isset( $page['0']['groups'] ) && !empty( $page['0']['groups'])):?>
                                                        <option value="<?= $group['id']?>"<?= ($group['id']==$page['0']['groups'])?"selected":''?>><?= $group['name']?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $group['id']?>"><?= $group['name']?></option>
                                                    <?php endif;
                                                }
                                            }?>
                                    </select></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="special_users">Группа дилеров</label></div>
                                    <div class="input"><select name="special_users" id="group">
                                            <?php if(isset( $special_users ) && !empty( $special_users)) {
                                                foreach($special_users as $group){
                                                    if(isset( $page['0']['groups'] ) && !empty( $page['0']['groups'])):?>
                                                        <option value="<?= $group['id']?>"<?= ($group['id']==$page['0']['groups'])?"selected":''?>><?= $group['name']?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $group['id']?>"><?= $group['name']?></option>
                                                    <?php endif;
                                                }
                                            }?>
                                        </select></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="email">email</label></div>
                                    <div class="input"><input type="text" name="email" id="email" value='<?=  (isset( $page['0']['email'] ) && !empty( $page['0']['email'] ) ? $page['0']['email'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="password">Пароль</label></div>
                                    <div class="input"><input type="text" name="password" id="password" value=''></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="birth_date">Дата рождения</label></div>
                                    <div class="input"><input type="text" name="birth_date" id="birth_date" value='<?=  (isset( $page['0']['birth_date'] ) && !empty( $page['0']['birth_date'] ) ? $page['0']['birth_date'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="phone">Телефон</label></div>
                                    <div class="input"><input type="text" name="phone" id="phone" value='<?=  (isset( $page['0']['phone'] ) && !empty( $page['0']['phone'] ) ? $page['0']['phone'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="city">Город</label></div>
                                    <div class="input"><input type="text" name="city" id="city" value='<?=  (isset( $page['0']['city'] ) && !empty( $page['0']['city'] ) ? $page['0']['city'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="address">Адрес</label></div>
                                    <div class="input"><input type="text" name="address" id="address" value='<?=  (isset( $page['0']['address'] ) && !empty( $page['0']['address'] ) ? $page['0']['address'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="delivery">Доставка</label></div>
                                    <div class="input"><input type="text" name="delivery" id="delivery" value='<?=  (isset( $page['0']['delivery'] ) && !empty( $page['0']['delivery'] ) ? $page['0']['delivery'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="comments">Коментарии</label></div>
                                    <div class="input"><input type="text" name="comments" id="comments" value='<?=  (isset( $page['0']['comments'] ) && !empty( $page['0']['comments'] ) ? $page['0']['comments'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="registration_date">Дата реистрации</label></div>
                                    <div class="input"><input type="text" name="registration_date" id="registration_date" value='<?=  (isset( $page['0']['registration_date'] ) && !empty( $page['0']['registration_date'] ) ? $page['0']['registration_date'] : date( 'd.m.Y H:i:s' )) ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="lastlogin_date">Последний онлайн</label></div>
                                    <div class="input"><input type="text" name="lastlogin_date" id="lastlogin_date" value='<?=  (isset( $page['0']['lastlogin_date'] ) && !empty( $page['0']['lastlogin_date'] ) ? $page['0']['lastlogin_date'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="pay" name="pay" class="pay" value="1" '.( isset( $page['0']['pay'] ) && !empty( $page['0']['pay'] ) && $page['0']['pay'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="pay"><span></span>Оплата ?</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="subscribed" name="subscribed" class="subscribed" value="1" '.( isset( $page['0']['subscribed'] ) && !empty( $page['0']['subscribed'] ) && $page['0']['subscribed'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="subscribed"><span></span>Подписан ?</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="page_status_1" name="status" class="page_status" value="1" '.( isset( $page['0']['status'] ) && !empty( $page['0']['status'] ) && $page['0']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="page_status_1"><span></span>Статус ?</label>
                                </div>

                            </div>



                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'customers_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>