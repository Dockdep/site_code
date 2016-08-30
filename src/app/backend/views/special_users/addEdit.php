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
                    <div class="table_name header_gradient">Пользователи</div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="news_add_edit">

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Имя</label></div>
                                    <div class="input"><input disabled type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Скидка</label></div>
                                    <div class="input"><input min="1" max="20" type="number" name="discount" id="discount" value='<?=  (isset( $page['0']['discount'] ) && !empty( $page['0']['discount'] ) ? $page['0']['discount'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Годовой бюджет</label></div>
                                    <div class="input"><input type="number" name="year_budget" id="year_budget" value='<?=  (isset( $page['0']['year_budget'] ) && !empty( $page['0']['year_budget'] ) ? $page['0']['year_budget'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="name">Первый заказ</label></div>
                                    <div class="input"><input type="number" name="first_order" id="first_order" value='<?=  (isset( $page['0']['first_order'] ) && !empty( $page['0']['first_order'] ) ? $page['0']['first_order'] : '') ?>'></div>
                                </div>
                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'special_users_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>