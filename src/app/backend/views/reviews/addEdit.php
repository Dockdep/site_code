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
                    <div class="table_name header_gradient"></div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="reviews_add_edit">
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="name">Имя пользователя</label></div>
                                <div class="input"><input required type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                            </div>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="link">Ссылка на отзыв</label></div>
                                <div class="input"><input type="text" name="link" id="link" value='<?=  (isset( $page['0']['link'] ) && !empty( $page['0']['link'] ) ? $page['0']['link'] : '') ?>'></div>
                            </div>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="review">Отзыв</label></div>
                                <div class="input">
                                    <textarea name="review" id="review">
                                        <?=  (isset( $page['0']['review'] ) && !empty( $page['0']['review'] ) ? $page['0']['review'] : '') ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="clearfix input_wrapper">
                                <input type="checkbox" id="status" name="status" class="status" value="1" <?= ( isset( $page['0']['status'] ) && !empty( $page['0']['status'] ) && $page['0']['status'] == 1 ? 'checked="checked"' : '') ?> />
                                <label for="status"><span></span>Отображать отзыв</label>
                            </div>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="avatar">Аватарка пользователя</label></div>
                                <div class="input"><input type="file" name="avatar" id="avatar" value=''></div>
                            </div>
                            <?php if(isset( $page['0']['avatar'] ) && !empty( $page['0']['avatar'] )):?>
                                <img style="height: 100px" src="<?= $this->storage->getPhotoURL($page['0']['avatar'], 'reviews', 'original'); ?>">
                            <?php endif ?>
                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'reviews_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
