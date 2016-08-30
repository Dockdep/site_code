<div id="static_page">
    <div class="inner"><?= $this->flash->output(); ?></div>
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">
                    <?= $this->partial('partial/sidebar') ?>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="h_700">
                    <div class="content_wrapper_list clearfix">
                        <div class="table_name header_gradient">промокоды</div>
                        <div class="table_add_page"><a href="<?= $this->url->get([ 'for' => 'promo_codes_add' ]) ?>" title="Добавить">Добавить</a></div>

                        <div class="table_pages_wrapper">

                            <?php

                            if( !empty( $info ) )
                            {
                                $data_pages = '';

                                foreach( $info as $p )
                                {
                                    $data_pages .=
                                        '<div class="one_page_edit header_gradient clearfix">'.
                                        '<div class="one_page_edit_check float"></div>'.
                                        '<div class="one_page_edit_name float"><a href="/promo_codes_update/'.$p['id'].'" title="">'.$p['name'].'</a></div>'.
                                        '<div class="one_page_delete_ico float_right"><a href="/promo_codes_delete/'.$p['id'].'" title="Удалить" onclick="return confirm(\'Вы действительно хотите удалить информацию?\')"></a></div>'.
                                        '<div class="one_page_edit_ico float_right"><a href="/promo_codes_update/'.$p['id'].'" title="Редактировать"></a></div>'.
                                        '</div>';
                                }


                                echo( $data_pages );
                            }

                            ?>

                        </div>

                    </div>
                    <div class="inner">
                        <div class="paginate">
                            <?=$paginate?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
