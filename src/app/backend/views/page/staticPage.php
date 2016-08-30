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
                        <div class="table_name header_gradient">Текстовые страницы</div>
                        <div class="table_add_page"><a href="<?= $this->url->get([ 'for' => 'static_page_add' ]) ?>" title="Добавить страницу сайта">Добавить страницу сайта</a></div>

                        <div class="table_pages_wrapper">

                        <?php

                        if( !empty( $pages ) )
                        {
                            $data_pages = '';

                            foreach( $pages as $p )
                            {
                                $data_pages .=
                                    '<div class="one_page_edit header_gradient clearfix">'.
                                        '<div class="one_page_edit_check float"></div>'.
                                        '<div class="one_page_edit_name float"><a href="'.$this->url->get([ 'for' => 'static_page_edit', 'page_id' => $p['id'] ]).'" title="">'.$p['content_title'].'</a></div>'.

                                        '<div class="one_page_video_ico float_right"><a href="#" title=""></a></div>'.
                                        '<div class="one_page_photos_ico float_right"><a href="#" title=""></a></div>'.
                                        '<div class="one_page_view_ico float_right"><a href="#" title=""></a></div>'.
                                        '<div class="one_page_delete_ico float_right"><a href="'.$this->url->get([ 'for' => 'static_page_delete', 'page_id' => $p['id'] ]).'" title="Удалить страницу" onclick="return confirm(\'Вы действительно хотите удалить страницу?\')"></a></div>'.
                                        '<div class="one_page_edit_ico float_right"><a href="'.$this->url->get([ 'for' => 'static_page_edit', 'page_id' => $p['id'] ]).'" title="Редактировать страницу"></a></div>'.
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

 