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
                    <div class="table_name header_gradient">Загрузка PDF фaйла</div>

                    <div class="table_pages_wrapper">
                        <form  enctype="multipart/form-data" method="post" action="">

                            <div class="input-group">
                                <div class="label"><label for="name">Файл</label></div>
                                <div class="input"><input type="file" name="file" id="name" value=''></div>
                            </div>

                            <div class="input-group">
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>