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
                        <div class="table_name header_gradient">Рубрики</div>
						<div class="table_pages_wrapper">
						

                      

                            <?php

                            if( !empty( $rubrics ) )
                            {
                                $data_pages = '';

                                foreach( $rubrics as $p )
                                {
                                    $data_pages .=
                                        '<div class="one_page_edit header_gradient clearfix">'.
                                        '<div class="one_page_edit_check float"></div>'.
                                        '<div class="one_page_edit_name float">'.$p['name_rus'].'</div>'.
                                        '<div class="one_page_delete_ico float_right"><a href="/news_rubrics_delete/'.$p['id'].'" title="Удалить" onclick="return confirm(\'Вы действительно хотите удалить?\')"></a></div>'.
                                        '<div class="one_page_edit_ico float_right"><a href="/news_rubrics/'.$p['id'].'" title="Редактировать"></a></div>'.
                                        '</div>';
                                }


                                echo( $data_pages );
                            }

                            ?>

                        						

						<h3>Создать рубрику</h3>
						
						<div class="table_pages_wrapper">
                        <form method="post" enctype="multipart/form-data" action="">
						<?php
						if(isset($rubric[0]['id'])){
							print"<input type='hidden' name='update_id' value='".$rubric[0]['id']."' />";
						}
						?>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="image">Название (rus)</label></div>
                                <div class="input"><input type="text" name="name_rus" id="name_rus" value='<?=((isset($rubric[0]['name_rus'])) ? $rubric[0]['name_rus'] : '');?>'></div>
                            </div>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="image">Название (ukr)</label></div>
                                <div class="input"><input type="text" name="name_ukr" id="name_ukr" value='<?=((isset($rubric[0]['name_ukr'])) ? $rubric[0]['name_ukr'] : '');?>'></div>
                            </div>							
                            <div class="clearfix submit_wrapper">
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>
						</form>
						</div>
						
						</div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>						