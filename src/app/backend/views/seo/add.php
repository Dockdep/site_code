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
                    <div class="table_name header_gradient">URL</div>

                    <div class="table_pages_wrapper">
                        <form method="post" action="/seo_info_add" id="news_add_edit">

                            <div class="version_1 clearfix">



                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_1">H1</label></div>
                                    <div class="input"><input id="page_title_1" type="text" name="data[h1]" value=""></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_1">URL</label></div>
                                    <div class="input"><input id="page_alias_1" type="text"  name="data[url]" value=""></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_1">SEO-text</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_1" class="page_content_text_1" name="data[seo_text]">'.(isset( $page[0]['seo_text'] ) && !empty( $page[0]['seo_text'] ) ? $page[0]['seo_text'] : '').'</textarea>' ?></div>
                                </div>



                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_title_1">title</label></div>
                                    <div class="input"><?= '<input id="page_meta_title_1" class="required" type="text" name="data[title]" value="'.(isset( $page[0]['title'] ) && !empty( $page[0]['title'] ) ? $page[0]['title'] : '').'">' ?></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_1">Meta description</label></div>
                                    <div class="input"><?= '<input id="page_meta_description_1" type="text" name="data[description]" value="'.(isset( $page[0]['description'] ) && !empty( $page[0]['description'] ) ? $page[0]['description'] : '').'">' ?></div>
                                </div>
                            </div>


                            <div class="clearfix submit_wrapper">
                                <a href="#" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>