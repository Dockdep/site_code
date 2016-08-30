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
                            <input type="hidden" value="<?=  (isset( $page['0']['id'] ) && !empty( $page['0']['main_id'] ) ? $page['0']['main_id'] : '') ?>" name="section_id">
                            <div class="clearfix input_wrapper">

                                <div class="clearfix input_wrapper" >
                                    <div class="label"><label for="email">Список Емейлов</label></div>
                                    <div class="input"><textarea id="email" class="template" name="email"><?= (isset( $temp ) && !empty( $temp ) ? $temp : '') ?></textarea></div>
                                </div>
                            </div>


                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'admin_email_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
