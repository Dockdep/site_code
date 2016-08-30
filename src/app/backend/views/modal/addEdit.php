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
                    <div class="table_name header_gradient">Модальное окно</div>

                    <div class="table_pages_wrapper">
                        <form method="post" enctype="multipart/form-data" action="" id="banner_add_edit">
                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1"  checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>

                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="page_status_1" name="status" class="page_status" value="1" '.( isset( $page['1']['status'] ) && !empty( $page['1']['status'] ) && $page['1']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                <label for="page_status_1"><span></span>Отображать Модальное окно</label>
                            </div>

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="text_1">Текст</label></div>
                                    <div class="input"><input type="text" name="text_1" id="text_1" value='<?=  (isset( $page['1']['text'] ) && !empty( $page['1']['text'] ) ? $page['1']['text'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="link_1">Ссылка</label></div>
                                    <div class="input"><input type="text" name="link_1" id="link_1" value='<?=  (isset( $page['1']['link'] ) && !empty( $page['1']['link'] ) ? $page['1']['link'] : '') ?>'></div>
                                </div>


                            </div>

                            <div class="version_2 clearfix display_none">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="text_2">Текст</label></div>
                                    <div class="input"><input type="text" name="text_2" id="text_2" value='<?=  (isset( $page['2']['text'] ) && !empty( $page['2']['text'] ) ? $page['2']['text'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="link_2">Ссылка</label></div>
                                    <div class="input"><input type="text" name="link_2" id="link_2" value='<?=  (isset( $page['2']['link'] ) && !empty( $page['2']['link'] ) ? $page['2']['link'] : '') ?>'></div>
                                </div>

                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'modal_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>