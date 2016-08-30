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
                    <div class="table_name header_gradient">Лимит</div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="news_add_edit">

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="id">Номер</label></div>
                                    <div class="input"><input disabled type="text" name="id" id="id" value='<?=  (isset( $page['0']['id'] ) && !empty( $page['0']['id'] ) ? $page['0']['id'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="limit">Лимит</label></div>
                                    <div class="input"><input type="text" name="limit" id="limit" value='<?=  (isset( $page['0']['limit'] ) && !empty( $page['0']['limit'] ) ? $page['0']['limit'] : '') ?>'></div>
                                </div>
                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'actions_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

