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
                        <form enctype="multipart/form-data" method="post" action="/set_reconciliation" id="email_event_add_edit">

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="name">Эмейлы*</label></div>
                                <div class="input"><textarea name="text"><?= $page['text']?></textarea></div>
                            </div>
                            <div class="clearfix submit_wrapper">
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>