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
                    <div class="table_name header_gradient">Текстовая страница</div>

                    <div class="table_pages_wrapper">
                        <form method="post" action="" id="news_add_edit">
                            <?php if(isset( $page['1']['id'] ) && !empty( $page['1']['id'] )):?>
                            <div class="clearfix input_wrapper">
                                <h2 class="label">id страницы <?=$page['1']['id']?></h2>
                            </div>
                            <?php endif?>

                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1" checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>

                            <div class="version_1 clearfix">

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="page_status_1" name="page_status[1]" class="page_status" value="1" '.( isset( $page['1']['status'] ) && !empty( $page['1']['status'] ) && $page['1']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="page_status_1"><span></span>Отображать страницу</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_1">Название страницы</label></div>
                                    <div class="input"><?= '<input id="page_title_1" type="text" name="page_title[1]" value="'.(isset( $page['1']['content_title'] ) && !empty( $page['1']['content_title'] ) ? $page['1']['content_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_1">URL</label></div>
                                    <div class="input"><?= '<input id="page_alias_1" type="text"  name="page_alias[1]" value="'.(isset( $page['1']['alias'] ) && !empty( $page['1']['alias'] ) ? $page['1']['alias'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_ua">Content</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_ua" class="page_content_text_ua" name="page_content_text_ua">'.(isset( $page['1']['content_text'] ) && !empty( $page['1']['content_text'] ) ? $page['1']['content_text'] : '').'</textarea>' ?></div>
                                </div>



                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_title_1">Meta title</label></div>
                                    <div class="input"><?= '<input id="page_meta_title_1" type="text" name="page_meta_title[1]" value="'.(isset( $page['1']['meta_title'] ) && !empty( $page['1']['meta_title'] ) ? $page['1']['meta_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_keywords_1">Meta keywords</label></div>
                                    <div class="input"><?= '<input id="page_meta_keywords_1" type="text" name="page_meta_keywords[1]" value="'.(isset( $page['1']['meta_keywords'] ) && !empty( $page['1']['meta_keywords'] ) ? $page['1']['meta_keywords'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_1">Meta description</label></div>
                                    <div class="input"><?= '<textarea id="page_meta_description_1" name="page_meta_description[1]">'.(isset( $page['1']['meta_description'] ) && !empty( $page['1']['meta_description'] ) ? $page['1']['meta_description'] : '').'</textarea>' ?></div>
                                </div>
                            </div>

                            <div class="version_2 clearfix display_none">

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="page_status_2" name="page_status[2]" class="page_status" value="1" '.( isset( $page['2']['status'] ) && !empty( $page['2']['status'] ) && $page['2']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="page_status_2"><span></span>Отображать страницу</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_2">Название страницы</label></div>
                                    <div class="input"><?= '<input id="page_title_2" type="text" name="page_title[2]" value="'.(isset( $page['2']['content_title'] ) && !empty( $page['2']['content_title'] ) ? $page['2']['content_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_2">URL</label></div>
                                    <div class="input"><?= '<input id="page_alias_2" type="text"  name="page_alias[2]" value="'.(isset( $page['2']['alias'] ) && !empty( $page['2']['alias'] ) ? $page['2']['alias'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_ru">Content</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_ru" name="page_content_text_ru">'.(isset( $page['2']['content_text'] ) && !empty( $page['2']['content_text'] ) ? $page['2']['content_text'] : '').'</textarea>' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_title_2">Meta title</label></div>
                                    <div class="input"><?= '<input id="page_meta_title_2" type="text" name="page_meta_title[2]" value="'.(isset( $page['2']['meta_title'] ) && !empty( $page['2']['meta_title'] ) ? $page['2']['meta_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_keywords_2">Meta keywords</label></div>
                                    <div class="input"><?= '<input id="page_meta_keywords_2" type="text" name="page_meta_keywords[2]" value="'.(isset( $page['2']['meta_keywords'] ) && !empty( $page['2']['meta_keywords'] ) ? $page['2']['meta_keywords'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_2">Meta description</label></div>
                                    <div class="input"><?= '<textarea id="page_meta_description_2" name="page_meta_description[2]">'.(isset( $page['2']['meta_description'] ) && !empty( $page['2']['meta_description'] ) ? $page['2']['meta_description'] : '').'</textarea>' ?></div>
                                </div>
                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'static_page' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>