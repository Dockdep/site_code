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
                    <div class="table_name header_gradient">Акция</div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="news_add_edit">

                            <div class="version_1 clearfix">
                                <?php if (isset( $page['0']['id'] ) && !empty( $page['0']['id'] )): ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="id">Номер</label></div>
                                    <div class="input"><input disabled type="text" name="id" id="id" value='<?=  $page['0']['id'] ?>'></div>
                                </div>
                                <?php endif; ?>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Имя</label></div>
                                    <div class="input"><input type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="action_id">Лимиты акций</label></div>
                                    <div class="input"><select name="action_id" id="action_id">
                                            <?php if(isset( $limits ) && !empty( $limits)) {
                                                foreach($limits as $i){
                                                    if(isset( $page['0']['action_id'] ) && !empty( $page['0']['action_id'])):?>
                                                        <option value="<?= $i['id'] ?>"<?= ($i['id'] == $page['0']['action_id']) ? "selected" : '' ?>><?= $i['limit'] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $i['id'] ?>"><?= $i['limit'] ?></option>
                                                    <?php endif;
                                                }
                                            }?>
                                        </select></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="input"><input type="file" name="update_image" id="update_image" value=''></div>
                                    <img src="<?=  (isset( $page['0']['cover'] ) && !empty( $page['0']['cover'] ) ? $page['0']['cover'] : '') ?>">
                                </div>
                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'action_discount_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

