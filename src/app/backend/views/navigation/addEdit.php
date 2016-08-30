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
                    <div class="table_name header_gradient">Меню</div>

                    <div class="table_pages_wrapper">
                        <form method="post" enctype="multipart/form-data" action="" id="news_add_edit">
                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1"  checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>

                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="page_status_1" name="status" class="page_status" value="1" '.( isset( $page['1']['status'] ) && !empty( $page['1']['status'] ) && $page['1']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                <label for="page_status_1"><span></span>Отображать в меню</label>
                            </div>

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Url</label></div>
                                    <div class="input"><input type="text" name="url_1" id="url" value='<?=  (isset( $page['1']['url'] ) && !empty( $page['1']['url'] ) ? $page['1']['url'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Название</label></div>
                                    <div class="input"><input type="text" name="name_1" id="name" value='<?=  (isset( $page['1']['name'] ) && !empty( $page['1']['name'] ) ? $page['1']['name'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Вес</label></div>
                                    <div class="input"><input type="text" name="weight_1" id="weight" value='<?=  (isset( $page['1']['weight'] ) && !empty( $page['1']['weight'] ) ? $page['1']['weight'] : '') ?>'></div>
                                </div>


                            </div>

                            <div class="version_2 clearfix display_none">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Url</label></div>
                                    <div class="input"><input type="text" name="url_2" id="url" value='<?=  (isset( $page['2']['url'] ) && !empty( $page['2']['url'] ) ? $page['2']['url'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Название</label></div>
                                    <div class="input"><input type="text" name="name_2" id="name" value='<?=  (isset( $page['2']['name'] ) && !empty( $page['2']['name'] ) ? $page['2']['name'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Вес</label></div>
                                    <div class="input"><input type="text" name="weight_2" id="weight" value='<?=  (isset( $page['2']['weight'] ) && !empty( $page['2']['weight'] ) ? $page['2']['weight'] : '') ?>'></div>
                                </div>

                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'news_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>