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
                        <form enctype="multipart/form-data" method="post" action="" id="email_event_add_edit">
                            <input type="hidden" value="<?=  (isset( $page['0']['directory'] ) && !empty( $page['0']['directory'] ) ? $page['0']['directory'] : '') ?>" name="directory" id="directory">
                            <div class="version_1 clearfix">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Название шаблона</label></div>
                                    <div class="input"><input type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <input type="file" name="uploadify" id="uploadify" />
                                </div>



                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="title">Заголовок</label></div>
                                    <div class="input"><input type="text" name="title" id="title" value='<?=  (isset( $page['0']['title'] ) && !empty( $page['0']['title'] ) ? $page['0']['title'] : '') ?>'></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_1">Текст</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_1" class="page_content_text_1" name="page_content_text_1">'.(isset( $page['0']['text'] ) && !empty( $page['0']['text'] ) ? $page['0']['text'] : '').'</textarea>' ?></div>
                                </div>

                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'email_templates_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
