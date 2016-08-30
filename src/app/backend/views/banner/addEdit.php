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
                    <div class="table_name header_gradient">Рекламный баннер</div>

                    <div class="table_pages_wrapper">
                        <form method="post" enctype="multipart/form-data" action="" id="banner_add_edit">
                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1"  checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>

                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="page_status_1" name="status" class="page_status" value="1" '.( isset( $page['1']['status'] ) && !empty( $page['1']['status'] ) && $page['1']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                <label for="page_status_1"><span></span>Отображать банер</label>
                            </div>

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="image_1">Картинка</label></div>
                                    <div class="input"><input type="file" name="image_1"  value=''></div>
                                </div>
                                <?php if(isset( $page['1']['image'] ) && !empty( $page['1']['image'] )):?>
                                    <img style="width: 768px; height: 128px;" src="<?=$this->storage->getBanerUrl($page['1']['image'])?>">
                                <?php endif ?>
                                <input type="hidden" name="existing_image_1" id="image_1" value='<?=  (isset( $page['1']['image'] ) && !empty( $page['1']['image'] ) ? $page['1']['image'] : '') ?>'>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name_1">Название</label></div>
                                    <div class="input"><input type="text" name="name_1" id="name_1" value='<?=  (isset( $page['1']['name'] ) && !empty( $page['1']['name'] ) ? $page['1']['name'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="link_1">Ссылка</label></div>
                                    <div class="input"><input type="text" name="link_1" id="link_1" value='<?=  (isset( $page['1']['link'] ) && !empty( $page['1']['link'] ) ? $page['1']['link'] : '') ?>'></div>
                                </div>


                            </div>

                            <div class="version_2 clearfix display_none">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="image_2">Картинка</label></div>
                                    <div class="input"><input type="file" name="image_2" id="image_2" value=''></div>
                                </div>
                                <?php if(isset( $page['2']['image'] ) && !empty( $page['2']['image'] )):?>
                                    <img style="width: 768px; height: 128px;" src="<?=$this->storage->getBanerUrl($page['2']['image'])?>">
                                <?php endif ?>
                                <input type="hidden" name="existing_image_2" value='<?=  (isset( $page['2']['image'] ) && !empty( $page['2']['image'] ) ? $page['2']['image'] : '') ?>'>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name_2">Название</label></div>
                                    <div class="input"><input type="text" name="name_2" id="name_2" value='<?=  (isset( $page['2']['name'] ) && !empty( $page['2']['name'] ) ? $page['2']['name'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="link_2">Ссылка</label></div>
                                    <div class="input"><input type="text" name="link_2" id="link_2" value='<?=  (isset( $page['2']['link'] ) && !empty( $page['2']['link'] ) ? $page['2']['link'] : '') ?>'></div>
                                </div>

                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'banner_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>